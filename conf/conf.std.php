<?php
/*
*
* Some common functions to be used all over the site
*/
	function http_post_var($var_name)
	{
		return (isset($_POST[$var_name]) ? $_POST[$var_name] : null);
	}
	function http_get_var($var_name)
	{
		return (isset($_GET[$var_name]) ? $_GET[$var_name] : null);
	}
	function html_refresh($url){
	
		header("Location: ".$url);	
	}

	/**
	 * Redirect to another page or site
	 * @param string The url to redirect to
	*/
	function redirect($url) {
	
		if ( (ENABLE_SSL == true) && ($_SERVER['HTTPS'] == 'on') ) { // We are loading an SSL page
		
		  if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) { // NONSSL url
		  
			$url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER)); // Change it to SSL
			
		  }
		  
		}
	}
	  
	/*
	* *********************
	* Date & Time functions 
	* *********************
	* Date Validation
	* @Param $date    input date  Note : Input date should be in the format of yyyy-mm-dd or yyyy/mm/dd.
	* @param $format  the format that is included in the date , like / or -.
	* @return  	      boolean 
	* Function to validate the date format using the PHP checkdate() as the reference and it returns true if the  
	*  date is a valid date.
	**/
	function validate_date($date,$format)
	{ 
		$array_date = explode($format, $date);
		
  		if (count($array_date) != 3)
		{
			return false;
		}
		return checkdate($array_date[1], $array_date[2], $array_date[0]);
	}
	
	 function CompareDate($start_date, $end_date)
	{
		$array_start_date = explode("-", $start_date);
		$array_end_date = explode("-", $end_date);
		
		if (count($array_start_date) <> 3 || count($array_end_date) <> 3)
		{
			return false;
		}	
		
		$unix_start_date = mktime(0, 0, 0, $array_start_date[1], $array_start_date[2],$array_start_date[0]);
		$unix_end_date = mktime(0, 0, 0, $array_end_date[1], $array_end_date[2],$array_end_date[0]);

		return ($unix_start_date > $unix_end_date) ? true : false;
	}
	/**
	* Future  date validation	
	* @param date in the format must be yyyy-mm-dd
	* @return boolean value
	* Function to validate the given date is a date in future or not.It first converts the given date into Unix timestamp and 
	* compares it with the current timestamp.
	*
	*/
	function date_is_in_future($date)
	{
		$array_date 		= explode("-", $date);
		
 		$unix_expiry_date 	= mktime(0, 0, 0, $array_date[1], $array_date[2],$array_date[0]);
		
		$unix_current_date 	= mktime(0, 0, 0, date("m"), date("d"),date("Y"));
		
 		return ($unix_expiry_date >= $unix_current_date) ? true : false;
	}
	/**
	* Seconds to  Minutes convertor
	* Function to convert the seconds into minutes
	* @param seconds
	* @return minutes
	*/
	function convert_seconds_to_min_sec($seconds)
	{
		$minutes = (int) ($seconds/60);

		if ($minutes < 10)
		{
			$minutes = '0'.$minutes;
		}

		$seconds = $seconds%60;

		if ($seconds < 10)
		{
			$seconds = '0'.$seconds;
		}
	
		return "$minutes";
	}
	/**
	* Minutes to  Hours convertor
	* Function to convert the Minutes into hours
	* @param Minutes
	* @return Hours
	*/
	function convert_min_to_hrs($minutes)
	{
		$hours = (int) ($minutes/60);

		if ($hours < 10)
		{
			$hours = '0'.$hours;
		}

		$minutes = $minutes%60;

		if ($minutes < 10)
		{
			$minutes = '0'.$minutes;
		}
	
		return "$hours.$minutes";
	}
	/**
	* Minutes & Seconds  to  Seconds convertor
	* Function to convert the Minutes & Seconds  into seconds
	* @param Minutes & Seconds
	* @return Seconds
	*/
	function convert_min_sec_to_seconds($minutes_seconds)
	{
		$minutes_array = explode(".", $minutes_seconds);
			
		$seconds = $minutes_array[0] * 60;
		
		if (count($minutes_array) == 2)
		{
			$seconds += $minutes_array[1];
		}
		 
		return $seconds;
	}
	/**
	*  Format date and time
	* Function to convert the given datetime into dd/mm/yyyy - HH:MM:SS format
	* @param datetime
	* @return formatted date and time
	*/
	function format_datetime($datetime)
	{
		return date("d/m/Y - h:i:s A", strtotime($datetime));
	}
   
	function microtime_msec() 
	{ 
   		list($usec, $sec) = explode(" ", microtime()); 
   		return ($usec/1000 + $sec*1000); 
	}
	
	function set_date_to_week_day($date, $day_number)
	{
		$date_array = explode('-', $date);
		
		$timestamp = mktime(00,00,00,$date_array[1],$date_array[2],$date_array[0]);
		
		$present_day_number = date("w",$timestamp);
		
		if($present_day_number > $day_number)
		{
			$present_day_number = $present_day_number - $day_number;
			return mktime(0, 0, 0, $date_array[1], $date_array[2]-$present_day_number, $date_array[0]);
		}
		else if ($present_day_number < $day_number)
		{
			$present_day_number = $day_number - $present_day_number;
			return mktime(0, 0, 0, $date_array[1], $date_array[2]+$present_day_number, $date_array[0]);
		}
		return $timestamp;
	}

 	function time_to_seconds ($minutes, $hours=NULL, $days=NULL, $years=NULL) {
	   $seconds = 0;
 	   $seconds += $minutes * 60;
	   if ($hours != NULL) $seconds += $hours * 3600;
	   if ($days  != NULL) $seconds += $days  * 86400;
	   if ($years != NULL) $seconds += $years * 31536000;
	  
	   return $seconds;
	}
	
	function seconds_to_time ($seconds) {
	   $retArr['years'] = floor ($seconds / 31536000);
	   if ($retArr['years'] > 1) $seconds -= $retArr['years'] * 31536000;
	
	   $retArr['days'] = floor ($seconds / 86400);
	   if ($retArr['days'] > 1) $seconds -= $retArr['days'] * 86400;
	  
	   $retArr['hours'] = floor ($seconds / 3600);
	   if ($retArr['hours'] > 1) $seconds -= $retArr['hours'] * 3600;
	
	   $retArr['minutes'] = floor ($seconds / 60);   
	   if ($retArr['minutes'] > 1) $seconds -= $retArr['minutes'] * 60;
	  
	   $retArr['seconds'] = $seconds;
	
	   return $retArr;
	}
 
	function get_int_value(&$var)
	{
		if (isset($var))
		{
			return $var;
		}
		else
		{
			return 0;
		}
	}
 	function is_date_today_or_in_future($date)
	{
		$array_date = explode("-", $date);
		
		if (count($array_date) <> 3)
		{
			return false;
		}	
		
		$unix_expiry_date = mktime(0, 0, 0, $array_date[MONTH_INDEX], $array_date[DAY_INDEX],$array_date[YEAR_INDEX]);
		$unix_current_date = mktime(0, 0, 0, date("m"), date("d"),date("Y"));

		return ($unix_expiry_date > $unix_current_date) ? true : false;
	}
    /**
	* Comparison between 2 dates
	* 
	* @param $startdate, $enddate
	* @return boolean
	* Function to compare 2 given dates 
	* The dates should be in the format YYYY-MM-DD.Returns true if the start date is greater than end date.Otherwise return false.
	* 
	*/
	function is_greater_than($start_date, $end_date)
	{
		$array_start_date = explode("-", $start_date);
		
		$array_end_date = explode("-", $end_date);
		$month_index    = 2;
		$day_index      = 0;
		$year_index		= 1;
		if (count($array_start_date) <> 3 || count($array_end_date) <> 3)
		{
			return false;
		}	
		
		$unix_start_date = mktime(0, 0, 0, $array_start_date[$month_index], $array_start_date[$day_index],$array_start_date[$year_index]);
		
		$unix_end_date   = mktime(0, 0, 0, $array_end_date[$month_index], $array_end_date[$day_index],$array_end_date[$year_index]);

		return ($unix_start_date > $unix_end_date) ? true : false;
	}
	
	/**
	* Function to remove Special charaters 
	*
	* @param string
	* @return String [after removal of special characters]	
	* First remove any slashes added by PHP (for magic quotes) and then
	* convert <b> etc. to &lt;b&gt; and finally convert all new lines
	* into <br /> (so that they are displayed correctly)
	*/
	function escape_special_chars($string)
	{
		return nl2br(htmlspecialchars(stripslashes($string)));
	}
	/**
	* Escape special characters for javascript
	*
	* @param string
	* @return String [after removal of special characters]
	* First remove any slashes added by PHP (for magic quotes)
	* Then convert HTML special characters into entities (also convert single quotes so that 
	* we can surround the resulting string in single or double quotes without issues in Javascript)
	* Then call htmlspecialchars one more time to convert &lt; into &amp;lt;. This is for some reason
	* necessary in IE (otherwise &lt;b&gt; translates to bold font instead of outputting <b>!)
	* Finally convert all new lines into <br />
	*/
	function escape_string_for_javascript($string)
	{
		return str_replace("\r\n", "", escape_special_chars(htmlspecialchars(stripslashes($string), ENT_QUOTES)));
	}

	/**
	 * Email Vaidation
	 * @param string email
	 * Return true on valid email
	*/
	function email_validate($email)
	{
 	  $result =ereg("^[^@ ]+@[^@ ]+\.[^@ ]+$",$email,$trashed);
	  
	  if(!$result) {
	  
	     return 1;
		 
	  } else {
	  
	    return 0;
	  }
	  
	}
	 /**
	 * Check for the Valid Image Extensions	 
	 * @param string Image name
	 * @Return true on valid extension
	*/
	  function image_ext_validate($img_name)
	  {
	     #Fetching the image extensions
 		 $img_strarr    = explode(".",$img_name);
		 		 
 		 if(count($img_strarr)) {
			 $imgextension  = strtolower($img_strarr[count($img_strarr)-1]);
			 
 			 if($imgextension=='jpg' || $imgextension=='jpeg' || $imgextension=='jpe' || $imgextension=='gif' || $imgextension=='bmp')
			 {
			   return true;
			   
			 } else {
			 
			   return false;
			   
			 }
			 
		 }  else {
		 
		   return false;
		   
		 }
	  }  
	  
		/**
		* Randomly select a character from the characterstring Array		
		* @Return a single randomly selected charater
		*/
		function random_char(){
		
			$charString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
				
			return($charString[rand(0, 61)]);
		}
		
		/**
		* Generates a Random string with specified length		
		* @param string String Length
		* @Return a  string with randomly selected character
		*/
		function random_string($stringSize){
		
			for($i=0; $i<$stringSize; $i++) $randomString .= random_char();
				
			return $randomString;
		}
		 
		
		/**
		* Special characters Validation		
		* @param string Text to be validated
		* @Return true only if allowed charaters are used in the text.
		*/
		function valid_chars($text)  { 
		
			$text= stripslashes($text);
			
			if(ereg("^[-&'\"/[:space:],.A-Za-z0-9]+$",$text)) return true;
			
			else return false;
	    } 
		/**
		* Alphabets Validation 		 
		* @param string Text to be validated
		* @Return true  only if allowed alphabets are used in the text.
		*/
		function valid_alphabets($text)  { 
		
			$text= stripslashes($text);
			
			if(ereg("^[-&'\"/[:space:],.A-Za-z]+$",$text)) return true;
			
			else return false;
	    } 
		/**
		* Integer Validation 		 
		* @param string  number to be validated
		* @Return true  only if the number is an integer.
		*/
		function check_int($i) {		
			 # Return 0 if not int and return 1 if $i is int 
			 # use this regualr expression for both int and float value  ^[0-9]+[.]?[0-9]*$ ///^[-+]?\d*$
 			 if (ereg("^[0-9]*$", $i, $p)) {
			 
					return 1;
					
			 } else {
			 
					return 0;
					
			 }// end if\		
		}
		/**
		* Integer & Float Validation 		 
		* @param string  number to be validated
		* @Return true  only if the number is an integer.
		*/
		function check_int_float($i) {		
			 # Return 0 if not int and return 1 if $i is int 
			 # use this regualr expression for both int and float value  
			 
 			 if (ereg("^[0-9]+[.]?[0-9]*$", $i, $p)) {
			 
					return 1;
					
			 } else {
			 
					return 0;
					
			 }// end if\		
		}
		/**
		* Coverts between 2 date formats		 
		* @param string  format (either 1 or 2),date
		* @param format = - (Current format of the date)Then Convert date from yyyy-mm-dd to dd/mm/yyyy
		* @param format = / Then Convert date from dd/mm/yyyy to yyyy-mm-dd
		* @ Return corresponding date
		*/
		function date_converter($format,$date)
		{
  		  if($date) {
		  	  # From yyyy-mm-dd to dd/mm/yyyy ==> Date format for display in public site
			  if($format=="-") {
			  
					$date_arr  	     =  explode("-",$date); 
					
					if(count($date_arr)==3){
									
						$formatted_date	 =  $date_arr[2]."/".$date_arr[1]."/".$date_arr[0];
								
					} else {
					
					 	$formatted_date="";
					}
			   }  elseif($format=="/") {  # From dd/mm/yyyy to  yyyy-mm-dd   ==> Date format for the Database
			  
					$date_arr  	     =  explode("/",$date); 
									
					if(count($date_arr)==3){
									
						$formatted_date	 =  $date_arr[2]."-".$date_arr[1]."-".$date_arr[0];		
						
					} else {
					
					 	$formatted_date="";
					}		
 			   }
		   } else {
		   
		     $formatted_date = '';
			 
		   }
 		   return $formatted_date;
		}
		
		
		function pw_encode($password)		{
		   for ($i = 1; $i <= 8; $i++)
		   $seed .= substr('0123456789abcdef', rand(0,15), 1);
		   return md5($seed.$password).$seed;
		}
		
		function pw_check($password,$stored_value)		{
		   $stored_seed = substr($stored_value,32,8);
		   return md5($stored_seed.$password).$stored_seed;
		}
		/**
		* VAT Calculation		 
		* @param string  price,vatpercentage
		* @ Return the price including VAT
		*/
		function VAT_Inclusion($amount_excl_vat,$vatpercentage)
		{
			$amount_incl_vat = $amount_excl_vat * (1 + ($vatpercentage / 100));
			
			return $amount_incl_vat;
 		}
		/**
		* Price Format to be displayed 
		* @param string  price
		* 
		*/
		function Price_Format($price)
		{
			return number_format($price, 2, '.', '');
		}

?>