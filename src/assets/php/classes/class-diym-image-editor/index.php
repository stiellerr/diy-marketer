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

            //add_filter( 'jpeg_quality', array( &$this, 'jpeg_quality' ), 10, 2 );

            //add_filter( 'updated_post_meta', array( &$this, 'updated_post_meta' ), 10, 4 );

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

        // default is 82 but doesnt do the 'full' image. therefore, we will disable it and do our own compression
        function jpeg_quality( $quality, $context ) {

            $quality = 100;

            return $quality;

        }

        //--> Use this when uploading a new image...
        function wp_generate_attachment_metadata( $metadata, $attachment_id, $context ) {

            if ( $this->save_image_as_progressive( $metadata, $attachment_id, $context ) ) {
                return $metadata;
            }
            
            
            /*
            if ( ! function_exists( 'imageinterlace' ) ) {
                return $metadata;
            }
            */

            if ( ! class_exists( 'Imagick' ) ) {
                return $metadata;
            }

            $image = get_post( $attachment_id );
            
            if ( $image && isset( $metadata['file'] ) ) {

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
        
                $source_dir = dirname( get_attached_file( $image->ID ) );
        
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

        function save_image_as_progressive( $image_meta, $image_id, $context ) {

            $image = get_post( $image_id );

            if ( $image && isset( $image_meta['file'] ) ) {

                $sizes = wp_parse_args(
                    $image_meta[ 'sizes' ],
                    array(
                        'full' => array(
                            'file'      => basename( $image_meta[ 'file' ] ),
                            'width'     => $image_meta[ 'width' ],
                            'height'    => $image_meta[ 'height' ],
                            'mime-type' => $image->post_mime_type
                        )
                    )
                );

                $path = dirname( get_attached_file( $image->ID ) );
        
                foreach( $sizes as $size ) {
        
                    $base = basename( $size[ 'file' ] );
                    $mimetype = (string) $size[ 'mime-type' ];
                    // these need to be seperate, causes issues otherwise...

                    $file = path_join( $path, $base );
        
                    if ( ! file_exists( $file ) ) {
                        continue;
                    }

                    if ( 'image/jpeg' == $mimetype ) {

                        //
                        if ( class_exists( 'Imagick' ) ) {
                            
                            //$imagick = new Imagick( $file );

                            //wp_get_image_editor($path, $args)

                            $editor = wp_get_image_editor( $file );

                            write_log( $editor );


                            //$editor->load();

                           // write_log( $aaa->image );

                            /*
                            // set interlacing if not set...
                            if ( imagick::INTERLACE_PLANE !== $imagick->getInterlaceScheme() ) {
                                $imagick->setInterlaceScheme( imagick::INTERLACE_PLANE );
                                $imagick->writeImage();
                            }
                            */
                            //$sss = $imagick->getImageCompressionQuality();
                            //$this->image->setImageCompression( imagick::COMPRESSION_JPEG );

                            //write_log( $sss );

                            //$imagick->clear();
                            //$this->image->destroy();
                            //unset( $imagick );
                            
                        }

                    }
        
                    //switch ( $mimetype ) {
                        //case 'image/jpeg':

                            //this can also be done with Imagick, not sure which is better...
                            //$imagick = new Imagick( $inp );
                            //$imagick->setInterlaceScheme( Imagick::INTERLACE_PLANE );
                            //$imagick->setImageCompressionQuality( 82 );
                            //$imagick->writeImage();
                            //$imagick->clear();
                            
                            //$temp = imagecreatefromjpeg( $inp );
                            //imageinterlace($temp, 1);
                            //imagejpeg( $temp, $inp, 82 ); //quality is set to 82 ( this is what wp was... )
                            //imagedestroy( $temp );


                        //break;
                    //}
                }

                // loop through sizes

            }

            

            //$dir = dirname( get_attached_file( $image->ID ) );

            /*
            imagick::INTERLACE_UNDEFINED (0)
            imagick::INTERLACE_NO (1)
            imagick::INTERLACE_LINE (2)
            imagick::INTERLACE_PLANE (3)
            imagick::INTERLACE_PARTITION (4)
            imagick::INTERLACE_GIF (5)
            imagick::INTERLACE_JPEG (6)
            imagick::INTERLACE_PNG (7)

            Imagick::getImageInterlaceScheme ( ) : int
            */
            //write_log( $image );
            //write_log( $image_meta );
            
            //$upload_dir = wp_upload_dir();

            //write_log( $sizes );

            

            return true;

        }

        function updated_post_meta( $meta_id, $object_id, $meta_key, $_meta_value ) {
            
            if ( '_wp_attachment_metadata' !== $meta_key ) {
                return;
            }

            if ( $this->save_image_as_progressive( $_meta_value, $object_id, 'edit' ) ) {
                return;
            }

        }



        function wp_save_image_editor_file( $override, $filename, $image, $mime_type, $post_id ) {

            //if ( 'image/jpeg' !== $mime_type && 'image/png' !== $mime_type ) {
                //return $override;
            //}

            //$post = get_post( $post_id );

            // get new file name -->
            //$file_name = basename( $post->guid );

            //$image_meta = wp_get_attachment_metadata( $post_id );


            // get old file name -->
            //$image_before = basename( $image_meta['file'] );
            //write_log( $image_meta['file'] );

            // get directory -->
            //$dir = dirname( get_attached_file( $post->ID ) );

            // create full path -->
            //$path_before = path_join( $dir, $image_before );

            //write_log( $file_path );

            
            //$upload_dir = wp_upload_dir();

            //write_log( $image_meta );

            //$original_file_path = path_join( $upload_dir['basedir'], $image_meta['file'] );

            //write_log( $original_file_path );
        
            // 'full dir' includes year and mouth location
            //$upload_full_dir = str_replace( basename( $original_file_path ), '', $original_file_path );
        
            // delete before image
            //wp_delete_file( $path_before );
        
            // delete other sizes
            //foreach ( $image_meta['sizes'] as $size ) {
                //wp_delete_file( path_join( $dir, $size['file'] ) );
            //}

            // regenerate added sizes
            
            function diym_updated_post_meta( $meta_id, $object_id, $meta_key, $_meta_value ) {

                //$post = get_post( $object_id );

                // get new file name -->
                //$file_name = basename( $post->guid );
    
                //$image_meta = wp_get_attachment_metadata( $post_id );

                //write_log( $meta_id );
                //write_log( $object_id );
                //write_log( $meta_key );
               // write_log( $_meta_value );


                if ( '_wp_attachment_metadata' !== $meta_key ) {
                    return;
                }

                if ( self::save_image_as_progressive( $_meta_value ) ) {
                    return;
                }

                //
                // convert images to progressive here
                //

                //write_log( $meta_id );
                //write_log( $object_id );
                //write_log( $meta_key );
                //write_log( $_meta_value );



                //$image_meta = wp_get_attachment_metadata( $object_id );
                //write_log( $image_meta );

                //$image = get_post( $object_id );

                // get new file name -->
                //$file_name = basename( $image->guid );
            
                // get directory -->
                //$dir = dirname( get_attached_file( $image->ID ) );
            
                // create full path -->
                //$file_path = path_join( $dir, $file_name );

                // new file...
                //$new_file = basename( $_meta_value[ 'file' ] );

                // create full path -->
                //$new_path = path_join( $dir, $new_file );                
                
                
                //rename( $new_path, $old_path );

                //write_log( $new_file );

                // rename new back to old
                //rename("/test/file1.txt","/home/docs/my_file.txt");

                // prevent infinite loops
                //remove_action( 'updated_post_meta', 'diym_updated_post_meta' );


                //$image_meta = wp_get_attachment_metadata( $object_id );
            
                //write_log( $image_meta );



                //update_post_meta( $object_id, $meta_key, wp_generate_attachment_metadata( $object_id, $old_path ) );

                //write_log( 'done...' );

                //$image_meta = wp_get_attachment_metadata( $object_id );

                //$image2 = get_post( $object_id );
            
                //write_log( $image_meta );
                //write_log( $image2 );

                //$image_meta = wp_get_attachment_metadata( $object_id );

                //write_log( $image_meta );
/*
                if ( '_wp_attachment_metadata' !== $meta_key ) {
                    return;
                }
                $image_meta = wp_get_attachment_metadata( $object_id );

                //write_log( $meta_id );
                //write_log( $object_id );
                //write_log( $meta_key );

                $zzz = '2020/10/' . 'zzztest.jpg';


                $upload_dir = wp_upload_dir();

                write_log( $upload_dir );
                write_log( $image_meta );
                //write_log( $meta_key );
        
                //$new_file_path = path_join( $upload_dir['basedir'], $image_meta['file'] );
                $new_file_path = path_join( $upload_dir['basedir'], $zzz );

                write_log( $new_file_path );
        
                // prevent infinite loops
                */
                //remove_action( 'updated_post_meta', 'diym_updated_post_meta' );

                //write_log( 'zzz' );
                //update_attached_file( $object_id, $file_path );
                //update_post_meta( $object_id, '_wp_attachment_metadata', wp_generate_attachment_metadata( $object_id, $file_path ) );
                

                //write_log( get_post_meta( $object_id ) );

            }
            
            add_action( 'updated_post_meta', array( &$this, 'updated_post_meta' ), 10, 4 );

            //return $override;

            //write_log( $original_file_path );

            //$saved = $image->save( $file_path, $mime_type );

            //update_attached_file( $post_id, $file_path );
            //update_post_meta( $post_id, '_wp_attachment_metadata', wp_generate_attachment_metadata( $post_id, $file_path ) );



            return $override;
        }
    }
}

//image_editor_save_pre

?>