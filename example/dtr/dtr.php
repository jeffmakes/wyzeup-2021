<?php 
/* 
DTR - Dynamic Text Replacement
Revised by João Makray <joaomak.net> 
*/

session_start();
ob_start('DTR_init');

function DTR_init($buffer){
	$DTR = new DTR();
	return $DTR->getHeadings($buffer);
}


class DTR
{
  var $dtr_dir = 'dtr';
  var $heading_css = 'example/dtr/headings.css';
  var $letterWrap = 20;
  var $dtr_tags = array('h1', 'h2', 'h3'); 
  
  function DTR(){
  	$this->dtr_style = '';
  	$this->id=0;
  }
  
  function splitTag($text, $tag, $inline='span'){
  	$text=trim($text);
  	if(!$text)return '';
  	$font_file = 'Brody';
	$font_size  = 30;
	echo $text_info = $_SESSION['pcdtr'][$tag]; 
	if(isset($text_info['font-size'])) $font_size = $text_info['font-size'];
	if(isset($text_info['font-family'])) $font_file = $this->dtr_dir.'/'.$text_info['font-family'];
	if(!file_exists($font_file)) $font_file.='.ttf';
	if(isset($text_info['text-transform']) && $text_info['text-transform']=='uppercase') $text=strtoupper($text); 
	if(isset($text_info['text-transform']) && $text_info['text-transform']=='lowercase') $text=strtolower($text); 
	
  	$wrap=wordwrap($text, $this->letterWrap, '<|>');
	$ww=explode('<|>',$wrap);
	
	$out='';
	foreach($ww as $n=>$v){ echo $v;
				
			$out.='<'.$inline.' id="'.$tag.$this->id.'">'.$v.'</'.$inline.'> ';
			//$out.=$v;
			$image=$this->dtr_dir.'/image.php?t='.$tag.'_'.urlencode(html_entity_decode($v));
			$gis=imagettfbbox($font_size,0,$font_file,html_entity_decode($v).' ');
			$w=abs($gis[4]-$gis[6]);
				
			$gis=imagettfbbox($font_size,0,$font_file,'Ájg');
			$h=abs($gis[3]-$gis[5]);
							
			$this->dtr_style.= '#'.$tag.$this->id.'{background-image:url('.$image.');width:'.$w.'px;height:'.$h.'px}';
			$this->id++;
	}
	return $out;
  }
  function replaceHeading($tag, $buffer){

	$ex=explode('<'.$tag.'>',$buffer);	
	$page=array_shift($ex);
	
	if (count($ex)>0) {
		
		foreach($ex as $v){
			$ex2=explode('</'.$tag.'>',$v);
			
			$innerSplit=explode('<',$ex2[0]);
			$inner ='';
			foreach($innerSplit as $icount=>$innerstr){ 
				$tmp=explode('>',$innerstr);
				if(count($tmp)>1 && substr($innerstr,0,1)!='/'){
					$attrs=explode(' ',trim($tmp[0]));
					$innerTag=array_shift($attrs);
					$innerHTML=$this->splitTag($tmp[1], $tag.'-'.$innerTag);
					$inner .= '<'.$tmp[0].'>'.trim($innerHTML).'</'.$innerTag.'>';
					
				}else $inner .= $this->splitTag(array_pop($tmp), $tag);
			}
			
			$page .= '<'.$tag.' class="dtr">'.$inner.'</'.$tag.'>';
			$page .= $ex2[1];
		}
	}
	return $page;
  }
  function readCSS(){ 	
		if (is_readable($this->heading_css)) {
			$style_array = file($this->heading_css);
		
			if (is_array($style_array)) {
				$curr =false;
				$_SESSION['pcdtr']=array();
				foreach ($style_array as $k => $prop) {
					$selector=trim(str_replace('{', '', $prop));
					if (in_array(substr($selector,0,2), $this->dtr_tags)) {
						$curr = str_replace(' ','-',$selector);
						// subtags cascade
						$subtags=explode('-',$curr);
						array_pop($subtags);
						if(count($subtags)>0)$subtag=array_pop($subtags);
						if(isset($subtag)){
							if(isset($_SESSION['pcdtr'][$subtag])) $_SESSION['pcdtr'][$curr] = $_SESSION['pcdtr'][$subtag];
						}
	
						if(!isset($_SESSION['pcdtr'][$curr])) $_SESSION['pcdtr'][$curr]=array();
					}else if($selector=='}'){
						$curr=false;
					} else {
						$dets = explode(':', $prop);
						if ($curr && isset($dets[0]) && isset($dets[1])) {
							$property=trim($dets[0]);
							$value=trim(str_replace(';', '', $dets[1]));
							
							if($property=='font-size')settype($value, "integer");
							if($property=='font-family'){
								$fontList=explode(',',$value);
								$value=array_shift($fontList);
							}
							$_SESSION['pcdtr'][$curr][$property] = trim($value);
						}
					}
				}
			}
		} 
	
  }
  function getHeadings($buffer) { 
	if (!is_array($_SESSION['pcdtr']) || $_GET['debug']) {
		$this->readCSS();
	}
	$html=$buffer;
	foreach($this->dtr_tags as $tag){
		if(array_key_exists($tag, $_SESSION['pcdtr']))$html = $this->replaceHeading($tag, $html);
	}	
	// insert style tag right before the </head>
	if($buffer!=$html)$html = str_replace('</head>','<style type="text/css">'.$this->dtr_style."</style>\n</head>", $html);
	
	return $html;
  }

}//end class

?>

