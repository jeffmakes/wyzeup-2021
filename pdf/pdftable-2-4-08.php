<?php

require('fpdf.php');
require_once("../conf/conf.inc.php");

class PDF extends FPDF
{
//Load data
function LoadData($file)
{
    //Read file lines
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Simple table
function BasicTable($header,$data)
{
    //Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

//Better table
function ImprovedTable($header,$data)
{
    //Column widths
    $w=array(40,35,40,45);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}
//Colored table
function EmptyTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(60,45,30,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],0,$header[$i],1,0,'C',1);
    $this->Ln();	
}
function WriteHTML($html)
{
    //HTML parser
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Tag
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

//Colored table
function FancyTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(20,40,20,100);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,($row[2]),'LR',0,'L',$fill);
        $this->Cell($w[3],6,($row[3]),'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
	
  	//  $this->Cell(array_sum($w),0,'','T');
 	
}

//Programme name table
function FancyTable2($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'LR',1);
    $this->Ln();
 /*   //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }*/
    //$this->Cell(array_sum($w),0,'','T');
}


//Programme date table
function FancyTable3($header,$data)
{
          //Colors, line width and bold font
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'LR',1);
    $this->Ln();
    //Color and font restoration
   /* $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }*/
  //  $this->Cell(array_sum($w),0,'','T');
}

//Attendee table
function AttendeeTable($header,$data,$eventname)
{
          //Colors, line width and bold font
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'LR',1);
    $this->Ln();
	
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row) 
    {
        $this->Cell($w[0],6,$row,'LR',0,'L',$fill);      
        $this->Ln();
        $fill=!$fill;
    }
	
	       //Colors, line width and bold font
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($eventname);$i++)
        $this->Cell($w[$i],7,$eventname[$i],1,0,'LR',1);
    $this->Ln();
	$this->Ln();
   // $this->Cell(array_sum($w),0,'','T');
}
function InvoiceHead($header,$data)
{
          //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],2,0,'LR',1);
    $this->Ln();    
}
/*function AddressTable($header,$data)
{
       //Colors, line width and bold font
    //$this->SetFillColor(204,204,204);
    $this->SetTextColor(0,0,0);
   $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(90,90);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
   // $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=0; 
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
      //  $this->Cell($w[2],6,($row[2]),'LR',0,'L',$fill);
        //$this->Cell($w[3],6,($row[3]),'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
	
  	//  $this->Cell(array_sum($w),0,'','T');
 	
}*/
//School table
function SchoolTable($header,$data,$eventname)
{
          //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'LR',1);
    $this->Ln();
	
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row) 
    {
        $this->Cell($w[0],6,$row,'LR',0,'L',$fill);      
        $this->Ln();
        $fill=!$fill;
    }
	
	       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($eventname);$i++)
        $this->Cell($w[$i],7,$eventname[$i],1,0,'LR',1);
    $this->Ln();
	$this->Ln();
   // $this->Cell(array_sum($w),0,'','T');
}
function ForOfficeUseTable($header,$data,$eventname)
{
          //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'LR',1);
    $this->Ln();
	
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row) 
    {
        $this->Cell($w[0],6,$row,'LR',0,'L',$fill);      
        $this->Ln();
        $fill=!$fill;
    }
	
	       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(180);
   for($i=0;$i<count($eventname);$i++)
        $this->Cell($w[$i],7,$eventname[$i],1,0,'LR',1);
    $this->Ln();
	$this->Ln();
   // $this->Cell(array_sum($w),0,'','T');
}

# NEW Format 

function InvoiceClientName($header,$data)
{
          //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(180);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],2,0,'LR',1);
    $this->Ln();    
}
# To display the Address of the Company
function WyzeupAddressTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
	$w=array(150);
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    foreach($data as $row) 
    {
        $this->Cell($w[0],6,$row,'2',0,'R',1);      
        $this->Ln();
    }
}

function WyzeupAddressTable1($header,$data)
{
    //Colors, line width and bold font
    
	$this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(75,75);
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=0; 
    foreach($data as $row)
    {	
		$this->WyzeupAddressTable1('',$row);
		
       // $this->Cell($w[0],7,$row[0],'1',0,'L',$fill);
      //  $this->Cell($w[1],7,$row[1],'1',0,'R',$fill);
      //  $this->Cell($w[2],7,$row[2],'1',0,'L',$fill);
       // $this->Ln();
      //  $fill=!$fill;
    }
}
function AddressTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','');
    //Header
    $w=array(110,40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],2,0,'L',1);
    $this->Ln();
}


function InvoiceDateTable($header,$data)
{
    //Colors, line width and bold font
    
	$this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(75,75);
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=0; 
    foreach($data as $row)
    {
        $this->Cell($w[0],7,$row[0],'1',0,'L',$fill);
        $this->Cell($w[1],7,$row[1],'1',0,'R',$fill);
      //  $this->Cell($w[2],7,$row[2],'1',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
}
function InvoiceTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(230,230,230);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(100,50);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=1;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'1',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'1',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
	
  	//  $this->Cell(array_sum($w),0,'','T');
 	
}

function DateTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','');
    //Header
    $w=array(100,50);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'L',1);
    $this->Ln();
}


#To Display  Empty Table
function EmptyInvoiceTable($header,$data)
{
       //Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(100,50);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',1);
    $this->Ln();
}

function InvoiceFianlTable($header,$data)
{
    //Colors, line width and bold font
    
	$this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    //Header
    $w=array(70,30,50);
    //Color and font restoration
    $this->SetFillColor(255);
    $this->SetTextColor(0);
    $this->SetFont('','','8');
    //Data
    $fill=1; 
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'1',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'1',0,'R',$fill);
        $this->Cell($w[2],6,$row[2],'1',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
}

}

$school_id = $_GET["school_id"];

$pdf=new PDF();

# To Display Date
$today = mktime();
$date = date("d-m-Y", $today);
$invoicedate = date("Y-m-d", $today);


#To daiplay Invoice Number
//$invoice_number = "S".(INVOICE_NUMBER+$school_id);
$select_query = "SELECT * FROM  ".TABLE_INVOICE." WHERE invoice_school_fk_id = ".$school_id." AND invoice_date = '".$invoicedate."'";
$query_result = db_execute_query($select_query);
$data         = mysql_fetch_array($query_result); 

$invoice_number = $data['invoice_number'];;
$invoiceterms = "14 Days";

$vat_amount   = TRANSACTION_AMOUNT * VAT;
$total_amount = TRANSACTION_AMOUNT + $vat_amount;

# New Format of PDF INVOICE
$pdf->SetFont('Arial','',8);
$pdf->SetMargins(10,20,3);
$pdf->AddPage();

$pdf->Image('images/wyze-up.jpg', 10,0, 80, 20);
$pdf->Ln();

$sql_qry = "SELECT *,school_name,DATE_FORMAT(school_startdate,'%d %b %Y') as school_startdate,DATE_FORMAT(school_enddate,'%d %b %Y') as school_enddate FROM  wyzeup_schools WHERE school_id = ".$_GET["school_id"];
$result = mysql_query($sql_qry);
						
$row_wyze = mysql_fetch_array($result);
$client_name    = strtoupper($row_wyze["school_contactname"])." ( ".strtoupper($row_wyze["school_name"])." )";

# To display Client Name in PDF

$pdf->InvoiceClientName(array("Client 	: ".$client_name),"");


# To dispaly the Client Address

$schooldata[]    = $row_wyze["school_address1"];
$schooldata[]    = $row_wyze["school_address2"];
$schooldata[]    = $row_wyze["school_city"];
$schooldata[]    = $row_wyze["school_country"];
$schooldata[]    = $row_wyze["school_zipcode"];
$schooldata[]    = "Tel :".$row_wyze["school_phone"];
$schooldata[]    = "E-Mail : ".$row_wyze["school_email"];

# To Display the Wyze up Address

$data[]    = "Wyze Up";
$data[]    = "Address1";
$data[]    = "Address2";
$data[]    = "Norwich NR3 1AU";
$data[]    = "Tel: 01603 760767";
$data[]    = "Mob: 07957 191757";
$data[]    = "Web: www.wyzeup.co.uk";
$data[]    = "E-Mail: info@wyzeup.co.uk";

//$schoolval 			= $schooldata."#".$data; //."#"."Invoice Terms : ".$invoiceterms;
/*$schoolvaldata[]  = explode("#",$schoolval);
$pdf->WyzeupAddressTable($schooldata,$data);*/
//$pdf->WyzeupAddressTable('',$schoolvaldata);
//$pdf->InvoiceDateTable("",$schoolvaldata);

//$pdf->WyzeupAddressTable('',$data);

$addressval1 = array($row_wyze["school_address1"],'Wyze Up');
$addressval2 = array($row_wyze["school_address2"],'Address1');
$addressval3 = array($row_wyze["school_city"],'Address2');
$addressval4 = array($arrcountries[$row_wyze["school_country"]],'Norwich NR3 1AU');
$addressval5 = array($row_wyze["school_zipcode"],'Tel: 01603 760767');
$addressval6 = array('Tel: '.$row_wyze["school_phone"],'Mob: 07957 191757');
$addressval7 = array('E-Mail: '.$row_wyze["school_email"],'Web: www.wyzeup.co.uk');
$addressval8 = array('','E-Mail: info@wyzeup.co.uk');

$pdf->AddressTable($addressval1,'',$include);
$pdf->AddressTable($addressval2,'',$include);
$pdf->AddressTable($addressval3,'',$include);
$pdf->AddressTable($addressval4,'',$include);
$pdf->AddressTable($addressval5,'',$include);
$pdf->AddressTable($addressval6,'',$include);
$pdf->AddressTable($addressval7,'',$include);
$pdf->AddressTable($addressval8,'',$include);

$pdf->Ln();
$invoicedata 			= "Invoice Number : ".$invoice_number."#"."Date : ".$date; //."#"."Invoice Terms : ".$invoiceterms;
$sessiondata[]  = explode("#",$invoicedata);
$pdf->InvoiceDateTable("",$sessiondata);
$pdf->Ln();
//$pdf->InvoiceHead(array("Additional Instructions : Cheque or BACS payment : Bank Number"),"");

# To Display the Amount in the Table

$description = " 1 year subscription to Wyze-Up.co.uk";
$datadesc 			= $description."#"."£ ".number_format(TRANSACTION_AMOUNT,2);
$sessiondata1[]  = explode("#",$datadesc);
$sessionheader	= array('DESCRIPTION','AMOUNT');			
$pdf->InvoiceTable($sessionheader,$sessiondata1,$include);

$sessionheaderdate	= array(''.$row_wyze["school_startdate"].' to '.$row_wyze["school_enddate"],'');
$pdf->DateTable($sessionheaderdate,'',$include);	

$sessionheader1	= array('','');
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);
$pdf->EmptyInvoiceTable($sessionheader1,'',$include);


$finaldata 			= "Please make payments to Wyze Up"."#"."SUBTOTAL"."#"."£ ".number_format(TRANSACTION_AMOUNT,2);
$finaldatavalue[]  = explode("#",$finaldata);
$pdf->InvoiceFianlTable("",$finaldatavalue);

$finalvat 			= "Thank you for your valued custom"."#"."VAT@17.5%"."#"."£ ".number_format($vat_amount,2);
$finalvatvalue[]  = explode("#",$finalvat);
$pdf->InvoiceFianlTable("",$finalvatvalue);

$finalothers 			= ""."#"."OTHER"."#"."- ";
$finalothersvalue[]  = explode("#",$finalothers);
$pdf->InvoiceFianlTable("",$finalothersvalue);

$finaltotal 			= ""."#"."TOTAL INVOICE"."#"."£ ".number_format($total_amount,2);
$finaltotalvalue[]  = explode("#",$finaltotal);
$pdf->InvoiceFianlTable("",$finaltotalvalue);

$pdf->Output();


?>