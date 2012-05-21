<?php

include_once(CLASSDIR."pdfb/pdfb.php");
class proforma {

	var $currency = "Lt";
	var $currency_price = 1;
	
	// true jei saskaita faktura, false jie isankstine
	var $is_invoice = false;

    function proforma() {
    	
    	$this->pdf = new PDFB();
    	
    	$this->pdf->SetAuthor(""); 
  		$this->pdf->SetTitle("");
  		
		$this->pdf->setSourceFile(DOCUMENTSDIR."tpl_invoice.pdf"); 
		$this->tplidx = $this->pdf->ImportPage(1);  		
    
    }
    
    function setData($data){
		$this->data = $data;
    }
    
	function addPage(){
		
		$this->pdf->AddPage();
		$this->pdf->useTemplate($this->tplidx);
		
		$this->pdf->SetMargins(10, 13, 10);

		if($this->data['rekvizitai']['logo'] && file_exists(UPLOADDIR.$this->data['rekvizitai']['logo'])){
			$img_arr = getimagesize(UPLOADURL.$this->data['rekvizitai']['logo']);
			if($img_arr['mime']=='image/jpeg'){
				$currentY = $this->pdf->GetY();
				$this->pdf->Image(UPLOADURL.$this->data['rekvizitai']['logo'], 10, $currentY, round($this->px2mm($img_arr[0])), round($this->px2mm($img_arr[1])));
				//$this->pdf->SetY($currentY+$this->px2mm($img_arr[1]));
			}
		}		
		
		$this->pdf->SetFont('tahoma','',8);
		$this->pdf->setY(11);
		$this->pdf->MultiCell(185,3,$this->text( "El. paštas: ".$this->data['rekvizitai']['email']),'','R',0);
		$this->pdf->MultiCell(185,3,$this->text( "Tel.: ".$this->data['rekvizitai']['phone']),'','R',0);
		$this->pdf->MultiCell(185,3,$this->text( $this->data['rekvizitai']['website']),'','R',0);
		
	}    

	function create($savefile = '', $dest = "D"){
		
		$this->pdf->AddFont('tahoma', '', 'trebuc.php');
		$this->pdf->AddFont('tahomab', '', 'trebucb.php');
		
		$this->addPage();		
		
		$this->pdf->SetAutoPageBreak(true, 3);
		
		$this->pdf->SetTextColor(0,0,0);
		
		$this->pdf->SetFont('tahomab','',14);
		
		$this->pdf->Cell(0,30,'',0,1);
		
		$sask_nr_title = ($this->is_invoice==true?"SĄSKAITA-FAKTŪRA NR.":"IŠANKSTINĖ SĄSKAITA NR.");
		$this->pdf->Cell(200,10,$this->text($sask_nr_title.": {$this->data['order']['invoice_number']}"),0,1,'C');
		
		$this->pdf->SetFont('tahoma','',10);
		$this->pdf->Cell(200,5,$this->text('DATA: '.($this->data['order']['order_date'])),0,1,'C');
		
		$this->pdf->SetFont('tahoma','',8);
		$this->pdf->Cell(0,8,'',0,1);
		$y_before_seller_data = $this->pdf->GetY();
		$seller_data = "PARDAVĖJO REKVIZITAI:\n" .
				"{$this->data['rekvizitai']['company']}\n" .
				"Įmonės adresas: {$this->data['rekvizitai']['company_address']}\n" .
				//($this->data['rekvizitai']['buv_adresas']?"Būveinės adresas: {$this->data['rekvizitai']['buv_adresas']}\n":"") .
				"Įmonės kodas: {$this->data['rekvizitai']['company_code']}\n" .
				($this->data['rekvizitai']['company_pvm']?"PVM mokėtojo kodas: {$this->data['rekvizitai']['company_pvm']}\n":"") .
				"Bankas: {$this->data['rekvizitai']['company_bank']}\n" .
				"A/S: {$this->data['rekvizitai']['company_saskaita']}";
		$this->pdf->MultiCell(90,4,$this->text($seller_data),0,'L');
		
		
		$buyer_data = "PIRKĖJO REKVIZITAI:\n" .
				"{$this->data['order']['company']}\n" .
				($this->data['order']['company_address']?"Įmonės adresas: {$this->data['order']['company_address']}\n":"") .
				//($this->data['other_address']?"Būveinės adresas: {$this->data['other_address']}\n":"") .
				"Įmonės kodas: {$this->data['order']['company_code']}\n" .
				($this->data['order']['pvm_code']?"PVM mokėtojo kodas: {$this->data['order']['pvm_code']}\n":"").
				//($this->data['bank']?"Sąskaita ir bankas: {$this->data['bank']}\n":"").
				($this->data['order']['phone']?"Telefonas: {$this->data['order']['phone']}":"");
				
		$this->pdf->setXY(110, $y_before_seller_data);
		$this->pdf->MultiCell(90,4,$this->text($buyer_data),0,'L');
		
		
		$this->pdf->SetFont('tahomab','',8);
		$this->pdf->setXY(10, 110);
		$this->pdf->Cell(132,8,$this->text('Prekės ar paslaugos pavadinimas'),'LTB',0,'L');
		//$this->pdf->Cell(12,8,$this->text('Mat.vnt.'),'TB',0,'C');
		$this->pdf->Cell(12,8,$this->text('Kiekis'),'TB',0,'C');
		$this->pdf->Cell(25,8,$this->text('Vnt. kaina'),'TB',0,'C');
		$this->pdf->Cell(20,8,$this->text('Suma'),'RTB',0,'C');
		
		$this->pdf->Ln();
		
		$this->pdf->SetFont('tahoma','',8);
		$Y_AXIS_VALUE = 0;
		foreach($this->data['ordered_items'] as $key=>$val){
			//$this->pdf->setY($Y_AXIS_VALUE);
			$this->pdf->Cell(132,7,$this->text(html_entity_decode($val['title'], ENT_QUOTES)),'B','L');
			//$this->pdf->Cell(12,7,$val['vienetai'],'B',0,'C');
			$this->pdf->Cell(12,7,($this->data['credit']==1?"-":"").$val['kiekis'],'B',0,'C');
			$this->pdf->Cell(25,7,number_format($val['price'], 4, '.', ''),'B',0,'C');
			$this->pdf->Cell(20,7,($this->data['credit']==1?"-":"").$this->price(number_format($val['price']*$val['kiekis'], 2, '.', '')),'B',0,'C');
			$this->pdf->Ln();
			$Y_AXIS_VALUE += 7;
		}
		
		$this->pdf->SetFont('tahomab','',8);
		// PVM
		$this->pdf->Cell(169,5,$this->text("SUMA:"),0,0,'R');
		$this->pdf->Cell(21,5,($this->data['credit']==1?"-":"").$this->price($this->data['order']['order_sum_no_pvm']),0,0,'C');
		$this->pdf->Ln();
		$this->pdf->Cell(169,5,$this->text("PVM {$this->data['order']['pvm_dydis']}%:"),0,0,'R');
		$this->pdf->Cell(21,5,($this->data['credit']==1?"-":"").$this->price($this->data['order']['order_sum_pvm']),0,0,'C');
		$this->pdf->Ln();
		$this->pdf->Cell(169,5,$this->text("SUMA APMOKĖJIMUI:"),0,0,'R');
		$this->pdf->Cell(21,5,$this->price($this->data['order']['order_sum']),0,0,'C');
		$this->pdf->Ln();
		$this->pdf->Ln();
		
		$this->pdf->Cell(180,6,$this->text("Suma žodžiais: ".$this->getNumberInWord($this->data['order']['order_sum'])),0,0,'L');
		$this->pdf->Ln();
		//$last_payment_day = $this->getLastPaymentDay($this->data['sf_date'], $distributor_obj->data['sf_apmokejimo_terminas']);
		//$this->pdf->Cell(180,6,$this->text("Apmokėti iki: ".$this->date($this->data['order']['last_payment_day'])),0,0,'L');
		
		$this->pdf->setXY(10, 278);
		$this->pdf->SetFont('tahoma','',7);
		
		$this->pdf->MultiCell(63,3,$this->text("{$this->data['rekvizitai']['company']}\nĮm. k. {$this->data['rekvizitai']['company_code']}\n".($this->data['rekvizitai']['company_pvm']?"PVM m. k. {$this->data['rekvizitai']['company_pvm']}":"")),0,'L');

		$this->pdf->setXY(73, 278);
		$this->pdf->MultiCell(63,3,$this->text("Tel. {$this->data['rekvizitai']['phone']}\nEl. paštas {$this->data['rekvizitai']['email']}"),0,'C');	

		$this->pdf->setXY(136, 278);
		$this->pdf->MultiCell(63,3,$this->text("{$this->data['rekvizitai']['company_bank']}\nA.s. {$this->data['rekvizitai']['company_saskaita']}"),0,'R');
		
		if($savefile==''){
			$savefile = $this->data['order']['invoice_number'].".pdf";
		}
		
		return $this->pdf->Output($savefile, $dest);
			
	}
		
	function getLastPaymentDay($date, $days){
		
		$arr = explode("-", $date);
		$mktime = mktime(0,0,0,$arr[1],$arr[2]+$days,$arr[0]);
		return date("Y-m-d", $mktime);
		
	}
	
	function text($text){
		$text = htmlspecialchars_decode($text);
		return iconv('UTF-8', 'windows-1257', $text);
	}
	
	function price($price){
		return number_format($price*$this->currency_price, 2, '.', '')." ".$this->currency;
	}
	
	function date($date, $f="-"){
		global $cms_phrases;
		$arr = explode($f, $date);
		return sprintf($cms_phrases['date_format'], $arr[0], $cms_phrases['month.'.(int)$arr[1]], $arr[2]);
	}	

	function getNumberInWord($number){
	
		$number = number_format($number, 2, '.', '');
		$arr = explode(".", $number);
		include_once(CLASSDIR."numbers.class.php");
		$Numbers_Words_lt = & new Numbers_Words_lt();
		return ucfirst(trim($Numbers_Words_lt->toWords($arr[0])." Lt ".$arr[1]." ct."));
	
	}
	
	//conversion pixel -> millimeter in 72 dpi
	function px2mm($px){
	    return $px*25.4/72;
	}	

}
?>