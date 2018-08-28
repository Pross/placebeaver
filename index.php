<?php
define( 'ABSPATH', dirname( __FILE__ ) );
$width  = isset( $_GET['width'] )  ? basename( $_GET['width'] )  : 640;
$height = isset( $_GET['height'] ) ? basename( $_GET['height'] ) : 480;
$compress = isset( $_GET['compress'] ) ? basename( $_GET['compress'] ) : 75;

$possible_beavers = glob( 'beavers/*.jpg', GLOB_BRACE );
$random_beaver    = $possible_beavers[ array_rand( $possible_beavers ) ];

$cached_path = sprintf( 'cache/%s-%s-%s-%s.jpg', $width, $height, $compress, md5( $random_beaver ) );

if ( file_exists( $cached_path ) ) {
	serve_beaver( $cached_path );
} else {
	create_image( $cached_path, $width, $height, $random_beaver, $compress );
	serve_beaver( $cached_path );
}

function create_image( $cached_path, $newwidth, $newheight, $random_beaver, $compress ) {

	$image_path = ABSPATH . '/' . $random_beaver;
	$src = imagecreatefromjpeg( $image_path );
	list( $width, $height ) = getimagesize( $image_path );

	$tmp = imagecreatetruecolor( $newwidth, $newheight );

	imagecopyresampled( $tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
	imagejpeg( $tmp, $cached_path, $compress );
}

function serve_beaver( $path ) {
	$type = 'image/jpeg';
	header( 'Content-Type:' . $type );
	header( 'Content-Length: ' . filesize( $path ) );
	readfile( $path );
	exit();
}
