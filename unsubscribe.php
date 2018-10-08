<?php

	require_once('../PHPLIB/cfg.php');
	include_once "../PHPLIB/ezsql/ez_sql_core.php";
	include_once "../PHPLIB/ezsql/ez_sql_mysql.php";

	$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
	// Initialise database object and establish a connection
	// at the same time - db_user / db_password / db_name / db_host
	$db = new ezSQL_mysql();

if(isset($_GET['m'])){
	$guid = mysql_real_escape_string($_GET['m']);	
	$m = $db->get_var("select email from ttblist where guid = '$guid'");
} else{
	$m = '';
}


?>

<html>
<head>
<title>TU-TU BAND</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
	body {
		font-family: arial, sans-serif;
		font-weight; bold;
	}
	.announce {
		text-align:left;
	}
	.atext {
		text-align:left;
		font-weight: bold;
		font-size:24px;
	}
	.head {
		font-size:32px;
	}
	.msg{
		font-size:16px;
		font-weight:bold;
	}
</style>

</head>

<body bgcolor="#FFFFFF" marginwidth="0" marginheight="0" leftmargin="5" topmargin="0">
<img src="/images/ttb_sticker.jpg" />	<h4>What, so soon? Ok, enter your email address here to unsubscribe from the Tu-Tu Band announcement list.</h4>
		  <form action="unsub.php" method="POST">
			&nbsp;&nbsp;Email Address: <input type="text" name="email" value="<?php echo $m; ?>"><input type="submit" name="unsubscribe" value="unsubscribe">
		  </form>
</body>
</html>
