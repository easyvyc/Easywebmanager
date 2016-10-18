<?php

/**************************************************/
/*
Released by AwesomePHP.com, under the GPL License, a
copy of it should be attached to the zip file, or
you can view it on http://AwesomePHP.com/gpl.txt
*/
/**************************************************/

/*
Function: This class can:
-----------------------------
	1)
	Make HTML Forms for Paypal payments, including
	Buy now, Donations, Subscriptions, Shopping carts
	and Gift certificates. Please look at examples folder
	for examples.
	2)
	Process Paypal payments and return true/false from
	paypal so you can do all processing. All backend are
	not of your worries
	
Paramaters in Examples Are:
---------------------------	
	You can view entire paramters,
	what needs to be passed, how and when
	at:
	http://www.paypal.com/IntegrationCenter/ic_std-variable-reference.html
	(copy of this page is included as PaypalVariables.html)
*/

class paypal {
	
	private $VARS;
	private $button;
	private $logFile = "files/documents/paypal.txt";
	private $isTest=false;
	
	public $submit = true;
	
	/* Print Form as Link */
	function getLink()
	{
		$url = $this->getPaypal();
		$link = 'https://'.$url.'/cgi-bin/webscr?';
		foreach($this->VARS as $item => $sub){
			$link .= $sub[0].'='.$sub[1].'&';
		}
		return $link;
	}
	
	/* Print Form */
	function showForm()
	{
		$url = $this->getPaypal();
		$FORM  = '<form name="paypal" action="https://'.$url.'/cgi-bin/webscr" method="post" style="display:inline;">'."\n";
		
		foreach($this->VARS as $item => $sub){
			$FORM .= '<input type="hidden" name="'.$sub[0].'" value="'.$sub[1].'">'."\n";
		}
				
		$FORM .= $this->button;    
		$FORM .= '</form>';
		if($this->submit) $FORM .= '<script type="text/javascript"> document.forms["paypal"].submit(); </script>';
		return $FORM;
	}
	
	/* Add variable to form */
	function addVar($varName,$value)
	{
		$this->VARS[${varName}][0] = $varName;
		$this->VARS[${varName}][1] = $value;
	}
	
	/* Add button Image */
	function addButton($type,$image = NULL)
	{
		switch($type)
		{
			/* Buy now */
			case 1:
				$this->button = '<input type="image" height="21" style="width:86;border:0px;"';
				$this->button .= 'src="https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif" border="0" name="submit" ';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
				break;
			/* Add to cart */	
			case 2:
				$this->button = '<input type="image" height="26" style="width:120;border:0px;"';
				$this->button .= 'src="https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit"';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
				break;
			/* Donate */	
			case 3:
				$this->button = '<input type="image" height="47" style="width:122;border:0px;"';
				$this->button .= 'src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit"';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
				break;
			/* Gift Certificate */
			case 4:	
				$this->button = '<input type="image" height="47" style="width:179;border:0px;"';
				$this->button .= 'src="https://www.paypal.com/en_US/i/btn/btn_giftCC_LG.gif" border="0" name="submit"';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
				break;
			/* Subscribe */
			case 5:	
				$this->button = '<input type="image" height="47" style="width:122;border:0px;"';
				$this->button .= 'src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit"';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
				break;
			/* Custom Button */
			default:
				$this->button = '<input type="image" src="'.$image.'" border="0" name="submit"';
				$this->button .= 'alt="PayPal - The safer, easier way to pay online!">';
		}
		$this->button .= "\n";
	}
	
	/* Set log file for invalid requests */
	function setLogFile($logFile)
	{
		$this->logFile = $logFile;
	}
	
	/* Helper function to actually write to logfile */
	private function doLog()
	{
		ob_start();
		echo '<pre>'; print_r($_POST); print_r($_SERVER); echo '</pre>';
		$logInfo = ob_get_contents();
		ob_end_clean();
		
		$file = fopen($this->logFile,'a');
		fwrite($file,$logInfo);
		fclose($file);
	}
	
	/* Check payment */
	function checkPayment()
	{
		/* read the post from PayPal system and add 'cmd' */
		$req = 'cmd=_notify-validate';
		
		/* Get post values and store them in req */
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		
		$url = $this->getPaypal();

		/* post back to PayPal system to validate */
//		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
//		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
//		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

		$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Host: www.sandbox.paypal.com\r\n";  // www.paypal.com for a live site
		$header .= "Content-Length: " . strlen($req) . "\r\n";
		$header .= "Connection: close\r\n\r\n";		
		
		$fp = fsockopen ('ssl://'.$url, 443, $errno, $errstr, 30);

		/*
		//If ssl access gives you problem. try regular port:
		$fp = fsockopen ($url, 80, $errno, $errstr, 30);
		*/
		if (!$fp) {
			/* HTTP ERROR */
			return false;
		} else {
			
			fputs ($fp, $header . $req);
			while (!feof($fp)) {

				$res = fgets ($fp, 1024);
				
				if (strcmp ($res, "VERIFIED") !== false) {
					/*
					check the payment_status is Completed
					check that txn_id has not been previously processed
					check that receiver_email is your Primary PayPal email
					check that payment_amount/payment_currency are correct
					process payment
					*/		
					
					return true;
				} elseif (strcmp ($res, "INVALID") !== false) {
					/*
					log for manual investigation
					*/
					if($this->logFile != NULL){
						$_POST['_RESULT_'] = $res;
						$this->doLog($_POST);
					}
					return false;
				}
			}
			fclose ($fp);
		}
		return false;
	}
	
	/* Set Test */
	function useSandBox($value)
	{
		$this->isTest=$value;
	}
	
	/* Private function to get paypal url */
	private function getPaypal()
	{
		if($this->isTest == true){
			return 'www.sandbox.paypal.com';
		} else {
			return 'www.paypal.com';
		}
	}
}
?>
