<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_import extends controller {
	
    public function __construct() {
        parent::__construct ("import");
        
        $this->products_model = $this->registry->model->products;
        $this->materials_model = $this->registry->model->products_materials;
        $this->fields_values_model = $this->registry->model->products_fields_values;
        $this->images_model = $this->registry->model->products_images;
        
    }


    function test(){
        
        set_time_limit(0);
        ini_set("memory_limit", "1024M");

        load_helpers("url");
        
        include_once(CLASSDIR . "aiva/aiva.class.php");
        $aiva_obj = new aiva();
        
        $list = $aiva_obj->get_items_list_import($_GET['aiva_id']);

        foreach($list as $i => $val){
            $pr_data = $this->products_model->loadByOne(array('aiva_id' => $val['id']));
            if(empty($pr_data)){
                
                $product_data = array();
                $product_data['isNew'] = 1;
                $product_data['parent_id'] = 0;
                $product_data['language'] = 'lv';
                $product_data['language_actions'] = array('ru');
                
                $product_data['category'] = $_GET['easy_id'];
                $product_data['title'] = $val['Name'];
                $product_data['code'] = $val['Code'];
                $product_data['price'] = $val['item_price'];
                $product_data['old_price'] = $val['old_price'];
                $product_data['aiva_id'] = $val['id'];
                $product_data['product_url'] = $val['product_url'];
                $product_data['short_description'] = $val['Features'];
                $product_data['description'] = $val['Description'];
                $product_data['add2cart'] = $val['add2cart'];
                $product_data['akcija'] = $val['akcija'];
                $product_data['active'] = 1;
                
                $materials_arr = array();
                foreach($val['funcions'] as $func){
                    if($func['Name']){
                        $material_data = $this->materials_model->loadByOne(array('title' => $func['Name']));
                        if(empty($material_data)){
                            echo "Prekes ID: {$val['id']}\n";
                            echo "Nera materialso: ";
                            pae($func);
                        }else{
                            $materials_arr[] = $material_data['record_id'];
                        }
                    }
                }
                $product_data['materials'] = $materials_arr;

                $product_fields_data = array();
                $fields = $this->registry->model->products_fields->getCategoryFields($product_data['category']);
                
                foreach($val['char'] as $char){
                    if($char->pazymetas['apras'] && $char->CKey!=218){
                        $yra = false;
                        foreach($fields as $fld){
                            if(trim($char->Name) == trim($fld['title'])){
                                $product_fields_data['column_' . $fld['id']] = $char->pazymetas['apras'];
                                $yra = true;
                                break;
                            }
                        }
                        if(!$yra){
                            echo "Prekes ID: {$val['id']}\n";
                            echo "Nera papildomos savybes: ";
                            pae($char);
                        }
                    }
                }
                
                $pr_id = $this->products_model->saveItem($product_data);
                $product_fields_data['id'] = $pr_id;
                $this->fields_values_model->saveItem($product_fields_data);
                
                $images = array();
                if($val['Image']){
                   $images[] = $val['Image'];
                }
                foreach($val['more_img'] as $img){
                   if(!in_array($img, $images)) $images[] = $img; 
                }
                
                foreach($images as $img){
                    $img_data = array();
                    $img_data['isNew'] = 1;
                    $img_data['parent_id'] = 0;
                    $img_data['language'] = 'lv';
                    $img_data['language_actions'] = array('ru');
                    $img_data['product_id'] = $pr_id;
                    $img_data['active'] = 1;
                    $img_data['title'] = $img;
                    $img_url = "http://gintarobaldai.e-komercija.lt/images/goods/" . $img;
                    $img_info = getimagesize($img_url);
                    $extension = image_type_to_extension($img_info[2]);
                    $file = TEMPDIR . "products_images-image-0." . ($extension ? $extension : 'jpg');
                    $r = $this->save_image_from_url($img_url, $file);
                    $this->images_model->saveItem($img_data);
                }
                
            }else{
//                echo("Exist : ");
//                pae($pr_data);
            }
        }        
        
    }
    
	function save_image_from_url($url, $img){
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