
  <html>
  <BODY BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#FF0000" VLINK="#800000" ALINK="#FF00FF" >


  <?php

  /**************
  Send email to Listserv
  Jim Baldwin 05/02/00
  updated to mail any html file as mail body JLB 02/24/05


  ***************/

  // #################################### config

  $SYSERROR_MSG = "there was a system error.";
  $SUCCESS = "SUCCESS!!";

  // ################################### end config

  // ################################### includes

  	include("genie.php");

  	include("mailconfig.php");

  // ################################### end includes

	$html_url = $_POST['html_url'];
  	$fp = fopen ($html_url, "r");
  	$email_text = fread( $fp, 50000);
  	fclose ($fp);


  	//$arrHtml_page = file($html_url);

  	//$email_text = implode("",$arrHtml_page);

	// workaround for long strings in PHP email function 10-07-01

 	$temp = str_replace(" "," \n", $email_text);
 	$email_text = $temp;

	//print $email_text;
	//exit;

  	$email = $_POST['sender_addr'];

  	$mailheaders = "From: $email\n";
  	$mailheaders .= "Content-Type: text/html\n";

	$listname = $_POST['sendto'];

	$mailsubject = stripslashes($_POST['subject']);


	if(mail($listname, $mailsubject, $email_text, $mailheaders))  {

		print "<br><br><br><center><h2>You have just mailed the HTML newsletter to $listname.\n</h2>";
		print "<form action = \"index.php\">
					<font size=+2>
					<input type=\"submit\" name=\"submit\" value=\"Return to Genie\">
					<input type =\"hidden\" value=\"$mailsubject\" name=\"mailsubject\">
					<input type =\"hidden\" value=\"$status\" name=\"status\">
					</font>
				</form>
				</center>\n";
	} else {
		print $SYSERROR_MSG;
	}

  ?>


  </body>
  </html>

