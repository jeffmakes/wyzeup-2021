<form name="frmlogin">
	<input name="fdate" value="31-Aug-2006" type="text" onBlur="Javascript: DateValidate(frmlogin.fdate, 'DOB')"/>
</form>
<script language="javascript">
//validating the date with current date
function convertMonth(val) 
{
	var	mName =	new	Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	mLength = parseInt(mName.length);
	for(i=0; i<mLength; i++) {
		if(val == mName[i]) {
			val = i;
			break;
		}
	}
	val = val+1;
	return val;
}

function Comparedate(fdate,tdate)
{
	strarr = fdate.value.split("-");
	var d = strarr[0];
	var m = convertMonth(strarr[1]);
	var y = strarr[2];

	var strarr = tdate.value.split("-");
	var d1 = strarr[0];
	var m1 = convertMonth(strarr[1]);
	var y1 = strarr[2];
	if( y == y1)
	{
		if(m == m1)
		{
			if(d > d1)
			{
				alert("From date exceeds To date");		
				tdate.focus();
				tdate.select();
				return false;
			}
		}
		else if (m > m1)
		{
			alert("From date exceeds To date");		
			tdate.focus();
			tdate.select();
			return false;
		}
	}	
	if(y > y1)				
	{
		alert("From date exceeds To date");		
		tdate.focus();
		tdate.select();
		return false;			
	}
}

//validating the date with current date
function DateValidate(txtCtrl,val) 
{
	var ctrName = val;
	if(txtCtrl.value != "")
	{		
		var strarr = txtCtrl.value.split("-");
		var d = strarr[0];
		var m = convertMonth(strarr[1]);
		var y = strarr[2];
		var len = strarr.length;
		var result = true;
		date =new Date();
		if(len > 3 || isNaN(d) || isNaN(m) || isNaN(y) || d<1 || m<1 || m>12 || y > date.getFullYear())
		{
			result = false;
		}

		if( y == date.getFullYear())
		{
			if(m == date.getMonth()+1)
			{
				if(d >= date.getDate())
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
			alert("Please enter valid " + ctrName + ".\nThe Date should be less than today's date");		
			txtCtrl.focus();
			txtCtrl.select();
			return false;		
		}
	}
}
</script>
