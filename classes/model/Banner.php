<?php
class Banner extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("bannerId", "bannerTitle", "bannerDescription", "bannerStart", "bannerEnd", "bannerHref");
		$this->sIndexColumn		= "bannerId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}
	
	public function getBanners()
	{
		$sQuery = "
			SELECT *
			FROM banner
			LEFT JOIN banner_picture ON banner_picture.bannerId = banner.bannerId
			LEFT JOIN picture ON picture.pictureId = banner_picture.pictureId
			WHERE :date between bannerStart and bannerEnd
		";
		$rows = $this->run($sQuery, array("date"=>date("Y-m-d H:i:s")));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
				$i++;
			}
		}
		return ($arr);
	}
	
	
}