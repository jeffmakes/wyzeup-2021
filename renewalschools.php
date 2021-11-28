<?php  
	ob_start();
	require_once("conf/conf.inc.php");
  ##Inserting renewal datas in to renewal table and sending email to admin
  /*if($_GET["schoolid"]){ 
 		$member_id = explode("-",$_GET["schoolid"]);
 		$schoolid = $member_id[1];
 		//check for duplicate entries
 		$sql = "SELECT * FROM wyzeup_schools  WHERE school_id = ".$schoolid." AND school_enddate = CURDATE()";
  		$res = mysql_query($sql);
		if(mysql_num_rows($res)==0){
 			//$query = "INSERT INTO tbl_renewal (renewal_member_id,renewal_date,renewal_status) VALUES ('".$memberid."',CURDATE(),1)";
 			//$result = mysql_query($query);
		  ##Sending Email to admin	
			// Is the OS Windows or Mac or Linux
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
				$eol="\r\n";
			} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
				$eol="\r";
			} else {
				$eol="\n";
			}
			$date	  = date("d-m-Y H:i");
			$message  = "<html><head></head><body><table cellpadding='3' cellspacing='1' border='0' align='center' bgcolor='#660033' width='600px'>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Wyzeup Renewal Notification</strong></font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>A user has signed up for renewal. Please Click <a href='http://wyzeup.co.uk/controlpanel/'>here</a> to login and activate</strong></font></td></tr>";
			echo $message  = $message . "</table></body></html>";
			$to		  = "pmkavi@gmail.com";
			$subject  = "Wyzeup Registration Details";	
			$headers =  "MIME-Version: 1.0".$eol; 						
			$headers .= "Content-type: text/html; charset=iso-8859-1".$eol; 
			$headers .= "X-Priority : 1".$eol; 
			$headers .= "X-MsMail-Priority : High".$eol; 
			$headers .= "From:<Wyzeup>admin@wyzeup.co.uk".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;  
			$mailsent 	= mail($to,$subject, wordwrap($message,72), $headers);
			//$mailsent 	= mail('amudhabalan@gmail.com',$subject, wordwrap($message,72), $headers);
			//$mailsent 	= mail('amudhabalan@anadocs.com',$subject, wordwrap($message,72), $headers);
			if(mailsent){
				//header("Location:thankyou_renewal.php?action=success");
			} else {
				//header("Location:thankyou_renewal.php?action=fail");
			}
		} else {
			header("Location:thankyou_renewal.php?action=duplicate");
	  }	
 }else{*/
 	$vat_amount   = TRANSACTION_AMOUNT * VAT;
	$total_amount = TRANSACTION_AMOUNT + $vat_amount;

	$query = "SELECT *, DATE_FORMAT(school_startdate,'%d %b %Y') as school_startdate,DATE_FORMAT(school_enddate,'%d %b %Y') as enddate FROM wyzeup_schools WHERE school_isdeleted=0 AND DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30 AND school_status=1";
 	$result=mysql_query($query);

	while($result_set_row = mysql_fetch_array($result)){
			$select_qry = "SELECT * FROM wyzeup_renewals WHERE renewal_school_id = ".$result_set_row['school_id']." AND renewal_isapproved = 1";//renewal_enddate = '".$result_set_row['school_enddate']."'"; 
			$res_qry = mysql_query($select_qry); 
			if(mysql_num_rows($res_qry) <= 0){		 
	
				#To Insert records in Renewal Table
				$sql_query = "INSERT INTO wyzeup_renewals (renewal_school_id ,renewal_invoice_date,renewal_enddate ,renewal_isapproved) VALUES ('".$result_set_row['school_id']."',CURDATE(),'".$result_set_row['school_enddate']."',1)";
				$renew_result = mysql_query($sql_query);
				// Is the OS Windows or Mac or Linux
				if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
					$eol="\r\n";
				} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
					$eol="\r";
				} else {
					$eol="\n";
				}
				##Sending Email to the members
				$date	  = date("d-m-Y H:i");			
				/*$message  = "<html><head></head><body><table cellpadding='3' cellspacing='1' border='0' align='center' bgcolor='#1AAEBC' width='600px'>";
				$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Wyzeup Renewal Notification</strong></font></td></tr>";
				$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font face='verdana, arial' size='2' color='#660033'>Dear ".$result_set_row['school_contactname'].",</font></td></tr>";
				$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Please Click <a href='http://www.wyzeup.co.uk/renewalschools.php?schoolid=".$result_set_row["school_contactname"]."-".$result_set_row["school_id"]."'>here</a> to renew your membership</strong></font></td></tr>";
				$message  = $message . "</table></body></html>";*/
				$date_invoice  = date("d-m-Y");	
				$invoice_mail_content = '<html><head>
													<meta http-quiv="Content-type: text/html; charset=iso-8859-1\r\n">
													<style type="text/css">
													.para{
																font-family: Arial, Helvetica, sans-serif;
																font-size: 80%;	
																line-height: 18px;
																text-decoration: none;
																padding: 0px 5px 5px 10px;
																width:174px;
																}
															</style>
												</head>
												<body>		
									<table cellpadding="3" cellspacing="1" border="0" align="center" bgcolor="#1AAEBC">
									  <tr>
										<td valign="top" bgcolor="#FFFFFF" class="para" colspan="2"><img src="http://www.wyzeup.co.uk/wyzeup_images/wyzeup_logo.JPG" width="191" height="66"></td>
										<td width="237"  bgcolor="#FFFFFF" class="para">Wyze Up<br>Address1<br>Address2 <br>Norwich NR3 1AU<br>Tel: 01603 760767<br>Mob: 07957 191757<br>Web: www.wyzeup.co.uk<br>E-Mail: info@wyzeup.co.uk</td>
									  </tr>';
				
			  $invoice_mail_content .= '<tr>
											<td bgcolor="#FFFFFF" colspan="3" class="para"> Client : '.$result_set_row['school_contactname'].'<br>'.$result_set_row['school_address1'].'<br>'.$result_set_row['school_address2'].'</td>
										  </tr>
										  <tr><td bgcolor="#FFFFFF" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF" align="right">Date : '.$date_invoice.'</td></tr>
										  <tr><td bgcolor="#FFFFFF" colspan="3" align="center">&nbsp;</td></tr>
										  <tr><td align="center" bgcolor="#FFFFFF" class="para" colspan="2"><strong>DESCRIPTION</strong></td><td align="center" bgcolor="#FFFFFF" class="para"><strong>AMOUNT</strong></td>
										  </tr>';
			  $invoice_mail_content .= '<tr>
											<td bgcolor="#FFFFFF" class="para" colspan="2">1 year subscription to Wyze-Up.co.uk</td>
											<td bgcolor="#FFFFFF" class="para" align="right">&pound;'.number_format(TRANSACTION_AMOUNT,2).'</td>
										  </tr>';
			  $invoice_mail_content .= '<tr>
											<td bgcolor="#FFFFFF" class="para" colspan="2">'.$result_set_row['school_startdate'].' to '.$result_set_row['enddate'] .'</td>
											<td bgcolor="#FFFFFF" class="para" align="right">&nbsp;</td>
										  </tr>';
			  $invoice_mail_content .='
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>
									  <tr><td bgcolor="#FFFFFF" align="center" colspan="2">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td></tr>';
			  $invoice_mail_content .='<tr>
										<td align="center" bgcolor="#FFFFFF">Please make payments to Wyze Up</td>
										<td bgcolor="#FFFFFF" align="right" class="para">SUBTOTAL</td><td bgcolor="#FFFFFF" class="para" align="right">&pound;'.number_format(TRANSACTION_AMOUNT,2).'</td>
									  </tr>
									  <tr>
										<td align="center" bgcolor="#FFFFFF">Thank you for your valued custom</td>
										<td bgcolor="#FFFFFF" align="right" class="para">VAT@17.5%</td><td bgcolor="#FFFFFF" class="para" align="right">&pound;'.number_format($vat_amount,2).'</td>
									  </tr>';
			  $invoice_mail_content .='<tr>
										<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
										<td bgcolor="#FFFFFF" align="right" class="para">OTHER</td>
										<td align="right" bgcolor="#FFFFFF">-</td>
									  </tr>
									  <tr>
										<td width="124" align=center bgcolor="#FFFFFF">&nbsp;</td>
										<td width="153" bgcolor="#FFFFFF" align="right" class="para"><strong>TOTAL INVOICE</strong></td>
										<td bgcolor="#FFFFFF" class="para" align="right">&pound; '.number_format($total_amount,2).'</td>
									  </tr>
									  <tr>
										<td bgcolor="#FFFFFF" colspan="3" align="center">&nbsp;</td>
									  </tr>
									</table>
									</body>
									</html>';
	
	//echo $invoice_mail_content;
			
				
				$to		  = $result_set_row["school_email"];
				//$subject  = "Wyzeup Renewal Details";	
				$subject_invoice  = "Wyzeup Invoice Details";	
				$headers  =  "MIME-Version: 1.0".$eol; 						
				$headers .= "Content-type: text/html; charset=iso-8859-1".$eol; 
				$headers .= "X-Priority : 1".$eol; 
				$headers .= "X-MsMail-Priority : High".$eol; 
				$headers .= "From:Wyzeup <admin@wyzeup.co.uk>".$eol;
				$headers .= "X-Mailer: PHP v".phpversion().$eol;  
				$mailsent 	= mail($to,$subject_invoice, wordwrap($invoice_mail_content,72), $headers);
		}
 	}



# To send the Emails for Deactivation

	/*$sql_qry  = "SELECT * FROM wyzeup_schools";
	$sql_res = mysql_query($sql_qry);
	while($row_renew = mysql_fetch_array($sql_res)){
		$row_renew['school_enddate']; 
		$renew_date = explode('-',$row_renew['school_enddate']);
		$nextyear = mktime(0, 0, 0, date($renew_date[1]), date($renew_date[2]+9), date($renew_date[0]));
		$renewal_date = date("Y-m-d", $nextyear); echo '<br>';*/
		
	



		$sql = "SELECT * FROM wyzeup_schools  WHERE school_expirydate = CURDATE() AND school_status = 1 AND school_isdeleted = 0";		
  		$res = mysql_query($sql);
		
		while($row = mysql_fetch_array($res)){
			// Is the OS Windows or Mac or Linux
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
				$eol="\r\n";
			} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
				$eol="\r";
			} else {
				$eol="\n";
			}
			##Sending Email to the members
			$date	  = date("d-m-Y H:i");			
			$message  = "<html><head></head><body><table cellpadding='3' cellspacing='1' border='0' align='center' bgcolor='#1AAEBC' width='600px'>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Wyzeup  - School Deactivation</strong></font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Dear ".$row['school_contactname'].",</font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>We regret to say that your application has been deactivated as it comes to expiry date.</font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Click <a href='http://wyzeup.co.uk/contact_us.php' target='_blank'>here</a> to contact Wyze Up for Renewal.</font></td></tr>";
			
			
			//$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Please Click <a href='http://www.wyzeup.co.uk/renewalschools.php?schoolid=".$result_set_row["school_contactname"]."-".$result_set_row["school_id"]."'>here</a> to renew your membership</strong></font></td></tr>";
			$message  = $message . "</table></body></html>";
			$message  = $message . "<p align='left'><font size='2' color='#660033' face='verdana, arial'><strong>Thanks,<br>Wyze Up Team.<br><a href ='http://www.wyzeupp.co.uk'>www.wyzeup.co.uk</a></strong></font></p>";
			$to		  = $row["school_email"];
			$subject  = "Wyzeup  - School Deactivation";	
			
			$headers  =  "MIME-Version: 1.0".$eol; 						
			$headers .= "Content-type: text/html; charset=iso-8859-1".$eol; 
			$headers .= "X-Priority : 1".$eol; 
			$headers .= "X-MsMail-Priority : High".$eol; 
			$headers .= "From:Wyzeup <admin@wyzeup.co.uk>".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;  
			$mailsent 	= mail($to,$subject, wordwrap($message,72), $headers);
		}

?>