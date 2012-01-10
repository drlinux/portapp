<?php
// http://mydomain.com/web-service.php?user=2&num=10&format=json
/* require the user as the parameter */
//if(isset($_GET['user']) && intval($_GET['user'])) {

	/* soak in the passed variable or set our own */
	$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
	$format = ( isset($_GET['format']) && strtolower($_GET['format']) == 'json' ) ? 'json' : 'xml'; //xml is the default
	
	//$user_id = intval($_GET['user']); //no default

	/* connect to the db */
	$hostname = "localhost";            //host
	$dbname = "veritabani";            //db name
	$username = "sa";            // username like 'sa'
	$pw = "";                // password for the user
	
	//$dbh = new PDO("odbc:Driver={SQL Server};Server=$hostname;Database=$dbname; Uid=$username;Pwd=$pw;");
	$dbh = new PDO("odbc:Driver={SQL Server};Server=$hostname;Database=$dbname;", $username, $pw);

	/* grab the posts from the db */
	$sql  = "SELECT TOP $number_of_posts ";
	$sql .= "tbStokFiyati.*, ";
	$sql .= "tbStok.* ";
	$sql .= "FROM tbStok ";
	$sql .= "LEFT JOIN tbStokFiyati ";
	$sql .= "ON tbStokFiyati.nStokId = tbStok.nStokId AND sFiyatTipi = 'PS' ";
	//echo $sql;exit;
	
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	
	/* create one master array of the records */
	$posts = array();
	while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$posts[] = array('Row'=>$post);
	}


	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>',PHP_EOL;
		echo '<Root>',PHP_EOL;
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo "\t",'<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo PHP_EOL,"\t\t",'<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo PHP_EOL,"\t",'</',$key,'>',PHP_EOL;
				}
			}
		}
		echo '</Root>';
	}

	/* disconnect from the db */
	unset($dbh);
	unset($stmt);
//}