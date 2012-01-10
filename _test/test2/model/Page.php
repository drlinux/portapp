<?php
namespace model;
use lib\model as basemodel;

class Page extends basemodel\BaseModel
{
	public $itemNo = '123';
	public $price = 2.45;
	public $qtyOnHand = 87;
	public $hede;
	
	function info()
	{
		return __CLASS__;
	}
	
}