<?php

	/***
	*	JLB 060913
	*	get geocode info from Google, add long/lat to db
	*   todo: figure out how to empty document w/o destrying xml object
	***/

	require_once('../../PHPLIB/db_mysql.php');
	require_once('../../PHPLIB/cfg.php');
	$db = new ps_DB;
	$db2 = new ps_DB;

	require_once('../domit/xml_domit_include.php');

 	// Your Google Maps API key
   $key = "ABQIAAAAXNSBX6JoRGTpNKpBGgz5tRQCMrxPBNJRrFSqKMtCy1wUhYIQnRRhR6vlOOG-AQKRXqTNNgNEctkEDA";

	$nohits_msg='';
	$q = "select * from planetariums";
	$db->query($q);

	while($db->next_record()) {

		$xmldoc =& new DOMIT_Document();
		$xmldoc->useHTTPClient(true);

		$dataAddress = str_replace(' ','+',$db->f('address'));

		$address = "http://maps.google.com/maps/geo?q=$dataAddress&output=xml&key=$key";

		$success = $xmldoc->loadXML($address,false);
		// echo "#" . $success . "#" . $xmldoc->parsedBy() . "<br>\n";

		$myDocumentElement =& $xmldoc->documentElement;
		// echo $myDocumentElement->toNormalizedString(true);

		$matchingNodes =& $myDocumentElement->getElementsByTagName("coordinates");
		if($matchingNodes != null) {

			$coord = trim($matchingNodes->toString(false));
			$coord = str_replace('<coordinates>','',$coord);
			$coord = str_replace('</coordinates>','',$coord);
			list($long,$lat) = explode(',',$coord);

			$q2 = "update planetariums set latitude='$lat', longitude='$long' where id='" . $db->f('id') . "'";
			$db2->query($q2);

			echo "$dataAddress<br>\n";
			echo "$long, $lat<br><br>\n";
		} else {
			$nohits_msg .= "$dataAddress\n";

		}
		$xmldoc->destroy();
	}

	mail('jim@hvaldwin.net','geocode',$nohits_msg);
?>


