<?php
class Messaging extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("messagingId", "messagingFrom", "messagingTo", "messagingContent");
		$this->sIndexColumn		= "messagingId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Content";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	
	function getMessagingByMessagingId($messagingId)
	{
		$sQuery = "
			SELECT 
			receiver.userFirstname as receiverFirstname,
			receiver.userEmail as receiverEmail,
			sender.userFirstname as senderFirstname,
			sender.userEmail as senderEmail,
			messaging.messagingContent,
			messaging.messagingId
			FROM messaging
			LEFT JOIN user as sender ON sender.userId = messaging.messagingFrom
			LEFT JOIN user as receiver ON receiver.userId = messaging.messagingTo
			WHERE messaging.messagingId = :messagingId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("messagingId"=>$messagingId));
		return $rows[0];
	}
	
}