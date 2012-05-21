<?php

//define('FPDF_FONTPATH', CLASSDIR."fdpf/font/");
include_once(CLASSDIR."pdfb/pdfb.php");

class pdf {
	
	var $valid_types = array(FRM_TEXT, FRM_TEXTAREA, FRM_IMAGE, FRM_FILE, FRM_HTML, FRM_DATE, FRM_RADIO, FRM_CHECKBOX, FRM_CHECKBOX_GROUP, FRM_SELECT, FRM_HIDDEN);
	
    function pdf() {
    	
    	$this->document = new PDFB();
    	
    	$this->document->SetAuthor("easywebmanager"); 
  		$this->document->SetTitle("easywebmanager");
  		
		$this->document->setSourceFile(DOCUMENTSDIR."tpl.pdf"); 
		$this->tplidx = $this->document->ImportPage(1);
		
		$this->document->AddFont('tahoma', '', 'tahoma.php');		
    
    }
    
    function setData($data){
    	$this->data = $data;
    }

	function setFields($fields){
		$this->fields = $fields;
	}
	
	function setTitle($title){
		$this->title = $title;
	}

	function createItemPage($data){
		
		$this->document->AddPage();
		$this->document->useTemplate($this->tplidx);
		
		foreach($this->fields as $key => $val){
			
			if(in_array($val['type'], $this->valid_types)){
				
				if($val['type'] == FRM_HTML){
					$data[$val['column_name']] = preg_replace("/<br([^>]*?)>/si", "\n", $data[$val['column_name']]);
					$data[$val['column_name']] = preg_replace("/<hr([^>]*?)>/si", "\n", $data[$val['column_name']]);
					$data[$val['column_name']] = strip_tags($data[$val['column_name']]);
				}
				
				$this->document->SetFont('tahoma','',9);
				$this->document->Cell(200,5,iconv('UTF-8', 'windows-1257', $val['title']),'',0,'L');
				
				if(in_array($val['type'], array(FRM_TEXT, FRM_TEXTAREA, FRM_HTML, FRM_DATE, FRM_HIDDEN))){
					$this->document->Ln();
					$this->document->SetFont('tahoma','',8);
					$this->document->MultiCell(200,5,iconv('UTF-8', 'windows-1257', $data[$val['column_name']]),'LTBR','L', 0);
				}
				if($val['type']==FRM_IMAGE){
					if(strlen($data[$val['column_name']]) && file_exists(UPLOADDIR.$data[$val['column_name']])){
						$this->document->Ln();
						$img_arr = getimagesize(UPLOADURL.$data[$val['column_name']]);
						if($img_arr['mime']=='image/jpeg' || $img_arr['mime']=='image/png'){
							$currentY = $this->document->GetY();
							$this->document->Image(UPLOADURL.$data[$val['column_name']], 5, $currentY);
							$this->document->SetY($currentY+$this->px2mm($img_arr[1]));
						}else{
							$this->document->Write(5, $data[$val['column_name']], UPLOADURL.$data[$val['column_name']]);
						}
					}
				}
				if($val['type']==FRM_FILE){
					$this->document->Ln();
					$this->document->Write(5, $data[$val['column_name']], UPLOADURL.$data[$val['column_name']]);
				}
				if($val['type']==FRM_CHECKBOX){
					$this->document->Ln();
					$this->document->MultiCell(200,5,iconv('UTF-8', 'windows-1257', $data[$val['column_name']]),'LTBR','L', 0);
				}
				if($val['type']==FRM_SELECT || $val['type']==FRM_CHECKBOX_GROUP || $val['type']==FRM_RADIO){
					$this->document->Ln();
					$this->document->MultiCell(200,5,iconv('UTF-8', 'windows-1257', $data[$val['column_name']]),'LTBR','L', 0);
				}
				
				
				$this->document->Ln();
			}
			
		}

	}
	
	function createDocument(){
	
		$this->document->SetMargins(5, 20, 5);
		$this->document->SetAutoPageBreak(true, 3);
		$this->document->SetTextColor(0,0,0);
		
		$this->document->AddPage();
		$this->document->useTemplate($this->tplidx);

		$this->document->SetY(70);
		$this->document->SetFont('tahoma','',25);
		$this->document->MultiCell(200,5,iconv('UTF-8', 'windows-1257', $this->title),'','C',0);
				
		
		$n = count($this->data);
		for($i = 0; $i < $n; $i++){
			$this->createItemPage($this->data[$i]);
		}
		$this->document->Output();
			
	}
	
	function getNumberInWord($number){
	
		$number = number_format($number, 2, '.', '');
		$arr = explode(".", $number);
		include_once(INCDIR."numbers.inc.php");
		$Numbers_Words_lt = & new Numbers_Words_lt();
		return ucfirst(trim($Numbers_Words_lt->toWords($arr[0])." Lt ".$arr[1]." ct."));
	
	}

	//conversion pixel -> millimeter in 72 dpi
	function px2mm($px){
	    return $px*25.4/72;
	}

}

?>