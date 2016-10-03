<?php
// include the letter avatar class
include("./letterAvatarClass.php");

if(isset($_POST['Text'])&&(trim($_POST['Text'])!=''))
{
	/*get texts first letter and convert to uppercase*/
	$text=strtoupper(strip_tags($_POST['Text']));
	
	/*create class object*/
	$phptextObj = new letterAvatarClass();
	
	/*letterAvatar function to genrate image with text*/
	echo $phptextObj->letterAvatar($text,100,260,260);
} 
?>