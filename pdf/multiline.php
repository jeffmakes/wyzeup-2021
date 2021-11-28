<?php
/*	if(empty($_SESSION["user_name"]) ||empty($_SESSION["password"])) {
			header("Location: controlpanel/index.php?action_type=invalid");
	}*/
	global $addstaticcontentpage  ;
	include_once("../includes/config.php");
	require_once("fpdf.php");
	require_once("font/makefont/makefont.php");
	include_once("../classes/clsPdf.php");
	$action_type =	$_REQUEST["action_type"];
	//$num_products = 4;
	$recv_cnt = 0;
	$objPdf = new clsPdf($dbconn);
	if ($_GET['action_type'] == 'view')
	{	
		$arr_values["pdf_id"] = 1;
		$rsPdf 		= $objPdf->getPdf($arr_values);	
		$arr_pdf 	= mysql_fetch_array($rsPdf);
		// Other Details
		$today 		= date("F j Y");
		$curdate 	= explode(" ",$today);
		$month 		= $curdate[0] .' '.$curdate[2];
		//$month		= $arr_pdf["pdf_month"];
		$header1	= $arr_pdf["pdf_header1"];
		//$header2 	= $arr_pdf["pdf_header2"];

		$title[]	= $arr_pdf["pdf_title1"];
		$desc[]		= $arr_pdf["pdf_desc1"];
		$title[] 	= $arr_pdf["pdf_title2"];
		$desc[]		= $arr_pdf["pdf_desc2"];
		$title[] 	= $arr_pdf["pdf_title3"];
		$desc[]		= $arr_pdf["pdf_desc3"];
		$title[]	= $arr_pdf["pdf_title4"];
		$desc[]		= $arr_pdf["pdf_desc4"];
		$title[]	= $arr_pdf["pdf_title5"];
		$desc[]		= $arr_pdf["pdf_desc5"];
		
		$footer1 	= $arr_pdf["pdf_footer1"];
		$footer2 	= $arr_pdf["pdf_footer2"];
		
		$add_info_title[]= $arr_pdf["pdf_addtitle1"];
		if($arr_pdf["pdf_addinfo1"])
		{
			$add_info_desc[] = $arr_pdf["pdf_addinfo1"];
		}
		if($arr_pdf["pdf_addinfo2"])
		{
			$add_info_desc[] = $arr_pdf["pdf_addinfo2"];
		}
		if($arr_pdf["pdf_addinfo3"])
		{
			$add_info_desc[] = $arr_pdf["pdf_addinfo3"];
		}
		if($arr_pdf["pdf_addinfo4"])
		{
			$add_info_desc[] = $arr_pdf["pdf_addinfo4"];
		}
		$cnt_info = count($add_info_desc);
		unset($objPdf);	
	}	
	$today 		= date("F j Y");
	$curdate 	= explode(" ",$today);
	$month 		= $curdate[0] .' '.$curdate[2]; 
class PDF extends FPDF
{
	var $widths;
	var $aligns;
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
		//for($i=0;$i<8;$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		//$h=5*$nb;
		$h = 18;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		//for($i=0;$i<8;$i++)
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			//$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,1,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
		}
		
		function CheckPageBreak($h)
		{
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}
		
		function NbLines($w,$txt)
		{
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
				$c=$s[$i];
				if($c=="\n")
				{
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
							$i++;
					}
					else
						$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}
	
		function Header()
		{
			global $header, $printable;
			$this->SetFont('Arial','',15);
			$this->SetTextColor(53,103,156);
			if($printable != false){
				$this->Text(75, 10, $header["main"]);
				$this->Ln(10);
				$this->SetTextColor(0,150,214);
				$this->SetFontSize(8.5);
				$this->Text(90, 15, $header["sub"]);
				$this->SetDrawColor(53,103,156);
				$this->Line(10, 18, 200, 18);
				$this->Ln(10);
			}
		}
		
		function Footer()
		{
			global $footer, $printable;
			$this->SetDrawColor(53,103,156);
			if($printable != false){
				$this->Line(10, 283, 200, 283);
				$this->SetTextColor(53,103,156);
				$this->SetFontSize(8);
				$this->Text(65, 288, $footer["main"]);
				$this->Ln(10);
				$this->SetFontSize(8);
				$this->Text(45, 292, $footer["sub"]);
			}
		}
		
		function ChapterTitle($label)
		{
				$this->SetLeftMargin(10);
				//$this->image('images/logo.jpg', 10, 22, 24, 12);
				$this->SetFont('Arial','B',14);
				//$this->Text(10, 32, $label);
				$this->Ln();

		}
		function ChapterTitleAddInfo($label)
		{
		    // if($addstaticcontentpage == 1 ){
 					$this->SetLeftMargin(10);
					//$this->image('images/logo.jpg', 10, 22, 24, 12);
					//$this->SetFont('Arial','B',14);
					//$this->Text(35, 32, $label);
					$this->Ln();	

			
		}
		
		function ChapterBody($data, $recv_id)
		{  //echo $recv_id. " -------------------  ".$data."<br>";
			//$num_products;
			global  $recv_cnt;
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',10);						
			$this->MultiCell(0,5,$data);
			$this->Ln();
			$this->SetFont('','I');			
			/*$query = " SELECT `prod_id`, `prod_name`, `prod_content`, `receiver_name`, ".
					 " `prod_image` FROM dab_products, dab_receiver WHERE `receiver_id`=`prod_receiver` ".
					 " AND prod_name !='' AND receiver_name='". $recv_id ."' ";*/
			$query = " SELECT `prod_id`, `prod_name`, `manu_name`,`prod_content`, `receiver_name`, ".
					 " `prod_image` FROM dab_products,dab_manufacturer, dab_receiver WHERE `receiver_id`=`prod_receiver` ".
					 " AND prod_manufacturer=manu_id AND prod_name !='' AND receiver_name='". $recv_id ."' ORDER BY manu_name,prod_name ASC";
			$prod_list = mysql_query($query);
			$rows      = mysql_num_rows($prod_list); 

			$this->Ln();
			$this->SetFont('Arial','B',15);
			$this->Text($this->GetX(),$this->GetY(),$recv_id);
			//$this->Ln();
			$i = 0;
			$page = 1;
			$limit = 20;         // sets the number of records per page
			$numofpages = ceil($rows / $limit);
						
			while($i<$rows) {    //echo $rows.'  -  '.$i.'---'.$page.'<br>' ;
				
				if($page == 1){
						if($rcount == 2) {
							$this->Ln();//$this->Ln();
						} 
						if($rcount == 8) {		#display 8 per page
							$this->Text($this->GetX()+155,$this->GetY()+4,'Continued...');
							$this->AddPage();
							$page++;
							$rcount=0;
						}
				}else{
						if($rcount == 2) {
							$this->Ln();//$this->Ln();
						} 
						if($rcount == 11) {		#display 10 per page
							$this->Text($this->GetX()+155,$this->GetY()+4,'Continued...');
							$this->AddPage();
							$page++;
							$rcount=0;
						}
						
				}
				if($rcount > 5 ){ //add the  last static content to the existing page
					$addstaticcontentpage  = 1;					
				} else {
					$addstaticcontentpage  = 0;
				}
//				echo $page.'---'.$rcount.'<br>' ;
				$rcount++;
				$row 			   = mysql_fetch_array($prod_list);
				$manureceiver_name = $row['manu_name'].'-'.$row['prod_name'];
				$col1 = "";
			  	$this->SetFont('Arial','',8); 				
				if($row["prod_receiver"]==1){
					$imgheight = 15;
				} else {
					$imgheight = 20;
				}
				if($rows == 1){
					$col2 =  $this->Image("../upload/product/".$row['prod_image'],10,$this->GetY()+5,$imgheight,17);			
				} else {					
					if($i == 1 || $i == "" ||   $i == 0 || !$i ){
						$col2 =  $this->Image("../upload/product/".$row['prod_image'],10,$this->GetY()+9,$imgheight,17);			
					} else {
						$col2 =  $this->Image("../upload/product/".$row['prod_image'],10,$this->GetY()+2,$imgheight,17);			
					}
				}
				$col1 .= $this->SetFont('Arial','BU',8);
				
				if($rows == 1 || $rows == 2){
					$col1 .= $this->Text($this->GetX()+21,$this->GetY()+8,$manureceiver_name);	
				} else {				
					if($i == 1 || $i == ""  ||   $i == 0 || !$i ){
						$col1 .= $this->Text($this->GetX()+21,$this->GetY()+13,$manureceiver_name);
					} else { 
						$col1 .= $this->Text($this->GetX()+21,$this->GetY()+5,$manureceiver_name);
					}
				}
				$col1 .= $this->Ln();
				$col1 .= $this->SetFont('Arial','',8);
				/*if($i > ($rows-2)) {
					$oddproduct = 0;
				} else {
					$oddproduct = 1;
				}
				if($rows == 1 || $rows == 2 || $oddproduct){
 					$col1 .= "\n\n\n\n\n\n\n";
				} else {
					$col1 .= "\n\n\n\n\n";
				}*/
				$col1 .= "\n\n\n\n\n\n\n";
				if($i<($rows)) {
					//nothing
				} else {
					$col1 .= "\n\n\n\n";
				}
				
				$col1 .= wordwrap(strip_tags($row['prod_content']),45, "\n\n\n\n");				 
				$col1 = $this->WriteHTML($col1);
				$col1 = str_replace("&nbsp;", " ", $col1);
				$i++;
				if($i<($rows)) { //echo $rows.'---  '.$i.'<br>';
					$row=mysql_fetch_array($prod_list);
					$manureceiver_name = $row['manu_name'].'-'.$row['prod_name'];
					$col3 = "";
					$this->SetFont('Arial','',9);
					if($row["prod_receiver"]==1){
						$imgheight = 15;
					} else {
						$imgheight = 20;
					}
					if($i == 1 || $i == ""){
						$col4 =  $this->Image("../upload/product/".$row['prod_image'],100,$this->GetY()+4,$imgheight,17);			
					} else {
						$col4 = $this->Image("../upload/product/".$row['prod_image'],100,$this->GetY()+2,$imgheight,17);					}
					$col3 .= $this->SetFont('Arial','BU',8);
					if($i == 1 || $i == ""){
						$col3 .= $this->Text($this->GetX()+111,$this->GetY()+8,$manureceiver_name);
					} else{
						$col3 .= $this->Text($this->GetX()+111,$this->GetY()+4,$manureceiver_name);
					}
 					$col3 .= $this->Ln();					
					$col3 .= $this->SetFont('Arial','',8);
					$col3 .= "\n\n\n\n\n\n\n";
					$col3 .= wordwrap(strip_tags($row['prod_content']),45, "\n\n\n\n");
 					$col3 = $this->WriteHTML($col3);
					$col3 = str_replace("&nbsp;", " ", $col3);
				} else {
					$col3 = "";	
					$col4 = "";		
				}
				$this->Row(array($col2,$col1,$col4,$col3));
				$i++; 
			}					
		}		
		// To display Additional Info
		function ChapterBodyAddInfo($file)
		{
			$this->SetMargins(0,0,17);
			$this->SetDrawColor(53,103,156);
			//$this->Line(10, 25, 200, 25);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',11);
			$this->MultiCell(0,5,$file,1,J,R);
			$this->SetTextColor(53,103,156);
			$this->SetFontSize(8);
		}
		
		function PrintChapterAddInfo($title,$file)
		{  
		 	//if($addstaticcontentpage == 1 ){
				//$title="";				
			//}else{
				$this->ChapterTitle($title);
			//}
			$this->ChapterBodyAddInfo($file);
		}
		
		//Better table
		function ImprovedTable($data)
		{
			//Column widths
			$w=array(50,150);
			$this->Ln();
			
			//Data
			$rowcnt = 1;
			foreach($data as $row)
			{
				$this->Cell($w[0],5,$this->Image("images/".$row[0],$this->GetX(),$this->GetY(), 27, 13), 0, 0, 'L', 0);				
				$this->MultiCell($w[1], 5, $row[1], 0, "L");
			}
		}
		
		function PrintChapter($title,$data, $recv_id)
		{ 	//echo $title.' -- '.$data.' -- '.$recv_id.'<br>';
			global $printable;
			$isfooter = 1; 
			if($printable == false) {
				$printable = true;
				$isfooter = 0; 
			}
			$this->AddPage('', 1, $isfooter);
			$this->ChapterTitle($title);
			$this->ChapterBody($data, $recv_id);
		}

		function WriteHTML($html)
		{ //echo $html;
			$html = preg_replace('/</',' <',$html);
			$html = preg_replace('/>/','> ',$html);
			//$html = preg_replace('/[\n\r\t]/',' ',$html);
			$html = preg_replace('/  /',' ',$html);											

			//HTML parser
			$ret_data = "";
			$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
			{				
				if($i%2==0)
				{
					$ret_data .= $e . "\n";
				}
			}
			return $ret_data;
		}
}
define('FPDF_FONTPATH','font/');

function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}

$pdf=new PDF();
	
//To display the graphic image
$printable = false;
$pdf->SetMargins(0,-20,0);
$pdf->AddPage();
$pdf->Image('images/dmb.jpg', $pdf->GetX(),$pdf->GetY(), 210, 318);
$pdf->SetMargins(25,50,10);
$pdf->SetTextColor(0,150,214);
$pdf->SetFont('','',26);
// To update the latest month
//$pdf->Text($pdf->GetX()+45,$pdf->GetY()+148,"Album");
$pdf->Text($pdf->GetX()+80,$pdf->GetY()+150,$month);
$pdf->SetMargins(5,20,3);

// Table with 2 rows and 4 columns
$pdf->SetWidths(array(20,70,20,85));
srand(microtime()*1000000);

$header["main"]	= $header1;
$header["sub"]	= 'Status : '.$month;
$footer["main"]	= $footer1;
$footer["sub"]	= $footer2;

$pdf->SetTitle($title);
$pdf->SetAuthor('Jules Verne');
$query 		= " SELECT receiver_name FROM dab_receiver WHERE `receiver_id` != '' ORDER BY receiver_id";
$rece_list  = mysql_query($query);
// To get the Receiver name and description
$rows = mysql_num_rows($rece_list); 
for($i=0; $i<$rows; $i++) {
	$recv_cnt++;
	$pdf->PrintChapter($title[$i], $desc[$i], mysql_result($rece_list, $i, "receiver_name"));
}
if($addstaticcontentpage == 1){
	$pdf->AddPage();
}
for($m=0; $m<$cnt_info; $m++) {
	$pdf->PrintChapterAddInfo($add_info_title[$m], $add_info_desc[$m]);
}
$pdf->Output();
?> 
