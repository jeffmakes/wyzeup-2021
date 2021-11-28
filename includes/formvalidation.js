<!-- Hide From the old browsers

function TextValidate(txtCtrl,val)
{
	var ctrName = val;
 	//Remove_Spaces(txtCtrl);
	if (txtCtrl.value == "")
	{
		alert("Please enter " + ctrName + ".");
		txtCtrl.focus();	
		return false;		
	}
	/*if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' in " + ctrName + ".");		
		txtCtrl.focus();   	
		return false;		
	}*/			
}

//To validate wether given date is in the form of dd/mm/yyyy
function DateFormatValidate(txtCtrl,val)
{
	var ctrName = val;
	Remove_Spaces(txtCtrl);
	if(txtCtrl.value != "")
	{		
		var strarr = txtCtrl.value.split("-");
		/*
		var m = strarr[0];
		var d = strarr[1];
		var y = strarr[2];
		*/
		var m = strarr[1];
		var d = strarr[0];
		var y = strarr[2];
		//alert (y);		
		//alert (m);		
		//alert (d);						
		var len = strarr.length;
		date =new Date();
		if(len > 3 || isNaN(d) || isNaN(m) || isNaN(y) || d<1 || d>31 || m<1 || m>12 || y<date.getFullYear()-40)
		{
			alert("Please enter valid " + ctrName + ".");			
			txtCtrl.focus();
			txtCtrl.select();
			return false;
		}
	}
	else
	{
		alert("Please enter " + ctrName + ".");			
		txtCtrl.focus();
		txtCtrl.select();
		return false;	
	}
}

function DateFormateValidateCheck(txtCtrl,val)
{
	var ctrName = val;
	Remove_Spaces(txtCtrl);
	if(txtCtrl.value != "")
	{		
		var strarr = txtCtrl.value.split("/");
		var m = strarr[0];
		var d = strarr[1];
		var y = strarr[2];
		var len = strarr.length;
		date =new Date();
		if(len > 3 || isNaN(d) || isNaN(m) || isNaN(y) || d<1 || m<1 || m>12 || y<date.getFullYear()-40)
		{
			alert("Please enter valid " + ctrName + ".");			
			txtCtrl.focus();
			txtCtrl.select();
			return false;
		}
	}
}

/*
*	To find out wether given date is correct or not
*	Created on 05-Nov-2003
*/
function Checkdate(Lday, Lmonth, Lyear) 
{
	valid  = true;
	if(Lyear < 1970)
	{
		valid = false;
	}
	
	if(Lmonth > 12 || Lmonth < 1)
	{
		valid = false;
	}
	
	if(Lday < 1)
	{
		valid = false;
	}
	
	if( Lmonth == 2 )
	{
		if( (Lyear % 4) == 0 )
		{
			if(Lday > 29)
			{
				valid = false;
			}
		}
		else
		{
			if(Lday > 28 )
			{
				valid = false;
			}
		}
	}
	else if( Lmonth == 1 || Lmonth == 3 || Lmonth == 5 || Lmonth == 7 || Lmonth == 8 || Lmonth == 10 || Lmonth == 12)
	{
		if(Lday > 31)
		{
			valid = false;
		}
	}
	else
	{
		if(Lday > 30)
		{
			valid = false;
		}
	}

	if(valid == true)
	{
		return true;
	}
	else
	{
		alert ("Please enter valid date for "+ Lday +"-"+ Lmonth +"-"+ Lyear);
		return false;
	}
}
function DateFormateValidateCheck(txtCtrl,val)
{
	var ctrName = val;
	Remove_Spaces(txtCtrl);
	if(txtCtrl.value != "")
	{		
		var strarr = txtCtrl.value.split("/");
		var m = strarr[0];
		var d = strarr[1];
		var y = strarr[2];
		var len = strarr.length;
		date =new Date();
		if(len > 3 || isNaN(d) || isNaN(m) || isNaN(y) || d<1 || m<1 || m>12 || y<date.getFullYear()-40)
		{
			alert("Please enter valid " + ctrName + ".");			
			txtCtrl.focus();
			txtCtrl.select();
			return false;
		}
	}
}

//validating the date with current date
function DateValidate(txtCtrl,val) 
{
	var ctrName = val;
//	alert (ctrName);		
	Remove_Spaces(txtCtrl);
	if(txtCtrl.value != "")
	{		
		var strarr = txtCtrl.value.split("/");
		var d = strarr[0];
		var m = strarr[1];
		var y = strarr[2];
		var len = strarr.length;
		var result = true;
		date =new Date();
		if(len != 3 || isNaN(d) || isNaN(m) || isNaN(y) || d<1 || m<1 || m>12 || y<date.getFullYear()-40 || y > date.getFullYear())
		{
			result = false;
		}

		if( y == date.getFullYear())
		{
			if(m == date.getMonth()+1)
			{
				if(d > date.getDate())
				{
					result = false;
				}
			}
			else if (m > date.getMonth()+1)
			{
				result = false;
			}
		}					

		if (m==1 || m==3 || m==5 || m==7 || m==8 || m==10 || m==12)
		{
			if(d>31 || d<=0)
			{
				result = false;
			}	
		}
		else if(m==2)
		{	
			if(y%4 ==0)
			{
				if(d >29 || d<1)
				{
					result = false;
				}
			}
			else
			{
				if(d >28 || d<1)
				{
					result = false;
				}
			}
		}
		else
		{	
			if(d >30 || d<=0)
			{
				result = false;
			}
		}	

		if(result == false)
		{
			alert("Please enter valid " + ctrName + ".");		
			txtCtrl.focus();
			txtCtrl.select();
			return false;		
		}
	}
}

function LengthValidate(txtCtrl, val)
{
	Remove_Spaces(txtCtrl);	
	if(txtCtrl.value.length < val)
	{
		alert("The Length should be "+  val +" characters!");
		txtCtrl.focus();
		txtCtrl.select();		
		return false;		
	}
}
function TextAreaValidate(txtCtrl, val) 
{
	var ctrName	= val;
//	Remove_Spaces(txtCtrl);	
	var str = txtCtrl.value;
	if(str.length == 0)
	{
		alert("Please enter " + ctrName + ".");
		txtCtrl.focus();	   	
		return false;
	}		
	if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' in " + ctrName + ".");		
		txtCtrl.focus();   	
		return false;		
	}			
}

//-----------------------------------------------------------
function NumberValidate(txtCtrl, val) 
{
	var ctrName = val;
	Remove_Spaces(txtCtrl);
	if (txtCtrl.value == "" )
	{
		alert("Please enter " + ctrName + ".");
		txtCtrl.focus();	   	
		txtCtrl.select();
		return false;
	}
	if(isNaN(txtCtrl.value)) 
	{
		alert("Please enter numeric value for " + ctrName + ".");
		txtCtrl.focus();	   	
		txtCtrl.select();
		return false;
	}
}

function NumberValidateCheck(txtCtrl) 
{
	Remove_Spaces(txtCtrl);
	var fLength = txtCtrl.value.length;
	if (fLength == 0) 
	{
		alert("please enter the numeric value");
		txtCtrl.focus();
 		return false;
	}		

	if (txtCtrl.value == "" || isNaN(txtCtrl.value))
	{
		alert("The value " + txtCtrl.value + " is not a valid data.\n\r" +  
			"Enter numeric values !");		
		txtCtrl.focus();
		txtCtrl.select();
		return false;	
	}		
}

//-----------------------------------------
// Req field
function EmailValidate(txtCtrl, val) 
{
	var ctrName = val;
	if (txtCtrl.value.indexOf("@") < 1 ||txtCtrl.value.indexOf(".") < 0) 
	{
		alert("Please enter valid " + ctrName + ".\t\n eg: username@domainname.com");
		txtCtrl.focus();	   	
		txtCtrl.select();
		return false;
	}		
	if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' in " + ctrName + ".");		
		txtCtrl.focus();   	
		return false;		
	}			
}

// Not req, but check format - use onblur
function EmailValidateCheck(txtCtrl) {
	var xlogus = txtCtrl.value.length;
	Remove_Spaces(txtCtrl);
	txtCtrl.value=txtCtrl.value.replace(/ \*/g,"");

	if (xlogus == 0) {
 		return false;
	}
	if (txtCtrl.value.indexOf("@") < 2 || txtCtrl.value.indexOf(".") < 2 || txtCtrl.value.indexOf(" ") > 0) {
		alert("Please enter a valid email.");
		txtCtrl.focus();
		return false;
	}		
	
	/*
	the below function is to verify & find out whether the @ character and "." are given with each other
	which denotes it is a invalid email id
	*/
	
	/*
		Find if the "." has atleast two characters after it
		if not we may decide it is Invalid Id
	*/

	//if (txtCtrl.value.length - txtCtrl.value.indexOf(".") > 2);

	//	alert (txtCtrl.value.length - txtCtrl.value.indexOf("."));
	if (txtCtrl.value.indexOf("@.") > -1 || (txtCtrl.value.length - txtCtrl.value.indexOf(".") <= 2))
	{
		alert("Please verify the Email Id");
		txtCtrl.focus();
		return false;
	}

	
	if(txtCtrl.value.indexOf("'") > -1){		
		alert("Please Don't enter ' ." );		
		txtCtrl.focus();   	
		return false;		
	}			
}


/*
// Not req, but check format - use onblur
function EmailValidateCheck(txtCtrl, val) 
{
	var xlogus = txtCtrl.value.length;
	if(!val)
		val = txtCtrl.name;
	if (xlogus == 0) 
	{
 		return false;
	}
	if (txtCtrl.value.indexOf("@") < 1 ||txtCtrl.value.indexOf(".") < 0) 
	{
		alert("Please enter a valid email id.");
		txtCtrl.focus();	
		txtCtrl.select();
		return false;
	}		
	if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' ." );		
		txtCtrl.focus();   	
		return false;		
	}			
}
*/

//-----------------------------------------
// Req
function PhoneValidate(txtCtrl,val) 
{
	var ctrName = val;

	var strarr = txtCtrl.value.split("-");
	var first = strarr[0];
	var last = strarr[1];
	if (txtCtrl.value.indexOf("-") < 3 || isNaN(first) || isNaN(last)|| txtCtrl.value.indexOf(".") != -1 || first.length < 3 || last.length < 4 ) 
	{
		alert("Please enter a valid phone number.");
		txtCtrl.focus();	   	
		return false;
	}		

	if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' in " + ctrName + ".");		
		txtCtrl.focus();   	
		return false;		
	}			
}


// Not req, but check format - use onblur
function PhoneValidateCheck(txtCtrl) 
{
	var xlogus = txtCtrl.value.length;
	if (xlogus == 0) 
	{
 		return false;
	}
	var strarr = txtCtrl.value.split("-");
	var first = strarr[0];
	var last = strarr[1];
    if(txtCtrl.value.indexOf("-") < 3 || isNaN(first) || isNaN(last)|| txtCtrl.value.indexOf(".") != -1 || first.length < 3 || last.length < 4 )
	{
		alert("Please enter a valid phone number.");
		txtCtrl.focus();	   	
		return false;
	}		
	if(txtCtrl.value.indexOf("'") > -1)
	{
		alert("Please Don't enter ' in " + ctrName + ".");		
		txtCtrl.focus();   	
		return false;		
	}			
}

 // 000 use onblur 
function ZeroValidate(txtCtrl , val)
{
		var xlogus = txtCtrl.value.length;
		if (xlogus == 0) 
		{
			return false;
		}
		 
	 if (NumberValidateCheck(txtCtrl, 'Quantity') == false) return false;
				
		var txtValue = txtCtrl.value;		

		if (txtValue == 0 || txtValue == 0.00)
		{
			alert('Zero value is not allowed for '+val);
			txtCtrl.focus();
			return false;	
		}
}

//-------------------------
// Req
function SelValidate(selCtrl) 
{
	if (selCtrl.value == "" || selCtrl.value == "0" || selCtrl.value == "-1" || selCtrl.value.indexOf("Please") != -1) 
	{
		alert("Please select an option in the list.");
		selCtrl.focus();	   	
		return false;
	}		
}



function SelectValidate(selCtrl,msg) 
{
	if (selCtrl.value == "" || selCtrl.value == "0" || selCtrl.value == "-1" || selCtrl.value.indexOf("Please") != -1) 
	{
		alert("Please select " + msg +".");
		selCtrl.focus();	   	
		return false;
	}		
}


function OptValidate(optCtrl) 
{
    var el = document.forms[0].elements;
	for(var i = 0 ; i < el.length ; ++i)
	{
		if(el[i].type == "radio")
		{
			var radiogroup = el[el[i].name]; // get the whole set of radio buttons.
			var itemchecked = false;
			for(var j = 0 ; j < radiogroup.length ; ++j) 
			{
				if(radiogroup[j].checked)
				{
				  itemchecked = true;
				  break;
				}
    		}
			if(!itemchecked) 
			{
				alert("Please choose an option for "+el[i].name+".");
				if(el[i].focus)
					el[i].focus();
				return false;
			}
	   	}
  	}
} // Function End

function CloseWindow() 
{
	window.close();
	window.opener.focus();
} 

function Remove_Spaces(txtCtrl)
{
  txtCtrl.value = txtCtrl.value.replace(/\r/g, " ");

  txtCtrl.value = txtCtrl.value.replace(/[^ A-Za-z0-9`~!@#\$%\^&\*\(\)-_=\+\\\|\]\[\}\{'";:\?\/\.>,<]/g, "");

  txtCtrl.value = txtCtrl.value.replace(/'/g, "");

  txtCtrl.value = txtCtrl.value.replace(/ +/g, " ");

  txtCtrl.value = txtCtrl.value.replace(/^\s/g, "");

  txtCtrl.value = txtCtrl.value.replace(/\s$/g, "");
  
  if (txtCtrl.value == ' ')
  {
	 txtCtrl.value = '';
   }
 
 }
//-->

function LeastPass(txtCtrl)
{
	
//	if (txtCtrl1.value.length <5)

}

// Function for Compare Two passwords
function Comparetextboxes(txtCtrl1, txtCtrl2) 
{
	//Find length
	if(txtCtrl1.value.length < 5)
	{
		alert("The password should be atleast 5 characters !");
		txtCtrl1.focus();	
		return false;
	}
	// Find length
	if(txtCtrl2.value.length <5)
	{
		alert("The confirm password should be atleast 5 characters !");
		txtCtrl2.focus();	
		return false;
	}		

	if (txtCtrl1.value != txtCtrl2.value) 
	{
		alert("The  password and confirmation password do not match !");
		txtCtrl1.focus();	   	
		return false;
	}
}

function chkFile(frmName)	
{
	if(frmName.file.value != "")	
	{
		var strarr = frmName.file.value.split(".");
		var len = strarr.length;
		if(len != 2)
		{
			alert("Please check file name !");
			frmName.file.focus();
			frmName.file.select();
			return false;
		}
		var type = strarr[1];						
		if (type < 3) {							
			alert("Please check file format !");
			frmName.file.select();
			return 1;
		}						
	}		
}

function FileValidate(ctrl,msg)	
{
	if(ctrl.value != "")	
	{
		var strarr = ctrl.value.split(".");
		var len = strarr.length;
		if(len != 2)
		{
			alert("Please check file name !");
			ctrl.focus();
			ctrl.select();
			return false;
		}
		var type = strarr[1];						
		if (type < 3) {							
			alert("Please check file format !");
			ctrl.select();
			return 1;
		}						
	}
	else
	{
		alert(msg);
		return false;
	}
}

// ----------------------Logu inserted on Feb 06, 2003, 11:21 GMT HRS 				
<!-- Begin
function checkLength(field, countfield, maxlimit) 
{
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
		countfield.value = maxlimit - field.value.length;
}
// End -->

// To check whether the minitues is Valid
// Jyothi - 4th June - 2003
function MinuteValidate(minitue)
{
	var mintueval = parseInt(minitue.value);
	
	if( mintueval > 59 || mintueval < 0)
	{
		alert("Please Enter valid Minutes");
		minitue.focus();
		minitue.select();
		return false;
	} 
}

// To check whether start time is less than end time
// Jyothi - 4th June - 2003
function TimeValidate(start_H, start_M, end_H, end_M)
{
	var s_hour = parseInt(start_H.value);
	var s_min  = parseInt(start_M.value);
	var e_hour = parseInt(end_H.value);
	var e_min  = parseInt(end_M.value);
	
	if ( s_hour > e_hour )
	{
		alert("Start time should be less than end time");
		end_H .focus();
		return false;
	}
	else if ( s_hour == e_hour )
	{
		if ( s_min > e_min )
		{
//			var str = "String1: " + s_hour + "String2: " + e_hour
			alert("Start time should be less than end time");
			end_M .focus();
			return false;
		}
		else if ( s_min == e_min )
		{
			alert("Start time should not be same");
			end_H.focus();
			return false;
		}
	}					
}

// ----------------------SAR inserted on December 30th , 2003------
<!-- Begin
//To compare the from date with to date
function Comparedate(fdate,tdate)
{
	var strarr = fdate.value.split("/");
	
	splitter=fdate.value.substr(2,1);
	strarr = fdate.value.split(splitter);	
	var d = strarr[0];
	var m = strarr[1];
	var y = strarr[2];

	splitter=tdate.value.substr(2,1);
	var strarr = tdate.value.split("/");
	var d1 = strarr[0];
	var m1 = strarr[1];
	var y1 = strarr[2];

if( y == y1)
	{
		if(m == m1)
		{
			if(parseInt(d) > parseInt(d1))
			{
				alert("From date exceeds To date");		
				tdate.focus();
				tdate.select();
				return false;
			}
		}
		else if (parseInt(m) > parseInt(m1))
		{
			alert("From month exceeds To date");		
			tdate.focus();
			tdate.select();
			return false;
		}
	}	
	if(parseInt(y) > parseInt(y1))				
	{
		alert("From year exceeds To date");		
		tdate.focus();
		tdate.select();
		return false;			
	}
}

function redirectpage(url_page)
{
	window.location.href= url_page;
}
function GoBack()
{
	window.history.back(-1);
}


//This is new changed by saravanan

function dateDifference(strDate1,strDate2){
     datDate1= Date.parse(strDate1);
     datDate2= Date.parse(strDate2);
     alert((datDate2-datDate1)/(24*60*60*1000))
}

function Comparedate_full(fdate,tdate)
{
	var strarr = fdate.value.split("-");
	
	splitter=fdate.value.substr(4,1);
	strarr = fdate.value.split(splitter);	
	var d = strarr[2];
	var m = strarr[1];
	var y = strarr[0];

	splitter=tdate.value.substr(4,1);
	var strarr = tdate.value.split(splitter);
	var d1 = strarr[2];
	var m1 = strarr[1];
	var y1 = strarr[0];
	if( y == y1)
	{
		if(m == m1)
		{
			if(d > d1)
			{
				alert("Please enter the date today onwards");		
				tdate.focus();
				tdate.select();
				return false;
			}
		}
		else if (m > m1)
		{
			alert("Please enter the date today onwards");		
			tdate.focus();
			tdate.select();
			return false;
		}
	}	
	if(y > y1)				
	{
		alert("Please enter the date today onwards");		
		tdate.focus();
		tdate.select();
		return false;			
	}
}
function TimeValidate_full(start_H, start_M, end_H, end_M)
{
	var s_hour = start_H;
	var s_min  = start_M;
	var e_hour = end_H;
	var e_min  = end_M;
	if ( s_hour > e_hour )
	{
		alert("Start time should be less than end time");
		//end_H .focus();
		return false;
	}
	else if (s_hour == e_hour)
	{
		if ( s_min > e_min )
		{
//			var str = "String1: " + s_hour + "String2: " + e_hour
			alert("Start time should be less than end time");
			//end_M .focus();
			return false;
		}
		else if ( s_min == e_min )
		{
			alert("Start time should not be same");
			//end_H.focus();
			return false;
		}
	}					
}

function am_check(val){
	if(val>=12){
		document.appt_form.fampm.options[1].selected=true;
		document.appt_form.fampm.disabled=true;
	}else{
		document.appt_form.fampm.options[0].selected=true;
		document.appt_form.fampm.disabled=true;
	}
}
function pm_check(val){
	if(val>=12){
		document.appt_form.tampm.options[1].selected=true;
		document.appt_form.tampm.disabled=true;
	}else{
		document.appt_form.tampm.options[0].selected=true;
		document.appt_form.tampm.disabled=true;
	}
}




// only characters or/and numbers
var numb = '0123456789';
var lwr = 'abcdefghijklmnopqrstuvwxyz';
var upr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var splchars = "&/.;-,_'"+'"'+" ";

function isValid(parm,val) {
  if (parm == "") return true;
  for (i=0; i<parm.length; i++) {
    if (val.indexOf(parm.charAt(i),0) == -1) return false;
  }
}

function isNum(parm) {return isValid(parm,numb);}
function isLower(parm) {return isValid(parm,lwr);}
function isUpper(parm) {return isValid(parm,upr);}
function isAlpha(parm) {return isValid(parm,lwr+upr);}
function isAlphanum(parm) {return isValid(parm,lwr+upr+numb);}
function isAlphanum_spl(parm) {return isValid(parm,lwr+upr+numb+splchars);}
function isDecimal(parm) {return isValid(parm,numb+'.');}

// test for one and only one occurrence of a given character in the input
function oneOnly(parm,chr,must) {
	var atPos = parm.indexOf(chr,0);
	if (atPos == -1) {return !must;}
	if (parm.indexOf(chr, atPos + 1) > - 1) {
	return false; 
	}
}

// End -->
