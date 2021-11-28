

//The following code is to rank the menus 

//This can be used to move the menus Top, Bottom

function moveUpList(listField) {

	  if(document.getElementById("menu2_menu1_id") && document.getElementById("menu2_menu1_id").value==0) {

		alert("Please select the first level menu");

		document.getElementById("menu2_menu1_id").focus();

		return false;

	} else if(document.getElementById("menu3_menu2_id")  && document.getElementById("menu3_menu2_id").value==0) {

		alert("Please select the second level menu");

		document.getElementById("menu3_menu2_id").focus();

		return false;

	}  

	if(document.getElementById("menu4_menu3_id") && document.getElementById("menu4_menu3_id").value==0) {

		alert("Please select the Third level menu");

		document.getElementById("menu4_menu3_id").focus();

		return false;

	}

      document.frmrank.action1.value = "update";

       if (listField.length == -1) {  // If the list is empty

		  alert("There are no values which can be moved!");

	   } else {

			  var selected = listField.selectedIndex;

			  if (selected == -1) {

				 alert("You must select an entry to be moved!");

			  } else {  // Something is selected

					 if ( listField.length == 0 ) {  // If there's only one in the list

						alert("There is only one entry!\nThe one entry will remain in place.");

					 } else {  // There's more than one in the list, rearrange the list order

							if ( selected == 0 ) {

							   alert("The first entry in the list cannot be moved up.");

							} else {

							   // Get the text/value of the one directly above the hightlighted entry as

							   // well as the highlighted entry; then flip them               

							   var moveText1 = listField[selected-1].text;

							   var moveText2 = listField[selected].text;

							   var moveValue1 = listField[selected-1].value;

							   var moveValue2 = listField[selected].value;			   

							   listField[selected].text = moveText1;

							   listField[selected].value = moveValue1;

							   listField[selected-1].text = moveText2;

							   listField[selected-1].value = moveValue2;

							   listField.selectedIndex = selected-1; // Select the one that was selected before

							}  // Ends the check for selecting one which can be moved

					 }  // Ends the check for there only being one in the list to begin with

			  }  // Ends the check for there being something selected

 		 }  // Ends the check for there being none in the list 

 

}

function moveDownList(listField) {

	if(document.getElementById("menu2_menu1_id")  && document.getElementById("menu2_menu1_id").value==0) {

		alert("Please select the first level menu");

		document.getElementById("menu2_menu1_id").focus();

		return false;

	} else if(document.getElementById("menu3_menu2_id")  && document.getElementById("menu3_menu2_id").value==0) {

		alert("Please select the second level menu");

		document.getElementById("menu3_menu2_id").focus();

		return false;

	}

	if(document.getElementById("menu4_menu3_id")  && document.getElementById("menu4_menu3_id").value==0) {

		alert("Please select the fourth level menu");

		document.getElementById("menu4_menu1_id").focus();

		return false;

	}

      document.frmrank.action1.value = "update";

	  var length = listField.length; 

	   if ( listField.length == -1) {  // If the list is empty

		  alert("There are no values which can be moved!");

	   } else {

			  var selected = listField.selectedIndex;

			  if (selected == -1) {

				 alert("You must select an entry to be moved!");

			  } else {  // Something is selected

				 if ( listField.length == 0 ) {  // If there's only one in the list

					alert("There is only one entry!\nThe one entry will remain in place.");

				 } else {  // There's more than one in the list, rearrange the list order

					if ( selected == length-1 ) {

					  alert("The Last entry in the list cannot be moved up.");

					} else {

					   // Get the text/value of the one directly above the hightlighted entry as

					   // well as the highlighted entry; then flip them

					   var moveText1 = listField[selected+1].text;

					   var moveText2 = listField[selected].text;			  

					   var moveValue1 = listField[selected+1].value;

					   var moveValue2 = listField[selected].value;

					   listField[selected].text = moveText1;

					   listField[selected].value = moveValue1;

					   listField[selected+1].text = moveText2;

					  listField[selected+1].value = moveValue2;

					   listField.selectedIndex = selected+1; // Select the one that was selected before

					}  // Ends the check for selecting one which can be moved

				 }  // Ends the check for there only being one in the list to begin with

			  }  // Ends the check for there being something selected

   }  // Ends the check for there being none in the list

}

function moveTopList(listField) { 

	 if(document.getElementById("menu2_menu1_id")  && document.getElementById("menu2_menu1_id").value==0 ) {

		alert("Please select the first level menu");

		document.getElementById("menu2_menu1_id").focus();

		return false;

	} else if(document.getElementById("menu3_menu2_id")  && document.getElementById("menu3_menu2_id").value==0) {

		alert("Please select the second level menu");

		document.getElementById("menu3_menu2_id").focus();

		return false;

	}

	 if(document.getElementById("menu4_menu1_id")  && document.getElementById("menu4_menu3_id").value==0 ) {

		alert("Please select the fourth level menu");

		document.getElementById("menu4_menu1_id").focus();

		return false;

	}

	  document.frmrank.action1.value = "update";

	  var i;

	  var length = listField.length;

	  if ( listField.length == -1) {  // If the list is empty

		  alert("There are no values which can be moved!");

	   } else {

		  var selected = listField.selectedIndex;

		  if (selected == -1) {

			 alert("You must select an entry to be moved!");

		  } else {  // Something is selected

			 if ( listField.length == 0 ) {  // If there's only one in the list

				alert("There is only one entry!\nThe one entry will remain in place.");

			 } else {  // There's more than one in the list, rearrange the list order

				if ( selected == 0 ) {

				   alert("The first entry in the list cannot be moved to Top.");

				} else {

				   // Get the text/value of the one directly above the hightlighted entry as

				   // well as the highlighted entry; then flip them               

				   var moveText1 = listField[0].text;

				   var moveText2 = listField[selected].text;

				   var moveValue1 = listField[0].value;

				   var moveValue2 = listField[selected].value;			   

				   listField[selected].text = moveText1;

				   listField[selected].value = moveValue1;

				   listField[0].text = moveText2;

				   listField[0].value = moveValue2;			  

				  listField.selectedIndex = length-1; // Select the one that was selected before

				  for(i=selected;i>=2;i--)

				  {			  

					listField[i].text = listField[i-1].text;

					listField[i].value = listField[i-1].value;

				  }

				  listField[1].text = moveText1;

				  listField[1].value = moveValue1;

				}  // Ends the check for selecting one which can be moved

			 }  // Ends the check for there only being one in the list to begin with

		  }  // Ends the check for there being something selected

   }  // Ends the check for there being none in the list

}

function moveBottomList(listField) {

if(document.getElementById("menu2_menu1_id")  && document.getElementById("menu2_menu1_id").value==0) {

		alert("Please select the first level menu");

		document.getElementById("menu2_menu1_id").focus();

		return false;

	} else if(document.getElementById("menu3_menu2_id")  && document.getElementById("menu3_menu2_id").value==0) {

		alert("Please select the second level menu");

		document.getElementById("menu3_menu2_id").focus();

		return false;

	}

	if(document.getElementById("menu4_menu3_id")  && document.getElementById("menu4_menu3_id").value==0) {

		alert("Please select the fourth level menu");

		document.getElementById("menu4_menu3_id").focus();

		return false;

	}

	

  document.frmrank.action1.value = "update";

  var i;

  var length = listField.length;  

   if ( listField.length == -1) {  // If the list is empty

      alert("There are no values which can be moved!");

   } 

   else {

		  var selected = listField.selectedIndex;

		  if (selected == -1) {

			 alert("You must select an entry to be moved!");

		  } else {  // Something is selected

			 if ( listField.length == 0 ) {  // If there's only one in the list

				alert("There is only one entry!\nThe one entry will remain in place.");

			 } else { // There's more than one in the list, rearrange the list order 

			  if ( selected == length-1 ) {

				  alert("The Last entry in the list cannot be moved up.");

				} else {           

				   // Get the text/value of the one directly above the hightlighted entry as

				   // well as the highlighted entry; then flip them               

				   var moveText1 = listField[length-1].text;

				   var moveText2 = listField[selected].text;

				   var moveValue1 = listField[length-1].value;

				   var moveValue2 = listField[selected].value;			 

				   listField[selected].text = moveText1;

				   listField[selected].value = moveValue1;

				   listField[length-1].text = moveText2;

				   listField[length-1].value = moveValue2;

				   listField.selectedIndex = 0; // Select the one that was selected before

				  var lastindx =length-2;

				  for(i=selected;i<lastindx;i++)  {			  

					listField[i].text = listField[i+1].text;

					listField[i].value = listField[i+1].value;

				  }

				  listField[lastindx].text = moveText1;

				  listField[lastindx].value = moveValue1;

			   } // Ends the check for selecting one which can be moved

			 }  // Ends the check for there only being one in the list to begin with

		  }  // Ends the check for there being something selected

   }  // Ends the check for there being none in the list

}