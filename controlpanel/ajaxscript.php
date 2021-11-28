'<script language="javascript">
//XMLhttp variable will hold the XMLHttpRequest object
var xmlhttp = false;
// If the user is using Mozilla/Firefox/Safari/etc
if (window.XMLHttpRequest) {
        //Intiate the object
        xmlhttp = new XMLHttpRequest();
		//xmlhttp.setHeader("Cache-Control", "no-cache");
        //Set the mime type
        xmlhttp.overrideMimeType('text/xml');
}
// If the user is using IE
else if (window.ActiveXObject) {
        //Intiate the object
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		//xmlhttp.setHeader("Cache-Control", "no-cache");
		//Http.get(params, callback_args)
}
function Menu_List(searchvalue,searchtype) { 

 	//If the form data is *not* blank, query the DB and return the results
	  	if(searchvalue !== "" && searchvalue !== 0) {
		if(document.getElementById("question_list")){
			document.frmrank.question_list.length=0;
			document.frmrank.question_list.options[0]=new Option('Loading...',0);
		} 		
		
  		var url = 'query.php?searchvalue='+searchvalue+'&searchtype='+searchtype;
 		//Open the URL above "asynchronously" (that's what the "true" is for) using the GET method
		xmlhttp.open('GET', url, true);
		//Check that the PHP script has finished sending us the result
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					//Replace the content of the "result" DIV with the result returned by the PHP script
  					var dataarray     = xmlhttp.responseText;
  					var i,j;
					var value;
 					//Check , whether ti list in the setup listbox or result list box
					if(searchtype=='question') { 							       
						if(document.frmrank.question_list.length!=null) {
							document.frmrank.question_list.length=0;
						} 													
 						if(dataarray){
 							//document.frmrank.question_list.options[0]=new Option('Region/City',0);
 							var optionsarray =  dataarray.split(":");
 							for(i=0;i<optionsarray.length;i++)
							{	
									j=i;
									//j=j+1;
 									var value = optionsarray[i].split("#");
									if(value[1]==0) {
										document.frmrank.question_list.length=0;
										document.frmrank.question_list.options[0]=new Option('Questions Not Available',0);
									} else {
										document.frmrank.question_list.options[j]=new Option(value[0],value[1]);
 									}
								}  //end of for loop
 					   	} 
  			 	   } 
				   
		}  //End of function
	xmlhttp.send(null);  
	} 
}
</script>