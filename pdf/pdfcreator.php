<?php
session_start(); 
	global $addstaticcontentpage  ;

	// For staging
	/*$database='db-testselesti';
	$user='dbu-testselesti';
	$pass='Ssy5MJ';
	$host='localhost';*/
	
	#for Local testing
	
	$database='schofield';
	$user='root';
	$pass='';
	$host='localhost';

	//$conn = mysql_connect('mysql.selesti.com','dbu_selcms','dw4423');
	//$conn = mysql_connect('localhost','root','');
	$conn = mysql_connect($host,$user,$pass);
	mysql_select_db($database);
	require_once("fpdf.php");
	require_once("font/makefont/makefont.php");
	include_once("../classes/clsPdf.php");
 	$attendee_id = $_GET["attendee_id"];
	$event_id    = $_GET["event_id"];
	//$num_products = 4;
	$recv_cnt = 0;
	$objPdf = new clsPdf($conn);
	//if ($_GET['action_type'] == 'view')
	//{	
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
	//}	
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
 			/**********************************************************/
			//getting attendee list
			$query = "SELECT * FROM  tbl_attendee_schedule WHERE attendee_id = ".$_GET["attendee_id"]." AND  event_id = ".$_GET["event_id"];
			 
			$res   =  mysql_query($query);
			while($result = mysql_fetch_array($res)){
				$programmeids[] 					   = $result["programme_id"];				
				$sessionids[$result["programme_id"]][] = $result["timeslot_id"];
				//session details
				$sq = "SELECT *,slot_fromtime,slot_totime,room_name FROM tbl_rooms,tbl_timeslots,tbl_slots 
									 WHERE timeslot_id = ".$result["timeslot_id"]." AND tbl_slots.slot_id = tbl_timeslots.slot_id AND room_id = timeslot_room";
				 				 
				$ssql = mysql_query($sq);
				
				$sres = mysql_fetch_array($ssql);
				$sessionroomname[$result["programme_id"]][] = $sres["room_name"];
				$speaker[$result["programme_id"]][] 		= $sres["timeslot_speaker"];
				$sessionname[$result["programme_id"]][]	    = $sres["timeslot_name"];
				$sessiontime[$result["programme_id"]][]     = $sres["slot_fromtime"]." - ".$sres["slot_totime"];
 			}
			array_unique($programmeids);
			$rows = count($programmeids);
			foreach($programmeids as $pid) {
				$psql			  = "SELECT *,DATE_FORMAT(programme_date,'%W %d %M %Y') as programme_date FROM tbl_programmes WHERE programme_id = ".$pid;
				$pres			  = mysql_query($psql);
				$presult 		  = mysql_fetch_array($pres);
				$programmedates[] = $presult["programme_date"];
				$programmenames[] = $presult["programme_name"];
			}
			//array_unique($programmedates);*/
			/*******************************************************/

			$this->Ln();
			$this->SetFont('Arial','B',15);
			$this->Text($this->GetX(),$this->GetY(),$recv_id);
			//$this->Ln();
			$i = 0;
			$page = 1;
			$limit = 3;         // sets the number of records per page
			$numofpages = ceil($rows / $limit);
						$rcount = 0;
			while($i<count($programmeids)) {    //echo $rows.'  -  '.$i.'---'.$page.'<br>' ;
  				 $datecount = $i;
				 $datecount++;
 				 $count 	= $i;
				 $pdate 	= "Date ".$datecount." : ".$programmedates[$i]; 	
				 $progname  = "Programme Name : ".$programmenames[$i];
				 		
				if($rcount > 5 ){ //add the  last static content to the existing page
					$addstaticcontentpage  = 1;					
				} else {
					$addstaticcontentpage  = 0;
				}				
				$rcount++;
				$col1 = "";$col2 = "";$col3 = "";$col4 = "";
				 //date display
				 $mn = 0;
				 if($i){
						$mn = $count-1;
					}
				if($programmedates[$mn] != $programmedates[$i] || $i==0) {
 					$this->SetFont('Arial','',8); 				  					 
					$col1 .= $this->SetFont('Arial','BU',8);					
					$col1 .= $this->Text($this->GetX()+21,$this->GetY()+8,$pdate);					
					$col1 .= "\n\n\n\n\n\n\n";
					$col1 = $this->WriteHTML($col1);
					$col2 = "";$col3 = "";$col4 = "";
					$this->Row(array($col2,$col1,$col4,$col3));
				 }
				 
				 
				  //Programme name display
				  $this->SetFont('Arial','',8); 				  					 
					$col1 .= $this->SetFont('Arial','BU',8);					
					$col1 .= $this->Text($this->GetX()+21,$this->GetY()+8,$progname);					
					$col1 .= "\n\n\n\n\n\n\n";
					$col1 = $this->WriteHTML($col1);
					$col2 = "";$col3 = "";$col4 = "";
					$this->Row(array($col2,$col1,$col4,$col3));
					
					//sessions header displays
				if($programmeids[$mn] != $programmeids[$i] || $i==0) {
 					$col1 .= $this->SetFont('Arial','BU',8);					
						// time
						$col1 .= $this->Text($this->GetX()+21,$this->GetY()+8,"Time");					
						$col1 .= "\n\n\n\n\n\n\n";
						$col1 = $this->WriteHTML($col1);
						
						
						$col2 .= $this->SetFont('Arial','BU',8);					
						// name
						$col2 .= $this->Text($this->GetX()+71,$this->GetY()+8,"Topic");					
						$col2 .= "\n\n\n\n\n\n\n";
						$col2 = $this->WriteHTML($col2);
						
						$col3 .= $this->SetFont('Arial','BU',8);					
						// room
						$col3 .= $this->Text($this->GetX()+121,$this->GetY()+8,"Room");					
						$col3 .= "\n\n\n\n\n\n\n";
						$col3 = $this->WriteHTML($col3);
						
						$col3 .= $this->SetFont('Arial','BU',8);					
						// speaker
						$col4 .= $this->Text($this->GetX()+171,$this->GetY()+8,"Speaker");					
						$col4 .= "\n\n\n\n\n\n\n";
						$col4 = $this->WriteHTML($col4);
						
				 		$this->Row(array($col1,$col2,$col3,$col4)); 
				 }
				 
				 $k=0;
				 $pid  = $programmeids[$i];
				 echo count($sessionids[$pid])."<br>";
				 for($k=0;k<count($sessionids[$pid]);$k++){
				 		$col1 .= $this->SetFont('Arial','',8);					
						// time
						$col1 .= $this->Text($this->GetX()+21,$this->GetY()+8,$sessiontime[$pid][$k]);					
						$col1 .= "\n\n\n\n\n\n\n";
						$col1 = $this->WriteHTML($col1);
						
						
						$col2 .= $this->SetFont('Arial','',8);					
						// name
						$col2 .= $this->Text($this->GetX()+71,$this->GetY()+8,$sessionname[$pid][$k]);					
						$col2 .= "\n\n\n\n\n\n\n";
						$col2 = $this->WriteHTML($col2);
						
						$col3 .= $this->SetFont('Arial','',8);					
						// room
						$col3 .= $this->Text($this->GetX()+121,$this->GetY()+8,$sessionroomname[$pid][$k]);					
						$col3 .= "\n\n\n\n\n\n\n";
						$col3 = $this->WriteHTML($col3);
						
						$col3 .= $this->SetFont('Arial','',8);					
						// speaker
						$col4 .= $this->Text($this->GetX()+171,$this->GetY()+8,$speaker[$pid][$k]);					
						$col4 .= "\n\n\n\n\n\n\n";
						$col4 = $this->WriteHTML($col4);
						
				 		$this->Row(array($col1,$col2,$col3,$col4)); 
				 }	 
 				 
				$i++;
			} // end of while loop
				 
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
		{ 	echo $title.' -- '.$data.' -- '.$recv_id.'<br>';
			global $printable;
			$isfooter = 1; 
			if($printable == false) {
				$printable = true;
				$isfooter = 0; 
			}
			$this->AddPage('', 1, $isfooter);
			$this->ChapterTitle($title);
			$recv_id  = 1;
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
//image
$magazineid= $_SESSION['magazineid'];
$photourl="http://192.168.1.4/scma/";
$img = $photourl."photos/magazine_logo_".$magazineid.".gif";
$size = getimagesize($img);
//$pdf->Image($img, $pdf->GetX(),$pdf->GetY(), $size[0],$size[1]);
$pdf->SetMargins(25,50,10);
$pdf->SetTextColor(0,150,214);
$pdf->SetFont('','',26);
// To update the latest month
//$pdf->Text($pdf->GetX()+45,$pdf->GetY()+148,"Album");
//$pdf->Text($pdf->GetX()+80,$pdf->GetY()+150,$month);
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

$attendeedetails 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_events_attendee WHERE attendee_id =  ".$attendee_id." AND events_id = ".$event_id));
//display Attendee name
$pdf->PrintChapter($title[0], $desc[0], $attendeedetails["attendee_firstname"]." ".$attendeedetails["attendee_lastname"]);

if($addstaticcontentpage == 1){
	$pdf->AddPage();
}
/*for($m=0; $m<$cnt_info; $m++) {
	$pdf->PrintChapterAddInfo($add_info_title[$m], $add_info_desc[$m]);
}*/
$pdf->Output();
?> 
