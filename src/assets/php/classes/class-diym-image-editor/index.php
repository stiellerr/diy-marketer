<?php
/**
 * DIY Marketer image editor
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelEntryUserComment;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryRational;
use lsolesen\pel\PelEntryByte;

if ( ! class_exists( 'DIYM_Image_Editor' ) ) {

    class DIYM_Image_Editor {

        function __construct() {

            add_filter( 'wp_generate_attachment_metadata', array( &$this, 'wp_generate_attachment_metadata' ), 10, 3 );

            add_filter( 'wp_save_image_editor_file', array( &$this, 'wp_save_image_editor_file' ), 10, 5 );

            add_filter( 'jpeg_quality', array( &$this, 'jpeg_quality' ), 10, 2 );

            require_once( dirname( __FILE__ ) . '/pel/autoload.php' );
        }

        // default is 82 but doesnt do the 'full' image. therefore, we will disable it and do our own compression
        function jpeg_quality( $quality, $context ) {

            $quality = 100;

            return $quality;

        }

        function wp_generate_attachment_metadata( $metadata, $attachment_id, $context ) {

            /*
            if ( ! function_exists( 'imageinterlace' ) ) {
                return $metadata;
            }
            */

            if ( ! class_exists( 'Imagick' ) ) {
                return $metadata;
            }

            $image = get_post( $attachment_id );
        
            $meta = wp_parse_args(
                $metadata['sizes'],
                array(
                    'full' => array(
                        'file' => basename( $metadata[ 'file' ] ),
                        'width' => $metadata[ 'width' ],
                        'height' => $metadata[ 'height' ],
                        'mime-type' => $image->post_mime_type
                    )
                )
            );
            
            if ( $image && isset( $metadata['file'] ) ) {
        
                $source_dir = dirname( get_attached_file( $image->ID ) );
        
                $gps = get_option( 'diym_map', null );
        
                $description = ucwords( str_replace( '-', ' ', $image->post_title ) );
        
                foreach( $meta as $data ) {
        
                    $name = basename( $data[ 'file' ] );
                    $mimetype = (string) $data[ 'mime-type' ];
                    // these need to be seperate, causes issues otherwise...
                    $inp = $source_dir . '/' . $name;
                    $out = $source_dir . '/' . $name;
        
                    if ( ! file_exists( $inp ) ) {
                        continue;
                    }
        
                    switch ( $mimetype ) {
                        case 'image/jpeg':

                            //this can also be done with Imagick, not sure which is better...
                            $imagick = new Imagick( $inp );
                            $imagick->setInterlaceScheme( Imagick::INTERLACE_PLANE );
                            $imagick->setImageCompressionQuality( 82 );
                            $imagick->writeImage();
                            $imagick->clear();
                            
                            //$temp = imagecreatefromjpeg( $inp );
                            //imageinterlace($temp, 1);
                            //imagejpeg( $temp, $inp, 82 ); //quality is set to 82 ( this is what wp was... )
                            //imagedestroy( $temp );

                            // geo code the images...
                            //if ( $gps[ 'lng' ] && $gps[ 'lat' ] ) {
                                $this->addGpsInfo( $inp,
                                    $inp,
                                    $description,
                                    $description,
                                    "iPhone XS Max",
                                    $gps[ 'lng' ],
                                    $gps[ 'lat' ],
                                    0,
                                    "2020:01:01 00:00:00"
                                );
                            //}

                            // save images as progressive then compress
                            // this has to go before exif markup otherwise it will strip it
                            //write_log('open file before progressive conv');

                        break;
                    }
                }
            }
            return $metadata;            
        }

        /**
         * Convert a decimal degree into degrees, minutes, and seconds.
         *
         * @param
         *            int the degree in the form 123.456. Must be in the interval
         *            [-180, 180].
         *
         * @return array a triple with the degrees, minutes, and seconds. Each
         *         value is an array itself, suitable for passing to a
         *         PelEntryRational. If the degree is outside the allowed interval,
         *         null is returned instead.
         */
        function convertDecimalToDMS($degree) {
            
            if ($degree > 180 || $degree < - 180) {
                return null;
            }

            $degree = abs($degree); // make sure number is positive
                                    // (no distinction here for N/S
                                    // or W/E).

            $seconds = $degree * 3600; // Total number of seconds.

            $degrees = floor($degree); // Number of whole degrees.
            $seconds -= $degrees * 3600; // Subtract the number of seconds
                                        // taken by the degrees.

            $minutes = floor($seconds / 60); // Number of whole minutes.
            $seconds -= $minutes * 60; // Subtract the number of seconds
                                    // taken by the minutes.

            $seconds = round($seconds * 100, 0); // Round seconds with a 1/100th
                                                // second precision.

            return [
                [
                    $degrees,
                    1
                ],
                [
                    $minutes,
                    1
                ],
                [
                    $seconds,
                    100
                ]
            ];
        }

        /**
         * Add GPS information to an image basic metadata.
         * Any old Exif data
         * is discarded.
         *
         * @param
         *            string the input filename.
         *
         * @param
         *            string the output filename. An updated copy of the input
         *            image is saved here.
         *
         * @param
         *            string image description.
         *
         * @param
         *            string user comment.
         *
         * @param
         *            string camera model.
         *
         * @param
         *            float longitude expressed as a fractional number of degrees,
         *            e.g. 12.345�. Negative values denotes degrees west of Greenwich.
         *
         * @param
         *            float latitude expressed as for longitude. Negative values
         *            denote degrees south of equator.
         *
         * @param
         *            float the altitude, negative values express an altitude
         *            below sea level.
         *
         * @param
         *            string the date and time.
         */
        function addGpsInfo( $input, $output, $description, $comment, $model, $longitude = 0, $latitude = 0, $altitude = 0, $date_time ) {

            /* Load the given image into a PelJpeg object */
            $jpeg = new PelJpeg($input);

            /*
            * Create and add empty Exif data to the image (this throws away any
            * old Exif data in the image).
            */
            $exif = new PelExif();
            $jpeg->setExif($exif);

            /*
            * Create and add TIFF data to the Exif data (Exif data is actually
            * stored in a TIFF format).
            */
            $tiff = new PelTiff();
            $exif->setTiff($tiff);

            /*
            * Create first Image File Directory and associate it with the TIFF
            * data.
            */
            $ifd0 = new PelIfd(PelIfd::IFD0);
            $tiff->setIfd($ifd0);

            if ( $longitude || $latitude || $altitude ) {

                /*
                * Create a sub-IFD for holding GPS information. GPS data must be
                * below the first IFD.
                */
                $gps_ifd = new PelIfd(PelIfd::GPS);
                $ifd0->addSubIfd($gps_ifd);

                /*
                * Create a sub-IFD for holding GPS information. GPS data must be
                * below the first IFD.
                */
                $gps_ifd = new PelIfd(PelIfd::GPS);
                $ifd0->addSubIfd($gps_ifd);

                $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));

                /*
                * Use the convertDecimalToDMS function to convert the latitude from
                * something like 12.34� to 12� 20' 42"
                */
                list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($latitude);
    
                /* We interpret a negative latitude as being south. */
                $latitude_ref = ($latitude < 0) ? 'S' : 'N';
    
                $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
                $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));
    
                /* The longitude works like the latitude. */
                list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($longitude);
                $longitude_ref = ($longitude < 0) ? 'W' : 'E';
    
                $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
                $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));
    
                /*
                * Add the altitude. The absolute value is stored here, the sign is
                * stored in the GPS_ALTITUDE_REF tag below.
                */
                $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
                    abs($altitude),
                    1
                ]));
                /*
                * The reference is set to 1 (true) if the altitude is below sea
                * level, or 0 (false) otherwise.
                */
                $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));

            }

            /*
            * The USER_COMMENT tag must be put in a Exif sub-IFD under the
            * first IFD.
            */
            $exif_ifd = new PelIfd(PelIfd::EXIF);
            $exif_ifd->addEntry(new PelEntryUserComment($comment));
            $ifd0->addSubIfd($exif_ifd);

            $inter_ifd = new PelIfd(PelIfd::INTEROPERABILITY);
            $ifd0->addSubIfd($inter_ifd);

            $ifd0->addEntry(new PelEntryAscii(PelTag::MODEL, $model));
            $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
            $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description));
            
            /* Finally we store the data in the output file. */
            file_put_contents($output, $jpeg->getBytes());
        }

        function wp_save_image_editor_file( $override, $filename, $image, $mime_type, $post_id ) {

            if ( 'image/jpeg' !== $mime_type && 'image/png' !== $mime_type ) {
                return $override;
            }

            $image_meta = wp_get_attachment_metadata( $post_id );
            $upload_dir = wp_upload_dir();
        
            $original_file_path = path_join( $upload_dir['basedir'], $image_meta['file'] );
        
            // 'full dir' includes year and mouth location
            $upload_full_dir = str_replace( basename( $original_file_path ), '', $original_file_path );
        
            // delete original image
            unlink( $original_file_path );
        
            // delete other sizes
            foreach ( $image_meta['sizes'] as $size ) {
                unlink( $upload_full_dir . $size['file'] );
            }
            // regenerate added sizes
            function regenerate_added_sizes( $meta_id, $object_id, $meta_key ) {
                if ( '_wp_attachment_metadata' !== $meta_key ) {
                    return;
                }
                $image_meta = wp_get_attachment_metadata( $object_id );
                $upload_dir = wp_upload_dir();
        
                $new_file_path = path_join( $upload_dir['basedir'], $image_meta['file'] );
        
                // prevent infinite loops
                remove_action( 'updated_post_meta', 'regenerate_added_sizes' );
        
                update_post_meta( $object_id, $meta_key, wp_generate_attachment_metadata( $object_id, $new_file_path ) );
            }
            add_action( 'updated_post_meta', 'regenerate_added_sizes', 10, 3 );
        
            return $override;

        }
    }
}

//image_editor_save_pre

?>