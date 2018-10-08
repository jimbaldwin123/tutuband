<?php

function check_email($str)
{
        //returns 1 if valid email, 0 if not
        if(ereg("^.+@.+\\..+$", $str))
                return 1;
        else
                return 0;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TU-TU BAND</title>

<style type="text/css">
	body {
		font-family: arial, sans-serif;
		font-weight; bold;
	}
	.announce {
		text-align:center;
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
	.msglink{
		color:#409473;
	}
</style>

</head>

<body bgcolor="#ffffff">
<img src="images/ttb_sticker.jpg" width="210" height="138">

<?php if(!check_email($_REQUEST['email'])) { ?>

	<div class="msg">You have entered an invalid email address.<br />Please try again.</div>
	<form action="unsub.php" method="POST">
		&nbsp;&nbsp;Email Address: <input type="text" name="email"><input type="submit" name="unsubscribe" value="unsubscribe">
	</form><br />

<?php } else {

	require_once('../PHPLIB/db_mysql.php');
	require_once('../PHPLIB/cfg.php');

	$db = new ps_DB;

	$q = "update ttblist set optout=1 where email = '{$_REQUEST['email']}'";
	$db->query($q);

?>

	<div class="msg"><?php echo $_REQUEST['email']; ?> has been removed from the mailing list.<br />Thanks for subscribing!</div>
	<a href="/" class="msg msglink">Return to Tu-Tu Band site</a>

<?php } ?>

</body>
</html>