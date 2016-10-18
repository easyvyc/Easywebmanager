<?php

include_once (CLASSDIR.'Element.class.php');

class element_file extends Element {
	
	private $valid_files = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pps', 'pptx', 'ppsx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'csv', 'odt', 'zip', 'mp3', 'm4a', 'ogg', 'wav', 'mp4', 'm4v', 'mov', 'wmv', 'avi', 'mpg', 'ogv', '3gp', '3g2');
	
	public function __construct($name, $element, $form_object) {
		parent::__construct ($name, $element, $form_object);
	}
	
	function getHTML(){
		TPL::setVar('max_file_size', (int)ini_get('upload_max_filesize'));
		TPL::setVar('random', rand(100, 999));
		return parent::getHTML();
	}
	
	function validate($data){

		if($data[$this->get('name') . '_type']=='url' && $data['url_' . $this->get('name')]){
			$file_info = pathinfo($data['url_' . $this->get('name')]);
                        $extension = $file_info['extension'];
			$FILE['tmp_name'] = TEMPDIR . md5(date('YmdHis'));
			$FILE['name'] = md5(date('YmdHis')) . $extension;
			$FILE['error'] = 0;
                        if(!$this->save_file_from_url($data['url_' . $this->get('name')], $FILE['tmp_name'])){
                            $this->set('style', $this->validate_error_css_class);
                            $this->set('show_error', true);
                            $this->set('error_message', cms::$phrases['main']['common']['file_not_found']);
                            return false;
                        }
			$file_info = pathinfo($FILE['name']);
		}else{
			$FILE = $_FILES['file_'.$this->get('name')];
			$file_info = pathinfo($FILE['name']);
		}
		
		if($FILE['error']==1 || $FILE['error']==2 || $FILE['error']==3 || $FILE['error']==6){
			$this->set('style', $this->validate_error_css_class);
			$this->set('show_error', true);
			$this->set('error_message', cms::$phrases['main']['common']['too_big_file']);
			return false;
		}elseif(is_uploaded_file($FILE['tmp_name']) && !in_array(strtolower($file_info['extension']), $this->valid_files)){
			$this->set('style', $this->validate_error_css_class);
			$this->set('show_error', true);
			$this->set('error_message', cms::$phrases['main']['common']['wrong_extension_file']);
			return false;
		}else{
			if(is_uploaded_file($FILE['tmp_name']) || file_exists($FILE['tmp_name'])){
				$value = $this->save_temp($FILE);
			}elseif(strlen($data[$this->get('name')]) > 0){
				$value = $data[$this->get('name')];
			}
		}
		
		$data[$this->get('name')] = $value;
		
		return parent::validate($data);
		
	}
	
	function save_temp($file){
		$hiddens = $this->get('form')->get('hiddens');
		$file_info = pathinfo($file['name']);
		$this->clear_temp(TEMPDIR.$hiddens['module']."-".$this->get('name')."-".$hiddens['id']);
		copy($file['tmp_name'], TEMPDIR.$hiddens['module']."-".$this->get('name')."-".$hiddens['id'].".".$file_info['extension']);
		unlink($file['tmp_name']);
		TPL::setVar('is_img', true);
		return $file['name'];
	}
	
	function clear_temp($file_temp){
		$temp_files = glob($file_temp . "*");
		foreach($temp_files as $file){
			unlink($file);
		}
	}
	
	function save_file_from_url($url, $img){
		$ch = curl_init($url);
		$fp = fopen($img, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		fclose($fp);
		chmod($img, 0777);
                
                if($code == 404){
                    return false;
                }else{
                    return true;
                }
	}	
	
}

?>