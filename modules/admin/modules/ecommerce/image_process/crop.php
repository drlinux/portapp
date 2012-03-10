<?php  error_reporting(E_ALL ^ E_NOTICE);
require_once dirname(__FILE__) . '/../../../../../classes/config.inc.php';
$IMAGE_PROCESSOR = new IMAGE_PROCESSOR();
$basePath = "../../../../../";
$predefinedResolutions = json_decode($smarty->getVariable("PREDEFINED_PICTURE_RESOLUTIONS"), true);
if($_POST["action"] == "cropImage")
{	
	extract($_POST,EXTR_SKIP);
	$file = $basePath . $file;
	$fileinfo = (object)pathinfo($file);
	$filename = basename($fileinfo->basename,".$fileinfo->extension");
	$croppedFileDir = "{$fileinfo->dirname}";
	$thumb_prefix = 0;
	foreach($predefinedResolutions as $pr)
	{
		$thumb_prefix++;
		$prKey 	= "{$pr[0]}_{$pr[1]}";
		$postKey = "{$rs_w}_{$rs_h}";
		if($prKey == $postKey)
		{
			break;
		}
	}
	$croppedFileName = "{$thumb_prefix}_{$filename}.{$fileinfo->extension}";
	$croppedFilePath = $croppedFileDir . "/" . $croppedFileName;

	$IMAGE_PROCESSOR->load($file);
	$IMAGE_PROCESSOR->crop($cr_w, $cr_h, $cr_l, $cr_t);
	$IMAGE_PROCESSOR->resize($rs_w, $rs_h, true);
	$IMAGE_PROCESSOR->save($croppedFilePath);
	echo json_encode(array("error"=>false,"file_url"=>$croppedFilePath));
	/* GENERATE BIG IMAGE ************************************************************************/
	if($thumb_prefix == 4)
	{
		$bigImgNameWithExtension = sprintf("big_%s.%s", $filename, $fileinfo->extension);
		$bigImgNameWithPath = $croppedFileDir . "/" . $bigImgNameWithExtension;
		
		$IMAGE_PROCESSOR->load($croppedFileDir . "/".$fileinfo->basename);
		$IMAGE_PROCESSOR->crop($cr_w, $cr_h, $cr_l, $cr_t);	
		$IMAGE_PROCESSOR->resize(($rs_w * 3), ($rs_h * 3), true, true);
		$IMAGE_PROCESSOR->save($bigImgNameWithPath);
	}
	/**********************************************************************************************/	
}
else if($_POST["action"] == "listproductthumbs")
{
	extract($_POST,EXTR_SKIP);
	$file = $basePath . $file;
	$fileinfo = (object)pathinfo($file);
	$filename = basename($fileinfo->basename,".$fileinfo->extension");
	$croppedFileDir = "{$fileinfo->dirname}";
	$existingThumbsList = array();
	foreach ($predefinedResolutions as $res)
	{
		$thumb_prefix++;
		$croppedFileName = "{$thumb_prefix}_{$filename}.{$fileinfo->extension}";
		$croppedFilePath = $croppedFileDir . "/" . $croppedFileName;		
		if(file_exists($croppedFilePath))
		{
			$existingThumbsList[] = array("file"=>"img/product/{$croppedFileName}","label"=>"{$res[0]} x {$res[1]}");
		}
	}
	echo json_encode(array("thumbs"=>$existingThumbsList));
}
else if($_POST["action"] == "deletethumb")
{
	$thumb = $basePath . $_POST["file"];
	if(file_exists($thumb))
		unlink($thumb);

	echo "deleted";
}