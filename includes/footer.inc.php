<?php
	$today = date("F j Y");
	$curdate = explode(" ",$today); 
	echo '<div id="footer">
				<div id="footerboxleft">
						<a href="index.php" title="Home">Home</a> | 
						<a href="about_us.php" title="About Us">About us</a> | 
						<a href="how_it_works.php"  title="How it works">How it works</a> | 
						<a href="pshce_curriculam.php"  title="PSHCE curriculam">PSHCE curriculum</a> | 
						<a href="contact_us.php"  title="Contact Us">Contact</a> | 
						<a href="sitemap.php" title="Site map">Site map</a><br>
						&copy; Copyright '.$curdate[2].' - Wyze Up - <a href="http://www.selesti.com/" target="_blank">Site by Selesti</a>	<br/>	  
		 				<a href="http://validator.w3.org/check?uri=http://www.wyzeup.co.uk/" title="XHTML">XHTML</a>, <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://www.wyzeup.co.uk/wyzeup_css/wyzeup.css" title="CSS">CSS</a>, <a href="http://webxact.watchfire.com/" title="508">508</a>
				</div>		  
		</div>';
?>