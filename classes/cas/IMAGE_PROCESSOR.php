<?php
/*
 * Author: Mehmet Hazar Artuner
 * Version: Beta 0.3.1
 * Date: 08.02.2012
 */

class IMAGE_PROCESSOR
{
	public $error = array();
	
	public $image;
	
	private $ERROR_TEXT_UNSUPPORTED_FILE_FORMAT;
	private $ERROR_TEXT_USE_PNG_FILE;
	
	function IMAGE_PROCESSOR()
	{
		$this->ERROR_TEXT_UNSUPPORTED_FILE_FORMAT = "Geçersiz dosya formatı girdiniz! Lütfen jpg,png veya gif formatlarından birini kullanın!";
		$this->ERROR_TEXT_FILE_MUST_BE_PNG = "png formatında olmalı!";
	}
	
	/**
	 * 
	 * Hafızadaki resmin çözünürlüğünü dündürür
	 * @return (object) array("width"=>$width,"height"=>$height)
	 */
	public function getResolution()
	{
		$width = imagesx($this->image);
		$height = imagesy($this->image);
		
		return (object) array("width"=>$width,"height"=>$height);
	}
	
	/**
	 * 
	 * Resmi tekrar ölçeklendirir
	 * @param (int) $width: istenen genişlik
	 * @param (int) $height: istenen yükseklik
	 * @param (bool) $squeeze: orjinal resmin tamamını istenen ölçüye sığdır
	 * @param (bool) $proportion: orjinal resmi tekrar ölçülendirirken oranı koru
	 * @param (string) $position: orjinal resmi tekrar ölçülenirirken hangi pozisyondan kesme veya hizalama yapacağını belirler
	 * @param (string) veya (array) $bg_color: arkaplan rengini belirler. string olarak kullandığında "transparent" kullanırsan resmin ölçülendirilen resmin
	 * kalan boşluğu olursa oralar transparan oluyor. String olarak ayrıca web tarzında renk ataması yapabilirsin. örnek: #ff0000  veya #f00. Eğer array olarak
	 * kullanırsan RGBA olarak değer atayabiliyorsun ve transparan veya normal renk atayabiliyorsun.
	 * $return boolean
	 */
	public function resize($width, $height, $squeeze= false ,$proportion=true, $position="center center", $bg_color=array(255, 255, 255, 0))
	{	
		if(($width < 0) || ($height < 0))
		{
			$file_res = $this->getResolution();
			$ratio = $file_res->width / $file_res->height;
			
			if($width < 0)
			{
				$width = round($height * $ratio);
			}
			else if($height < 0)
			{
				$height = round($width / $ratio);
			}
			else
			{
				$this->error = "Genişlik ve Yükseklik değerleri aynı anda negatif veya 0 olamaz!";
				return false;
			}
		}
		
		// Çıktı olarak alacağımız "hedef resmi" yükle
		$target = imagecreatetruecolor($width, $height);
	
		// Arkaplan rengini ayarla
		if($bg_color == "transparent")
		{
			$bg = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
		}
		else if(is_array($bg_color))
		{
			$bg = imagecolorallocatealpha($this->image, $bg_color[0], $bg_color[1], $bg_color[2], $bg_color[3]);
		}
		else
		{
			$color = $this->convertWebColorToRGB($bg_color);
			$bg = imagecolorallocatealpha($target, $color->red, $color->green, $color->blue, 0);
		}
		
		imagefill($target, 0, 0, $bg);
		
		// Ölçüleri hesapla
		$source_width = imagesx($this->image);
		$source_height = imagesy($this->image);
		$source_ratio = $source_width / $source_height;
		
		$target_ratio = $width / $height;
		///////////////////////////////////////////////////////////////////////////////////////
		
		$source_opt = (object) array("width"=>$source_width,"height"=>$source_height);
		$target_opt = (object) array("width"=>$width,"height"=>$height);

		if($squeeze && $proportion)
		{
			if($source_ratio > $target_ratio) // kaynak resim istenen resme göre geniş ise
			{
				$target_opt->height = $target_opt->width / $source_ratio;
				$pos = $this->calculateImagePosition($position, 0, ($height- $target_opt->height));
			}
			else if($source_ratio < $target_ratio) // kaynak resim istenen resme göre  dar ise
			{
				$target_opt->width = $target_opt->height * $source_ratio;
				$pos = $this->calculateImagePosition($position, ($width - $target_opt->width), 0 );
			}	
		}
		else if($squeeze && !$proportion)
		{
			$pos = (object) array("left"=>0,"top"=>0);
		}
		else if(!$squeeze)
		{
			$tempPos = explode(" ", $position); 
			$this->crop($target_opt->width, $target_opt->height, $tempPos[0], $tempPos[1]);
			return true;
		}
		
		imagecopyresampled($target, $this->image, $pos->left, $pos->top, 0, 0, $target_opt->width, $target_opt->height, $source_opt->width, $source_opt->height);
		$this->image = $target;
		imagesavealpha($this->image, true);
		return true;
	}
	
	/**
	 * 
	 * Resmi istenen ölçülerde belirtilen noktalardan itibaren kırma işlemi yapar.
	 * @param (int) $width genişlik
	 * @param (int) $height yükseklik
	 * @param (int) $x yataydaki başlangıç noktası
	 * @param (int) $y dikeydeki başlangıç noktası
	 */
	public function crop($width, $height, $x = "left", $y = "top", $bgcolor = array(255, 255, 255, 127) )
	{
		$target = imagecreatetruecolor($width, $height);
		$bg = imagecolorallocatealpha($target, $bgcolor[0], $bgcolor[1], $bgcolor[2], $bgcolor[3]);
		imagefill($target, 0, 0, $bg);
		imagesavealpha($target, true);
		
		$image_res = $this->getResolution();
		
		if($x == "left" || $x == "center" || $x=="right")
		{
			$pos = $this->calculateImagePosition("{$x} {$y}", ($image_res->width - $width), ($image_res->height - $height) );
		}
		else
		{
			$pos->left = $x;
			$pos->top = $y;
		}
		
		
		
		imagecopyresampled($target, $this->image, 0, 0, $pos->left, $pos->top, $width, $height, $width, $height);
		$this->image = $target;
	}
	
	/**
	 * 
	 * Resmi istenen açıda döndürür
	 * @param (float) $angle  dönme açısı
	 * @param (array) $color dönmeden sonra oluacak boşluklara atanacak renk
	 * @return boolean
	 */
	public function rotate($angle, $color = array(255, 255, 255, 127))
	{	
		// Resmin background ve alpha değerini oluştur
		$background_color = imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $color[3]);

		// Resmi Rotate Et
		$this->image = imagerotate($this->image, $angle, $background_color);
		
		// Resmin Alpha değerini ata
		imagesavealpha($this->image, true);
		
		return true;
	}
	
	/**
	 * 
	 * Resmi photoshoptaki gibi, resim kullanarak maskeler
	 * @param (string) $mask_image_url  maske olarak kullanılacak resim
	 * @return boolean
	 */
	public function mask($mask_image_url)
	{
		if(preg_match("/\.jpeg$|\.jpg$/i",$mask_image_url))
			$mask = imagecreatefromjpeg($mask_image_url);
		else if(preg_match("/\.png$/i",$mask_image_url))
			$mask = imagecreatefrompng($mask_image_url);
		else if(preg_match("/\.gif$/i",$mask_image_url))
			$mask = imagecreatefromgif($mask_image_url);
		else
		{
			$this->error[] = $this->ERROR_TEXT_UNSUPPORTED_FILE_FORMAT;
			return false;
		}
	
		// Get sizes and set up new picture
		$xSize = imagesx($this->image);
		$ySize = imagesy($this->image);
		$newPicture = imagecreatetruecolor( $xSize, $ySize );
		imagesavealpha( $newPicture, true );
		imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );
	
		// Resize mask if necessary
		if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
			$tempPic = imagecreatetruecolor( $xSize, $ySize );
			imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
			imagedestroy( $mask );
			$mask = $tempPic;
		}
	
		// Perform pixel-based alpha map application
		for( $x = 0; $x < $xSize; $x++ ) {
			for( $y = 0; $y < $ySize; $y++ ) {
				$alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
				$alpha = 127 - floor( $alpha[ 'red' ] / 2 );
				$color = imagecolorsforindex( $this->image, imagecolorat( $this->image, $x, $y ) );
				imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
			}
		}
	
		// Copy back to original picture
		imagedestroy($mask);
		$this->image = $newPicture;	
		return true;
	}
	
	/**
	 * 
	 * Resim işleme yapılması istenen resmi yükler yani hafızaya alır
	 * @param (string) $path yüklenecek dosya yolu
	 * @return boolean
	 */
	function load($path)
	{
		if(preg_match("/\.jpeg$|\.jpg$/i",$path))
		$this->image = imagecreatefromjpeg($path);
		else if(preg_match("/\.png$/i",$path))
		$this->image = imagecreatefrompng($path);
		else if(preg_match("/\.gif$/i",$path))
		$this->image = imagecreatefromgif($path);
		else
		{
			$this->error[] = $this->ERROR_TEXT_UNSUPPORTED_FILE_FORMAT;
			return false;
		}
	
		return true;
	}
	
	/**
	 * 
	 * İşlenen resmi dosya olarak kaydeder
	 * @param (string) $path kaydedilecek dosya yolu 
	 */
	public function save($path)
	{
		if(preg_match("/.jpeg$|.jpg$/i",$path))
		imagejpeg($this->image, $path);
		else if(preg_match("/.png$/i",$path))
		imagepng($this->image, $path);
		else if(preg_match("/.gif$/i",$path))
		imagegif($this->image, $path);
		else
		{
			$this->error = $this->ERROR_TEXT_UNSUPPORTED_FILE_FORMAT;
			return false;
		}
	
		return true;
	}
	
	
	/***************************************************************************************************
	** PRIVATE FUNCTIONS *******************************************************************************
	***************************************************************************************************/
	private function calculateImagePosition($image_position,$overflow_x,$overflow_y)
	{
		switch($image_position)
		{
			case("left center"):
				$calc_position = (object) array("left"=>0,"top"=>round($overflow_y / 2));
			break;
			
			case("left bottom"):
				$calc_position = (object) array("left"=>0,"top"=>ceil($overflow_y));
			break;
			
			case("right top"):
				$calc_position = (object) array("left"=>ceil($overflow_x),"top"=>0);
			break;
			
			case("right center"):
				$calc_position = (object) array("left"=>ceil($overflow_x),"top"=>round($overflow_y/2));
			break;
			
			case("right bottom"):
				$calc_position = (object) array("left"=>ceil($overflow_x),"top"=>ceil($overflow_y));
			break;
			
			case("center top"):
				$calc_position = (object) array("left"=>round($overflow_x/2),"top"=>0);
			break;
			
			case("center center"):
				$calc_position = (object) array("left"=>round($overflow_x/2),"top"=>round($overflow_y/2));
			break;
			
			case("center bottom"):
				$calc_position = (object) array("left"=>round($overflow_x/2),"top"=>ceil($overflow_y));
			break;
			
			default:
				$calc_position = (object) array("left"=>0,"top"=>0);
			break;
		}
		
		return $calc_position;
	}
	
	private function convertWebColorToRGB($color)
	{
		$color = str_replace("#", "", $color);
		$colorLength = strlen($color);
		
		if($colorLength<3)
		{
			return (object) array("red"=>"0XFF","green"=>"0XFF","blue"=>"0XFF");
		}
		else if(($colorLength == 3) || ($colorLength < 6))
		{
			$red = substr($color, 0,1);
			$green = substr($color, 1,1);
			$blue = substr($color, 2,1);
			
			return (object) array("red"=>"0X".$red.$red,"green"=>"0X".$green.$green,"blue"=>"0X".$blue.$blue);
		}
		else if($colorLength == 6 )
		{
			$red = substr($color, 0,2);
			$green = substr($color, 2,2);
			$blue = substr($color, 4,2);
			
			return (object) array("red"=>"0X".$red,"green"=>"0X".$green,"blue"=>"0X".$blue);
		}
	}

}

