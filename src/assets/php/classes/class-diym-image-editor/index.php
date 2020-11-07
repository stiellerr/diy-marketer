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

            if ( isset( $_REQUEST[ 'action' ] ) && 'get-attachment' == $_REQUEST[ 'action' ] ) {
                // filter meta before it is sent to js
                add_filter( 'wp_prepare_attachment_for_js', array( &$this, 'wp_prepare_attachment_for_js' ), 10, 3 );
            }

            add_filter( 'wp_generate_attachment_metadata', array( &$this, 'wp_generate_attachment_metadata' ), 10, 3 );

            add_filter( 'wp_save_image_editor_file', array( &$this, 'wp_save_image_editor_file' ), 10, 5 );

            add_filter( 'wp_handle_upload', array( &$this, 'wp_handle_upload' ), 10, 2 );

            require_once( dirname( __FILE__ ) . '/pel/autoload.php' );
        }


        function wp_handle_upload( $upload, $context ) {

            //--> if upload is a jpeg, intercept it and write exif data to it...
            if ( 'image/jpeg' == $upload[ 'type' ] ) {
                
                // --> build a description based on the file name...
                $description = ucwords( str_replace( '-', ' ', pathinfo( $upload[ 'file' ], PATHINFO_FILENAME ) ) );

                $gps = get_option( 'diym_map', null );
                
                $this->addGpsInfo( $upload[ 'file' ],
                    $upload[ 'file' ],
                    $description,
                    $description,
                    "iPhone XS Max",
                    $gps[ 'lng' ],
                    $gps[ 'lat' ],
                    0,
                    "2020:01:01 00:00:00"
                );
            }

            return $upload;
        }

        //--> Use this when uploading a new image...
        function wp_generate_attachment_metadata( $metadata, $attachment_id, $context ) {

            // save new image...
            $this->diym_save_image_filter( $metadata, $attachment_id, $context );
            
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
        public function addGpsInfo( $input, $output, $description, $comment, $model, $longitude = 0, $latitude = 0, $altitude = 0, $date_time ) {

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

        function diym_strip_junk( $haystack ) {

            return preg_replace( '/-e[0-9]{13}/', '',  $haystack );

        }


        function diym_save_image_filter( $image_meta, $image_id, $context ) {

            $image = get_post( $image_id );

            if ( $image && isset( $image_meta['file'] ) ) {

                $image_meta[ 'sizes' ][ 'full' ] = array(
                    'file'      => basename( $image_meta[ 'file' ] ),
                    'width'     => $image_meta[ 'width' ],
                    'height'    => $image_meta[ 'height' ],
                    'mime-type' => $image->post_mime_type
                );

                $path = dirname( get_attached_file( $image->ID ) );
        
                foreach( $image_meta[ 'sizes' ] as $size => &$data ) {
        
                    $base = basename( $data[ 'file' ] );
                    $mimetype = (string) $data[ 'mime-type' ];
                    // these need to be seperate, causes issues otherwise...

                    $file = path_join( $path, $base );
        
                    if ( ! file_exists( $file ) ) {
                        continue;
                    }
                    
                    if ( 'image/jpeg' == $mimetype || 'image/png' == $mimetype ) {
                        // if image is new, and size is full, open file and compress it. wp doesnt do the original by default...
                        if ( 'full' == $size && 'create' == $context ) {
                            $editor = wp_get_image_editor( $file );
                            $editor->save( $file, $mimetype );
                            unset( $editor );
                        }
                    }
                    
                    if ( 'image/jpeg' == $mimetype || 'image/gif' == $mimetype ) {
                        if ( class_exists( 'Imagick' ) ) {
                            $imagick = new Imagick( $file );

                            // set interlacing if not set...
                            if ( imagick::INTERLACE_PLANE !== $imagick->getInterlaceScheme() ) {
                                $imagick->setInterlaceScheme( imagick::INTERLACE_PLANE );
                                $imagick->writeImage();
                            }
                            
                            $imagick->clear();
                            $imagick->destroy();
                            unset( $imagick );

                            //$temp = imagecreatefromjpeg( $inp );
                            //imageinterlace($temp, 1);
                            //imagejpeg( $temp, $inp, 82 ); //quality is set to 82 ( this is what wp was... )
                            //imagedestroy( $temp );
                        }
                    }

                    //  ******
                    if ( 'edit' == $context ) {
                        $data[ 'file' ] = $this->diym_strip_junk( $data[ 'file' ] );

                        $new_file = $this->diym_strip_junk( $file );

                        //wp_delete_file( $new_file );

                        rename( $file, $new_file );
                    }
                    //  ******
                    
                }

                //  ******

                if ( 'edit' == $context ) {

                    

                    //
                    //write_log( $file );

                    //$new_file = $this->diym_strip_junk( $file );

                    //write_log( $new_file );
    
                    //rename( $file, $new_file );
    
                    //update_attached_file( $image_id, $new_file );
    
                    unset( $image_meta[ 'sizes' ][ 'full' ] );
    
                    $image_meta[ 'file' ] = $this->diym_strip_junk( $image_meta[ 'file' ] );
    
                    //wp_update_attachment_metadata( $image_id, $image_meta );

                    //remove_action( 'updated_post_meta', array( &$this, 'updated_post_meta' ) );

                    //$zzzz = wp_generate_attachment_metadata( $image_id, $new_file );

                    //write_log( $zzzz );
    
                    //update_post_meta( $image_id, '_wp_attachment_metadata', $zzzz );

                    //write_log( $image_meta );

                    update_post_meta( $image_id, '_wp_attachment_metadata', $image_meta );

                    // delete all the backup sizes...
                    //delete_post_meta( $image_id, '_wp_attachment_backup_sizes' );

                    update_attached_file( $image_id, $new_file );

                    //write_log( get_post( $image_id ) );

                    //write_log( get_post_meta( $image_id ) );
    
                    //write_log( wp_generate_attachment_metadata( $image_id, $new_file ) );

                }

                //  ******


            }
        }

        // add version numbers to edit images to prevent browser caching them
        function wp_prepare_attachment_for_js( $response, $attachment, $meta ) {

            foreach( $response[ 'sizes' ] as &$size ) {
                $size[ 'url' ] .= '?v=' . time();
            }
        
            return $response;
        
        }

        function updated_post_meta( $meta_id, $object_id, $meta_key, $_meta_value ) {
            
            if ( '_wp_attachment_metadata' !== $meta_key ) {
                return;
            }

            $this->diym_save_image_filter( $_meta_value, $object_id, 'edit' );

        }

        function wp_save_image_editor_file( $override, $filename, $image, $mime_type, $post_id ) {
            
            add_action( 'updated_post_meta', array( &$this, 'updated_post_meta' ), 10, 4 );

            return $override;
        }
    }
}

?>