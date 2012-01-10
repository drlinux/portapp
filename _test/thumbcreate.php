<?php
class cropImage
{
	var $imgSrc, $myImage, $cropHeight, $cropWidth, $x, $y, $thumb;

	function setImage($image)
	{
		//Your Image
		$this->imgSrc = $image;
			
		//getting the image dimensions
		list($width, $height) = getimagesize($this->imgSrc);
			
		//create image from the jpeg
		$this->myImage = imagecreatefromjpeg($this->imgSrc) or die("Error: Cannot find image!");

		if($width > $height) $biggestSide = $width; //find biggest length
		else $biggestSide = $height;
			
		//The crop size will be half that of the largest side
		$cropPercent = 1;//.5; // This will zoom in to 50% zoom (crop)
		$this->cropWidth   = $biggestSide*$cropPercent;
		$this->cropHeight  = $biggestSide*$cropPercent;
			
			
		//getting the top left coordinate
		$this->x = ($width-$this->cropWidth)/2;
		$this->y = ($height-$this->cropHeight)/2;
			
	}

	function createThumb($thumbWidth=50, $thumbHeight=50)
	{
		$this->thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

		imagecopyresampled($this->thumb, $this->myImage, 0, 0, $this->x, $this->y, $thumbWidth, $thumbHeight, $this->cropWidth, $this->cropHeight);
	}

	function renderImage()
	{
		header('Content-type: image/jpeg');
		imagejpeg($this->thumb);
		imagedestroy($this->thumb);
	}

}

if (isset($_GET["src"])) $src = $_GET["src"];
else exit;

$image = new cropImage;
$image->setImage($src);
$image->createThumb(300,300);
$image->renderImage();