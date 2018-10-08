<?php

	/***
	*	JLB 060913
	*	generate Google Earth kml file from db
	*   todo: figure out how to empty document w/o destrying xml object
	***/

	require_once('../../PHPLIB/db_mysql.php');
	require_once('../../PHPLIB/cfg.php');
	$db = new ps_DB;


	$header = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Document>
	<Folder>
	  <name>Planetariums</name>
	  <open>1</open>
	  <description><![CDATA[Imaginova &trade; presents planetariums of the world.]]></description>
';

	$footer = '
  </Folder>
</Document>
</kml>
';

	$tmpPlacemark = '
<Placemark>
<description><![CDATA[<!--%address%--><br><!--%website%-->]]></description>
<name><![CDATA[<!--%caption%-->]]></name>
<LookAt>
  <longitude><!--%longitude%--></longitude>
  <latitude><!--%latitude%--></latitude>
  <range>1000.000000000137</range>
  <tilt>-6.079630270107447e-011</tilt>
  <heading>-3.446972488456012e-014</heading>
</LookAt>
<styleUrl>root://styles#default</styleUrl>
<Point>
  <coordinates><!--%longitude%-->,<!--%latitude%-->,0</coordinates>
</Point>
</Placemark>
';

	$tmpWebsite = '<a href="<!--%url%-->">Web Site</a>';

	$placemarks = '';

	$q = "select * from planetariums where latitude != ''";
	$db->query($q);
	while($db->next_record()) {
		$placemark = $tmpPlacemark;
		$placemark = str_replace('<!--%caption%-->',$db->f('caption'),$placemark);
		$placemark = str_replace('<!--%address%-->',$db->f('address'),$placemark);
		$placemark = str_replace('<!--%longitude%-->',$db->f('longitude'),$placemark);
		$placemark = str_replace('<!--%latitude%-->',$db->f('latitude'),$placemark);
		if(strpos($db->f('url'),'http')) {
			$url = str_replace('URL:','',$db->f('url'));
			$website = str_replace('<!--%url%-->',$url,$tmpWebsite);
			$placemark = str_replace('<!--%website%-->',$website,$placemark);
		} else {
			$placemark = str_replace('<!--%website%-->','',$placemark);
		}
		$placemarks .= $placemark;
	}

	$kml = $header . $placemarks . $footer;
	$fp=fopen('europlanetariums.kml','w');
	fputs($fp,$kml);
	fclose($fp);
	print 'done';
?>

