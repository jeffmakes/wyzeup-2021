
			  D T R - Dynamic Text Replacement
================================================================================
			   (Revision by joaomak.net)

 
				      HOW TO INSTALL
--------------------------------------------------------------------------------

1. In the beggining of the HTML insert:

	<?php include 'dtr/dtr.php'; ?>
	
   And at the bottom:

	<?php ob_end_flush(); ?>


2. Link the style sheet inside the <head>:

	<link href="dtr/headings.css" rel="stylesheet" type="text/css" />
	
   or inside your css:
   
   	@import "dtr/headings.css";
   	
   and start styling!
  
   	
3. Copy your font files (.ttf) to the DTR folder.


4. Assign write permissions to the cache folder inside the DTR folder for faster 
   performance.



					     NOTES
--------------------------------------------------------------------------------

* Only headings without attributes will be replaced.

* This is an open source script. Feel free to use it but if you make any changes, 
  share it too! 



