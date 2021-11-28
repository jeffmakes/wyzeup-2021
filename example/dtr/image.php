<?php
/*
    Dynamic Heading Generator
    By Stewart Rosenberger
    http://www.stewartspeak.com/headings/    

    This script generates PNG images of text, written in
    the font/size that you specify. These PNG images are passed
    back to the browser. Optionally, they can be cached for later use. 
    If a cached image is found, a new image will not be generated,
    and the existing copy will be sent to the browser.

    Additional documentation on PHP's image handling capabilities can
    be found at http://www.php.net/image/    
*/


$font_file  = 'Brody.ttf' ;
$font_size  = 30 ; // font size in pts
$font_color = '#FF0000' ;
$background_color = '#ffffff' ;
$transparent_background  = true ;
/*$font_color = '#ccc' ;
//$background_color = '#fff' ;
$hover = false;
$hover_font_file  =  $font_file;
$hover_font_size  = $font_size;
$hover_font_color = '#f00' ;
//$hover_background_color = '#fff' ;
$transparent_background  = true ;*/

/*
   --------------------------------------------------------------
   Optionally, images can be cached for later use.
   If a cached image is found, a new image will not be generated,
   and the existing copy will be sent to the browser. However, 
   that won't happen unless a WRITABLE "cache" directory is there 
   for the images to be stored.
   --------------------------------------------------------------
*/

$cache_images = true ;
$cache_folder = 'cache' ;

/*
-----------------
Added for P+C DTR
-----------------
*/
session_start();

if(!isset($_GET['t']))$_GET['t']='h1_';
$exget=explode('_',$_GET['t']);
$_GET['tag']=array_shift($exget);
$_GET['text']=implode('_',$exget);

if(isset($_SESSION['pcdtr'])) {
	$underline=false;
	if(substr($_GET['tag'],-2)=='-a') $underline=true;
	$hover_underline=$underline;
	
	// tags
	$text_info = $_SESSION['pcdtr'][$_GET['tag']]; 
	if (isset($text_info['font-size'])) $font_size = $text_info['font-size'];

  	if (isset($text_info['background-color'])) $background_color = $text_info['background-color'];

  	if (isset($text_info['color'])) $font_color = $text_info['color'];

	if (isset($text_info['text-decoration']) && $text_info['text-decoration']=='none') $underline = false;
	
	if (isset($text_info['text-transform']) && $text_info['text-transform']=='uppercase') $_GET['text']=strtoupper($_GET['text']);
	if (isset($text_info['text-transform']) && $text_info['text-transform']=='lowercase') $_GET['text']=strtolower($_GET['text']);  
	
  	if (isset($text_info['font-family'])) {
		if(file_exists($text_info['font-family']))
			$font_file = $text_info['font-family'];	
		if(file_exists($text_info['font-family'].'.ttf'))
			$font_file = $text_info['font-family'].'.ttf';
  	}
}

// activate HOVER!
if(isset($_SESSION['pcdtr'][$_GET['tag'].':hover'])){
	$hover = true;
	$hover_info = $_SESSION['pcdtr'][$_GET['tag'].':hover'];

	if (isset($hover_info['font-size'])) $hover_font_size = $hover_info['font-size'];

	if (isset($hover_info['background-color'])) $hover_background_color = $hover_info['background-color'];

	if (isset($hover_info['color'])) $hover_font_color = $hover_info['color'];
	
	if (isset($hover_info['text-decoration']) && $hover_info['text-decoration']=='none') $hover_underline = false;
	
	if (isset($hover_info['font-family'])) {
		if(file_exists($hover_info['font-family']))
			$hover_font_file = $hover_info['font-family'];	
		if(file_exists($hover_info['font-family'].'.ttf'))
			$hover_font_file = $hover_info['font-family'].'.ttf';	

	}
}


/*
-----------------------
End of P+C DTR Addition
-----------------------
*/

/*
  ---------------------------------------------------------------------------
   For basic usage, you should not need to edit anything below this comment.
   If you need to further customize this script's abilities, make sure you
   are familiar with PHP and its image handling capabilities.
  ---------------------------------------------------------------------------
*/

$mime_type = 'image/png' ;
$extension = '.png' ;
$send_buffer_size = 4096 ;

// check for GD support
if(!function_exists('ImageCreate'))
    fatal_error('Error: Server does not support PHP image generation') ;

// clean up text 
if(empty($_GET['text']))
    fatal_error('Error: No text specified.') ;
    
$text = $_GET['text'] ;
if(get_magic_quotes_gpc())
    $text = stripslashes($text) ;
$text = javascript_to_html($text) ;

// look for cached copy, send if it exists
$hash = md5(basename($font_file) . $font_size . $font_color .
            $background_color . $transparent_background . $text) ;
$cache_filename = $cache_folder . '/' . $hash . $extension ;
if($cache_images && ($file = @fopen($cache_filename,'rb')))
{
    header('Content-type: ' . $mime_type) ;
    while(!feof($file))
        print(($buffer = fread($file,$send_buffer_size))) ;
    fclose($file) ;
    exit ;
}

// check font availability
$font_found = is_readable($font_file) ;
if(!$font_found)
{
    fatal_error('Error: The server is missing the specified font.') ;
}

// create image
$background_rgb = hex_to_rgb($background_color);
$font_rgb = hex_to_rgb($font_color) ;
$dip = get_dip($font_file,$font_size) ;
$box = @ImageTTFBBox($font_size,0,$font_file,$text) ;
$width = abs($box[2]-$box[0])+2;
$height = abs($box[5]-$dip);
$maxhbox = @ImageTTFBBox($font_size,0,$font_file,'Ájg');
$height = abs($maxhbox[5])+abs($maxhbox[3]);
  
$image = @ImageCreate($width, $height);

if($hover)
{
  $hover_background_rgb = hex_to_rgb($hover_background_color);
  $hover_font_rgb = hex_to_rgb($hover_font_color) ;
  $hover_dip = get_dip($hover_font_file,$hover_font_size) ;
  $hover_box = @ImageTTFBBox($hover_font_size,0,$hover_font_file,$text);
  
  $hover_width = abs($hover_box[2]-$hover_box[0])+2;
  if($width>$hover_width)
    	$hover_width = $width;
  $hover_height = $height+abs($maxhbox[5])+abs($maxhbox[3]);
  $hover_image = @ImageCreate($hover_width, $hover_height);
}

if(!$image || !$box || ($hover && !$hover_image))
{
    fatal_error('Error: The server could not create this heading image.') ;
}

// allocate colors and draw text
$background_color = @ImageColorAllocate($image,$background_rgb['red'],
					$background_rgb['green'],
					$background_rgb['blue']);
$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],
				 $font_rgb['blue']) ;   


$int_x = abs($maxhbox[5]-$maxhbox[3])-$maxhbox[1];	
// write text
ImageTTFText($image,$font_size,0,-$box[0],$int_x,$font_color,$font_file,$text);

	     
if($hover)
{
  $hover_background_color = @ImageColorAllocate($hover_image,
						$hover_background_rgb['red'],
						$hover_background_rgb['green'],
						$hover_background_rgb['blue']);
  $hover_font_color = ImageColorAllocate($hover_image,$hover_font_rgb['red'],
					 $hover_font_rgb['green'],
					 $hover_font_rgb['blue']);   

  ImageTTFText($hover_image,$hover_font_size,0,-$hover_box[0],
	       abs($maxhbox[5]-$maxhbox[3])-$maxhbox[1]+$height,
	       $hover_font_color,$hover_font_file,$text);
	       
  // hover underline
  $hover_underline_y = ($hover_height+1)-($hover_dip/2);
  if($hover_underline) imageline ($hover_image,0,$hover_underline_y,$hover_width,$hover_underline_y,$hover_font_color);
}

// underline
$underline_y = ($height+1)-($dip/2);
if($underline) imageline ($image,0,$underline_y,$width,$underline_y,$font_color);


// set transparency
if($transparent_background)
{
    ImageColorTransparent($image,$background_color) ;
    if($hover)
      ImageColorTransparent($hover_image,$hover_background_color);
}

//header('Content-type: ' . $mime_type) ;

if($hover)
{
  if(!imagecopy($hover_image, $image, 0,0,0,0,$width,$height))
  {
    fatal_error('Error: The server could not create this heading image (hover).');
  }
  $newimage = & $hover_image;
}
else
{
  $newimage = & $image;
}

ImagePNG($newimage);

// save copy of image for cache
if($cache_images)
{
  @ImagePNG($newimage,$cache_filename) ;
}
ImageDestroy($newimage) ;

exit ;


/*
	try to determine the "dip" (pixels dropped below baseline) of this
	font for this size.
*/
function get_dip($font,$size)
{
	$test_chars = 'abcdefghijklmnopqrstuvwxyz' .
			      'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
				  '1234567890' .
				  '!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=' ;
	$box = @ImageTTFBBox($size,0,$font,$test_chars) ;
	return $box[3] ;
}


/*
    attempt to create an image containing the error message given. 
    if this works, the image is sent to the browser. if not, an error
    is logged, and passed back to the browser as a 500 code instead.
*/
function fatal_error($message)
{
    if(isset($_GET['debug']))exit;
    // send an image
    if(function_exists('ImageCreate'))
    {
        $width = ImageFontWidth(5) * strlen($message) + 10 ;
        $height = ImageFontHeight(5) + 10 ;
        if($image = ImageCreate($width,$height))
        {
            $background = ImageColorAllocate($image,255,255,255) ;
            $text_color = ImageColorAllocate($image,0,0,0) ;
            ImageString($image,5,5,5,$message,$text_color) ;    
            header('Content-type: image/png') ;
            ImagePNG($image) ;
            ImageDestroy($image) ;
            exit ;
        }
    }

    // send 500 code
    header("HTTP/1.0 500 Internal Server Error") ;
    print($message) ;
    exit ;
}


/* 
    decode an HTML hex-code into an array of R,G, and B values.
    accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff 
*/    
function hex_to_rgb($hex)
{
    // remove '#'
    if(substr($hex,0,1) == '#')
        $hex = substr($hex,1) ;

    // expand short form ('fff') color
    if(strlen($hex) == 3)
    {
        $hex = substr($hex,0,1) . substr($hex,0,1) .
               substr($hex,1,1) . substr($hex,1,1) .
               substr($hex,2,1) . substr($hex,2,1) ;
    }

    if(strlen($hex) != 6)
        fatal_error('Error: Invalid color "'.$hex.'"') ;

    // convert
    $rgb['red'] = hexdec(substr($hex,0,2)) ;
    $rgb['green'] = hexdec(substr($hex,2,2)) ;
    $rgb['blue'] = hexdec(substr($hex,4,2)) ;

    return $rgb ;
}


/*
    convert embedded, javascript unicode characters into embedded HTML
    entities. (e.g. '%u2018' => '&#8216;'). returns the converted string.
*/
function javascript_to_html($text)
{
    $matches = null ;
    preg_match_all('/%u([0-9A-F]{4})/i',$text,$matches) ;
    if(!empty($matches)) for($i=0;$i<sizeof($matches[0]);$i++)
        $text = str_replace($matches[0][$i],
                            '&#'.hexdec($matches[1][$i]).';',$text) ;

    return $text ;
}

?>
