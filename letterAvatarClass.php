<?php
/**
 * letterAvatar class
 * @category Class
 * @package letterAvatar
 * @author Kannan M
 * @version 1.0 (Oct 03 - 2016)
 */

class letterAvatarClass
{
	/**
	 * Function to generate letter avatar
	 * @access public
	 * @param Text, Font Size, Image width and height
	 * @return Image Url
	 * @author Kannan
	 */
	public function letterAvatar($text,$fontSize,$imgWidth,$imgHeight)
	{
		/* settings */
		$font = './calibri.ttf'; /*define font*/

		// Split words and get first letter of each word 
		// Example - Kannan m -> KM
		$words = explode(" ", $text);
		$text = "";
		foreach ($words as $w) {
		  $text .= strtoupper($w[0]);
		}

		// Upload directory
		$folder = 'avatars/';

		// File name and extension
		$fileName = $text.'.jpg';

		// Text color
		// Default - White
		$textColor = '#FFF';

		// Convert hex code to RGB
		$textColor=$this->hexToRGB($textColor);	

		// check letter avatar already exist
		// if exist return the image
		if(file_exists($folder.$fileName))
		{
			return json_encode(array('status'=>TRUE,'image'=>$folder.$fileName));
		}
		
		$im = imagecreatetruecolor($imgWidth, $imgHeight);	
		$textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);	
		
		// Random background Colors
		$colorCode=array("#56aad8", "#61c4a8", "#d3ab92","#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#f39c12", "#d35400", "#c0392b", "#7f8c8d");
		$backgroundColor = $this->hexToRGB($colorCode[rand(0, count($colorCode)-1)]);
		$backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);
		
		imagefill($im,0,0,$backgroundColor);	
		list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize);	
		imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);
		if(imagejpeg($im,$folder.$fileName,90)){/*save image as JPG*/
			return json_encode(array('status'=>TRUE,'image'=>$folder.$fileName));
		imagedestroy($im);	
		}
	}
	
	/**
	* function to convert hex value to rgb array
	* @access public
	* @param Color
	* @return hex value 
	* @author Kannan
	*/
	protected function hexToRGB($colour)
	{
			if ( $colour[0] == '#' ) {
					$colour = substr( $colour, 1 );
			}
			if ( strlen( $colour ) == 6 ) {
					list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
			} elseif ( strlen( $colour ) == 3 ) {
					list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
			} else {
					return false;
			}
			$r = hexdec( $r );
			$g = hexdec( $g );
			$b = hexdec( $b );
			return array( 'r' => $r, 'g' => $g, 'b' => $b );
	}		
		
	/**
	* function to get center position on image
	* @access public
	* @param image,text,font,size,angle
	* @return position 
	* @author Kannan
	*/
	protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
	{
		$xi = imagesx($image);
		$yi = imagesy($image);
		$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]))+5;
		$yr = abs(max($box[5], $box[7]));
		$x = intval(($xi - $xr) / 2);
		$y = intval(($yi + $yr) / 2);
		return array($x, $y);	
	}
}
?>