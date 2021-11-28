<?php
// Include files
function Sendmail_30Day_before($dt){
			//$date 		= $dt;
			$val =explode("-",$dt);
			/*echo $val[0];echo "<br>";
			echo $val[1];echo "<br>";
			echo $val[2];echo "<br>";*/
			$date = date("Y-m-d", mktime(0, 0, 0,$val[1], $val[2]+31, $val[0]));
		    $qry = "select school_id,
								school_name,
								school_password,
								school_contactname,
								school_startdate,
								school_enddate,
								school_address1,
								school_address2,
								school_city,
								school_country,
								school_zipcode,
								school_email,
								school_phone,								
								school_status
						 from
						 		 ".TABLE_SCHOOL."
						 where
						 		school_enddate = '".$date."'";
			$rs  =  mysql_query($qry) or die(mysql_error());
			while($row =  mysql_fetch_array($rs)){
				$subject  = 'Renewal Notification';
				$headers  = "MIME-Version: 1.0\r\n"; 						
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 						
				$headers .= "From:Wyze Up <admin@wyzeup.co.uk>"; 						
				$message  ='<style>				
				.paragraph {
						font-family: Arial, Helvetica, sans-serif, Tahoma;
						font-size: 10pt;
						color: #FFFFFF;
						line-height: 19px;
						text-decoration: none;
						}</style>';
				$desc .= '<table width="100%"  border="0" cellspacing="1" cellpadding="2">
							  <tr>
								<td class="paragraph">Hi '.$row['school_contactname'].',</td>
							  </tr>
							  <tr>
								<td class="paragraph">Your School account coming close to expiry within 30 days ('.$row['school_enddate'].'). </td>
							  </tr>
							  <tr>
								<td class="paragraph">This is License Renewal notification.</td>
							  </tr>
							  <tr>
								<td class="paragraph">Please renew your License before the expiry date.</td>
							  </tr>
							</table>
							<p align="left"><span class="paragraph">Regards,</span></p>
							<p align="left"><span class="paragraph">The Wyzeup Team. </span></p>
							';
				$message  	.=  wordwrap($desc,75); 				
				$toaddress  =  $row['school_email'];	
				//echo $message;
				$mailsent =   mail($toaddress ,$subject, $message, $headers);	
			}			
	}
/** function to send the mail for users who have subscribed after 9.00 am for the current day **/
	function send_dailymail()
	{
		$date		=	getdate();
		$hrs		=	$date['hours'];
		$flag		=	0;
		if ($hrs>9){
			// send daily verses mail
			$flag	=	1;
		}else if ($hrs==9){
			$mts	=	$date['minutes'];
			if ($mts>10){
				// send daily verses mail
				$flag	=	1;
			}
		}
		return $flag;
	}
?>
