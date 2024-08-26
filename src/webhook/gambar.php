<?php
	$img = imagecreatetruecolor(555, 280) or die ("Gambar tidak dapat dibuat");​
	$white = imagecolorallocate($img, 254, 254, 254);
	$grey = imagecolorallocate($img, 128, 128, 128);
	$purple = imagecolorallocate($img, 102, 65, 149);
	$black = imagecolorallocate($img, 0, 0, 0);
	$orange = imagecolorallocate($img, 219, 72, 21);​
	$font = arial.ttf';​
	$text = 'belajar php dari dasar sampai mahir dengan xampp';​
	$bg = $purple;​
	// Text Efek Bayangan
	imagettftext($img, 17, 0, 20, 202, $grey, $font, $text);
		// Text Asli
	imagettftext($img, 17, 0, 18, 200, $white, $font, $text);​
	header( "Content-type: image/png" ); 
	imagepng( $img );
	imagecolordeallocate( $bg );
	imagedestroy( $img ); ​
?>