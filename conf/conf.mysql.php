<?php
/**
 * @ DATABASE Connectivity
 */
class dbclass1 
{
 	/** @var string Holds the name/ip of the database server. */
	var $host;
 	/** @var string Holds the port number on which the database server is running. */	
	var $port;
 	/** @var string Holds the name of the database to connect. */	
	var $dbname;
 	/** @var string Holds the database username. */		
	var $user;
 	/** @var string Holds the password of the database user. */			
	var $passwd;
	/** @var resource Holds the connection object. */			
	var $conn;
 	/** @var resource Holds the record set object. */			
	var $result;
	/**
	* Constructor method for this class. 
	* This method is acutomcatically called on initialization of the class .
	* The variables are initialized. 
	* @access   public
	*/

function dbclass1() {
		$this->host		= DB_URL;
		$this->port 	= DB_PORT;
		$this->dbname 	= DB_NAME;
		$this->user 	= DB_USERNAME;
		$this->passwd 	= DB_PASSWORD;
		$this->conn 	= mysql_connect($this->host, $this->user, $this->passwd) or die(" Unable to make Database Connection");		
		mysql_select_db($this->dbname);
        //register_shutdown_function($this->close);		//call back function to close connection		
		$this->result="";
	}
 function query($query) {
       $this->result = mysql_query($query);
       return $this->result;
   }
  function insert_id(){
		return mysql_insert_id();	
	}
	function num_rows($rs) {
       //$rowcount = mysql_num_rows($this->result);
	   $rowcount = mysql_num_rows($rs);
       return $rowcount;
   }   
    function fetch_array($rs) {
       //$row = mysql_fetch_array($this->result);
	   $row = mysql_fetch_array($rs);
       return $row;
   } 
}

//mysql_connect(DB_URL, DB_USERNAME, DB_PASSWORD);
//mysql_select_db(DB_NAME);
/**
 * @return db_excuted_query
 * @param  $query
 * @desc wrapper function for mysql_query
*/
function db_return($query){
	return mysql_query($query);
}
/**
 * @return number of rows
 * @param  db_object
*/
function db_return_count($query_return){
	return mysql_num_rows($query_return);
}
/**
 * @return insert id
 * @ desc returns the ID of last insertion
*/
function db_return_new_id(){
	return mysql_insert_id();	
}
/**
 * @return number of affected rows 
  * desc returns the number of affected rows as a result of any updation
*/
function db_return_affected_rows(){
 	return mysql_affected_rows();
}

function db_error() {
	return mysql_error();
}

/**
 * @return db_object
 * @param db_point $query_return
 * @desc wrapper function for mysql_fetch_object
*/
function db_return_object($query_return){
	return mysql_fetch_object($query_return);
}
/**
 * @return db_array
 * @param db_point $query_return
 * @desc wrapper function for mysql_fetch_array
*/
function db_return_array($query_return){
	return mysql_fetch_array($query_return);
}
/**
 * @return db_object
 * @param  $query
 */
 function db_execute_query($query)
{
	$query_result = db_return($query);
	
	if (!$query_result)  
	{
		trigger_error("Database Error: ".db_error(), E_USER_ERROR);	
	}
	return $query_result;
}

/**
* Function to check the unique value
* @Param tablename 
* @Param fieldid
* @Param where condition
* @return boolean
*  
*/

function check_unique($tablename,$field_id,$where)
{
	$query_select  = 'SELECT '.$field_id.' as id FROM '.$tablename.' WHERE '.$where;

 	$query_result  = db_execute_query($query_select);
	
 	$query_count   = db_return_count($query_result);
	
  	return ($query_count == 0) ? false : true;
}

/**
 * @return true or false
 * @param  tablename , fieldname [fieldname to be verfied in the table ], fieldvalue [value to be verfied in the table ]
 * @desc  on existence of data in the db it will return true
*/
function check_row_exists($table_name, $field_name1, $field_value1,$field_name2, $field_value2)
{
	$query_select = "select $field_name1 from $table_name where $field_name1 = '$field_value1' AND $field_name2 = '$field_value2'";
 	$query_result = db_execute_query($query_select);

	$query_count  = db_return_count($query_result);

	return ($query_count == 0) ? false : true;
}
function check_row_exists_two($table_name, $field_name1, $field_value1,$field_name2, $field_value2,$field_name3, $field_value3)
{
	$query_select = "select $field_name1 from $table_name where $field_name1 = '$field_value1' AND $field_name2 = $field_value2 AND $field_name3 = $field_value3";
 	$query_result = db_execute_query($query_select);

	$query_count  = db_return_count($query_result);

	return ($query_count == 0) ? false : true;
} 
 function check_row_exists_cond($table_name, $field_name, $field_value, $field_name1, $field_value1,$field_name2,$field_value2)
{
	$query_select = "select $field_name from $table_name where $field_name = '$field_value' and $field_name1 = '$field_value1' and $field_name2 = '$field_value2'";
 	$query_result = db_execute_query($query_select);
	$query_count = db_return_count($query_result);
 	return ($query_count == 0) ? false : true;
}
/**
 * @return true or false
 * @ Check for the existence of data in the DB while updatiion
 * @param  tablename , fieldname [fieldname to be verfied in the table ], fieldvalue [value to be verfied in the table ], fieldname1 , fieldalue1
 * @desc  on existence of data in the db it will return true
*/
function check_row_exists_update($table_name, $field_name, $field_value,$field_name_type, $field_type_value ,$to_ignore_field_name, $to_ignore_field_value )
{
	$query_select 	= "select $field_name from $table_name where $field_name = '$field_value' AND $field_name_type = '$field_type_value' and $to_ignore_field_name != '$to_ignore_field_value'";
 
 	$query_result 	= db_execute_query($query_select);
 
 	$query_count 	= db_return_count($query_result);
 
 	return ($query_count == 0) ? false : true;
}

function check_row_exists_for_row_type($table_name, $field_name, $field_value, $field_name_type, $field_type_value){
	$query_select = "select $field_name from $table_name where $field_name = '$field_value' and $field_name_type = '$field_type_value'";
 	
	$query_result = db_execute_query($query_select);
	
	$query_count = db_return_count($query_result);
 	
	return ($query_count == 0) ? false : true;
}

/*function check_row_exists_for_row_type_update($table_name, $field_name, $field_value, $to_ignore_field_name, $to_ignore_field_value, $field_name_type, $field_type_value){
	
	$query_select = "select $field_name from $table_name where $field_name = '$field_value' and $field_name_type = '$field_type_value' and $to_ignore_field_name != '$to_ignore_field_value'";
  	
	$query_result = db_execute_query($query_select);
	
	$query_count = db_return_count($query_result);
	
	return ($query_count == 0) ? false : true;
}*/
function check_row_exists_for_row_type_update_two($table_name, $field_name, $field_value, $to_ignore_field_name, $to_ignore_field_value, $field_name3,$field_value3,$field_name_type, $field_type_value){
	
	echo $query_select = "select $field_name from $table_name where $field_name = '$field_value' and $field_name_type = '$field_type_value'  and $field_name3 = $field_value3 and $to_ignore_field_name = '$to_ignore_field_value'";

	$query_result = db_execute_query($query_select);
	
	$query_count = db_return_count($query_result);
	
	return ($query_count == 0) ? false : true;
}
function check_row_exists_for_row_type_update($table_name, $field_name, $field_value, $to_ignore_field_name, $to_ignore_field_value, $field_name_type, $field_type_value){
	
	$query_select = "select $field_name from $table_name where $field_name = '$field_value' and $field_name_type = '$field_type_value' and $to_ignore_field_name != '$to_ignore_field_value'";
  	$query_result = db_execute_query($query_select);
	$query_count = db_return_count($query_result);
	return ($query_count == 0) ? false : true;
}

function check_code_value_exists($table_name, $field_name, $field_value)
{
	
	$query_select = "select $feild_name from $table_name where $feild_name = $feild_value";
	
 	$query_result = db_execute_query($query_select);
	
 	$query_count  = db_return_count($query_result);
	
 	if ($query_count == 0) false ;
	
	else { 
	
		$result_array  =  db_return_array($query_result);
		
		return $result_array[$field_name];
		
	}
}

/**
* Function to get a single value from the table based on the fieldname and field values given
* @param  $tablename
* @param  $fieldvalue
* @param  $fieldname
* @param  $selectfieldname
*/
function get_name($table, $fieldvalue, $selectfieldname = 'name', $fieldname = 'id'){
	$q = "SELECT $selectfieldname AS value FROM $table WHERE $fieldname = '$fieldvalue'";
  	$qr = db_execute_query($q);
 	$qo = db_return_object($qr);
  	return $qo->value;
}

function maximum_value_of_column($table_name, $field_name, $field_name_type, $field_name_type_value)
{
	$query_select  		= "select max($field_name) as max_field_name from $table_name where $field_name_type =$field_name_type_value";
	
	$query_result   	= db_execute_query($query_select);
	
	$data 				= db_return_object($query_result);
	
	$max_field_value 	= $data->max_field_name;
 	
	return $max_field_value;
}

function decrement_value_in_column($table_name, $field_name, $field_value, $field_name_type, $field_name_type_value)
{
	$query_decrement = "update $table_name SET $field_name = $field_name - 1  WHERE $field_name > $field_value AND $field_name_type = $field_name_type_value";
	
 	db_execute_query($query_decrement);
}

function increment_value_in_column($table_name, $field_name, $field_value, $field_name_type, $field_name_type_value)
{
	$query_decrement = "update $table_name set $field_name = $field_name + 1 where $field_name > $field_value
								and $field_name_type = $field_name_type_value";

 	db_execute_query($query_decrement);
}

 
/**
 * @ Generates a list box with the specified option
 * @return data - Select box with options specified
 * @param  1. tablename 
 		   2. defaultid - option that is selected by default
 		   3. alpha 	-  sorting option
		   4. formname 	-  Control name [ Name of the List control ]
		   5. limit 	-  If any where condition specified
		   6. idname 	-   field value
		   7. fieldname -   field name in the table
		   8. sign		
		   9.Classname	- style to be applied to the ctrl
 */
function generate_list($table, $default_id = 0, $alpha = 0, $form_name = 0, $limit = 0, $id_name = 'id', $field_name = 'name', $sign = '<=',$class_name=0){
	if(!$form_name) $form_name = $table;
	
	$q 			   = 'select '.$id_name.' as id, '.$field_name.' as name from '.$table;
	if($limit) $q .= ' where '.$id_name. $sign .$limit;
	if($alpha) $q .= ' order by name';
	$qr 		   = db_return($q);
	$qc 		   = db_return_count($qr);
	if($qc){
	
		$data = '<select name='.$form_name.' class='.$class_name.'>';
		$data .= '<option value=0>Select One';
		
		for($i=0; $i<$qc; $i++){
		
			$qo 	= db_return_object($qr);
			$data .= '<option value='.$qo->id;	
			if($default_id == $qo->id) $data .= ' selected';
			$data .= '>'.$qo->name;
			
		}
		
		$data .= '</select>';
	} else { 
		 $data = '<br>No entries in database for '.$table.'<br>';
	}
	return $data;
}
/**
 * @ Generates a list box with the specified option
 * @return data - Select box with options specified
 * @param  1. tablename 
 		   2. defaultid - option that is selected by default
 		   3. alpha 	-  sorting option
		   4. formname 	-  Control name [ Name of the List control ]
		   5. where 	-  If any where condition specified
		   6. idname 	-   field value
		   7. fieldname -   field name in the table
		   8. sign		
		   9.Classname	- style to be applied to the ctrl
 */
function generate_list_where($table, $default_id = 0, $alpha = 0, $form_name = 0, $where = 0, $id_name = 'id', $field_name = 'name', $sign = '<=',$class_name=0,$first_option='Select One',$onchange=''){
	if(!$form_name) $form_name = $table;
 	$q = 'select '.$id_name.' as id, '.$field_name.' as name from '.$table;
	$q .= ' where '.$where;
	if($alpha) $q .= ' order by name';
	$qr = db_return($q);
	$qc = db_return_count($qr);
 	if($qc){
		$data = '<select name='.$form_name.' class='.$class_name.' '. $onchange.'>';
		$data .= '<option value=0>'.$first_option;
		for($i=0; $i<$qc; $i++){
			$qo = db_return_object($qr);
			$data .= '<option value='.$qo->id;	
			if($default_id == $qo->id) $data .= ' selected';
			$data .= '>'.$qo->name;
		}
		$data .= '</select>';
	}
	else $data = '<br>No entries in database for '.$table.'<br>';
	return $data;
}

function generate_list_dummy($dummy_text, $form_name = 'name', $class_name=0){
	$data = '<select name='.$form_name.' class='.$class_name.'>';
	$data .= '<option value=0>'.$dummy_text.'</option>';
	$data .= '</select>';
	return $data;
}
 
// GENERATES HTML LIST, PRESELECTS ON $default_id, list opper bound and lower bound is passed.  
function generate_list_sort($ctrl_name, $default_id='',$class='input-form'){
	echo '<select name='.$ctrl_name.' class="'.$class.'">';
	if ($default_id=="") {
		echo '<option value="" selected>-</option>';
	} else {
		echo '<option value="">-</option>';
	}		
	if ($default_id=="ASC") {
		echo '<option value="ASC" selected>Ascending</option>';
	} else {
		echo '<option value="ASC">Ascending</option>';
	}
	if ($default_id=="DESC") {
		echo '<option value="DESC" selected>Descending</option>';
	} else {
		echo '<option value="DESC">Descending</option>';
	}		
	echo '</select>';
}  
	
/**
 * @ Generates a list box between the specified ranges
 * @return data - Select box with options specified
 * @param  1. ctrlname	controlname 
 		   2. lbound 	-  lower bound
 		   3. ubound 	-  upper bound
		   4. defaultid	-  option that is selected by default
		   5. firstoption  
		   6. sort  
 		   7.Classname	- style to be applied to the ctrl
 */
function generate_list_from_range($ctrl_name, $lbound, $ubound,$default_id=0,$first_option=0,$sort=0,$class='form'){
	if(!$ctrl_name) $ctrl_name = "selyear";		//if no string is specified
	echo '<select name='.$ctrl_name.' class="'.$class.'">';
	if ($first_option)
		echo '<option value=0>'.$first_option.'</option>';
	if ($sort){
		for($i=$ubound; $i>=$lbound; $i--){
			echo '<option value='.$i;	
			if($default_id == $i) echo ' selected';
			echo '>'.$i . '</option>';
		}					
	}
	else {
		for($i=$lbound; $i<=$ubound; $i++){
		echo '<option value='.$i;	
		if($default_id == $i) echo ' selected';
		echo '>'.$i . '</option>';
		}
	}
	echo '</select>';
}  
	
/**
 * @ Generates a list box from a 2Dimensional array
 * @return data - Select box with options specified
 * @param  1. ctrlname	controlname 
 		   2. arr	-  array name
 		   3. defaultid	-  option that is selected by default
		   4. firstoption  
		   6. sort  
 		   7.Classname	- style to be applied to the ctrl
 */
 function generate_list_from_2Darray($ctrl_name, $arr,$default_id=0,$first_option=0,$sort=0,$class='form'){
	if(!$ctrl_name) $ctrl_name = "selmonth";		//if no string is specified
	echo '<select name='.$ctrl_name.' class="'.$class.'">';
	if ($first_option)
	echo '<option value=0>'.$first_option.'</option>';
	for($i=0; $i<sizeof($arr); $i++){
		echo '<option value='.$arr[$i][0];	
		if($default_id == $arr[$i][0]) echo ' selected';
		echo '>'.$arr[$i][1]. '</option>';
	}
	echo '</select>';
}  
	

/**
 * @ Generates a list box from a an array
 * @return data - Select box with options specified
 * @param  1. ctrlname	controlname 
 		   2. arr	-  array name
 		   3. defaultid	-  option that is selected by default
		   4. firstoption  
		   6. sort  
 		   7.Classname	- style to be applied to the ctrl
 */
 
 function generate_list_from_array($ctrl_name, $arr,$default_id=0,$first_option=0,$sort=0,$class='form',$onchange=""){
	if(!$ctrl_name) $ctrl_name = "selectlist";		//if no string is specified
	echo '<select name='.$ctrl_name.' class="'.$class.'" onChange="'.$onchange.'">';
	//if ($first_option)
		echo '<option value=0>'.$first_option.'</option>';
	foreach ($arr as $key=>$value)
	{
		echo "<option value='$key'";
		if($key==$default_id)
			 echo " selected";
		echo ">$value</option>";
	}		
	echo '</select>';
}  /*
 function generate_list_from_array($ctrl_name, $arr,$default_id=0,$first_option=0,$sort=0,$class='form'){
	if(!$ctrl_name) $ctrl_name = "selectlist";		//if no string is specified
	echo '<select name='.$ctrl_name.' class="'.$class.'">';
	if ($first_option)
		echo '<option value=0>'.$first_option.'</option>';
	foreach ($arr as $key=>$value)
	{
		echo "<option value='$key'";
 		if($key==$default_id)
			 echo " selected";
		echo ">$value</option>";
	}		
	echo '</select>';
}  */
?>
