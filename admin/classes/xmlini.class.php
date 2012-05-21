<?php
/**
 *	xml file to ini interface
 * @package core
 */

include_once(dirname(__FILE__).'/xmlsax.class.php' );

/**
 * provides ini functions for xml document
 *
 * @version $Id: fuxmlini.class.php,v 1.2 2003/07/22 07:21:14 dzhibas Exp $
 */

/**
 * skirtumas tarp uzkesuoto ir nekesuoto xmlini
 * nekesuotas:  0.0108679533005 (generavimosi laikas)
 * kesuotas  :	0.00194096565247
 */

class xmlIni
{
	/// dom tree
	var $xmlTree;

	/// source string
	var $xmlDoc = '';

    var $filename =  "";

    // configas masyve
    var $xml_array = array();
	// temp vars
	var $xml_indexes = array();

	// ke�as
	var $cache = false;
	var $cache_dir = "";
	var $isCached = false;

	/**
    * Constructs a new fuIni object.
    */
    function xmlIni( $inifilename="" )
    {
        if ($inifilename != "" )
			$this->loadData( $inifilename );
		//else
		//	$this->xmlTree = "";
    }

    function loadData( $inifilename="" )
    {
       //my comments
        if ( !empty($inifilename) )
        {
            if ( !file_exists($inifilename) )
            {
                $this->error( "This file ($inifilename) does not exist!");
                return;
            }

			if ($this->cache == false)
				$this->parse($inifilename);
			else {
				$this->loadCache($inifilename);
			}
        }
    }

	function loadCache($file)
	{
		$path = $this->cache_dir .'xmlini/'.md5( basename($file) ).".cache";
		$path_crc = $this->cache_dir .'xmlini/'.md5( basename($file) ).".crc";

		if ( !file_exists($path) )
			$this->parse($file);
		else {
			$crc = @implode('',@file($path_crc));
			if ($crc != $this->md5_file( $file ))
				$this->parse($file);
			else
				$this->_getCache( $path );
		}
	}

	function _getCache($file)
	{
		$fp = fopen( $file, "r" );
        $content = fread($fp, filesize($file));
        fclose( $fp );

		$this->xml_array = unserialize($content);
		$this->isCached = true;
	}

	function _isCached()
	{
		return $this->isCached;
	}

    /**
    * Parses the ini file.
    */
    function parse( $inifilename )
    {
		$this->filename = $inifilename;

        $fp = fopen( $inifilename, "r" );

        $this->xmlDoc = fread($fp, filesize($inifilename));
        fclose( $fp );

        if (function_exists('xml_parser_create'))
        {
        	$parser =& new xmlSax();
        	$this->xmlTree =& $parser->parse( $this->xmlDoc );
        }
        else
        {

        	$this->error("Nera XML parserio");
        }
	}

   /**
    * Prints the error message.
    */
    function error($errmsg)
    {
		echo 'fuXmlIni: ' . $errmsg;
        return;
    }


	function &parseConf( $inifilename )
	{
		$this->loadData( $inifilename );

		if ($this->cache == true && !$this->_isCached())
		{

			$this->parseSimpleData(&$this->xmlTree,'');
			$this->preConfigure(&$this->xml_array);

			$path = $this->cache_dir .'xmlini/'.md5( basename($inifilename) ).".cache";
			$path_crc = $this->cache_dir .'xmlini/'.md5( basename($inifilename) ).".crc";
			$dir = $this->cache_dir.'xmlini/';

			@mkdir($dir, 0775);

			if ($fp = @fopen($path, 'w')) {
				fwrite($fp, serialize($this->xml_array));
				fclose($fp);
			}

			if ($fd = @fopen($path_crc, 'w')) {
				fwrite($fd, $this->md5_file( $inifilename ) );
				fclose($fd);
			}

		}

		return true;
	}

	function preConfigure(&$mas)
	{
		foreach ($mas as $key => $content)
		{
			if (!is_array($content))
			{
				$is = preg_match_all("/{([^ \t\r\n}]+)}/",$content,$m);
				if ($is) {
					foreach ($m[0] as $value)
					{
						$confVal = str_replace(array('{','}'), array('',''),$value);
						if (isset($this->xml_array[$confVal]))
						{
							$mas[$key] = str_replace($value,$this->xml_array[$confVal],$mas[$key]);
						}
					}
				}
			} else {
				$this->preConfigure(&$content);
			}
		}
	}

	function parseSimpleData(&$node, $father)
	{
		$full_path = $father != '' && $father != 'configuration' ? $father.'.'.$node->name : $node->name;
		$gylis = sizeof(explode(".",$full_path));


		if (isset($node->attributes['id']))
		{
			if (!empty($this->xml_indexes))
			{
				$xtmp = $this->xml_indexes[sizeof($this->xml_indexes)-1];
				$tmp['father']	= $xtmp['father'].'!'.$xtmp['idx'].'!'.$node->name;
				unset($xtmp);
			} else {
				$tmp['father']	= $father != '' && $father != 'configuration' ? $father : $node->name;
			}

			$tmp['idx']		= $node->attributes['id'];
			$tmp['depth']	= $gylis;

			array_push($this->xml_indexes,$tmp);
		}

		$howmany = sizeof($node->children);
		if ($howmany > 0)
		{
			for ($x = 0; $x < $howmany; $x++)
			{
				$this->parseSimpleData(&$node->children[$x],$full_path);
			}
		}
		else
		{
			if (!empty($this->xml_indexes))
			{
				$tmp = $this->xml_indexes[sizeof($this->xml_indexes)-1];

				$expr = explode('!', $tmp['father']);

				if (sizeof($expr) > 1)
				{

					$n_father = $expr[0];
					unset($expr[0]);
					$branch = $expr[sizeof($expr)];
					unset($expr[sizeof($expr)]);

					foreach ($expr as $value)
						$this->xml_array[$n_father][$value][$branch][$tmp['idx']] =
							!isset($node->attributes['value']) ? $node->content : $node->attributes['value'];

				} else
					$this->xml_array[$tmp['father']][$tmp['idx']][$node->name] =
						!isset($node->attributes['value']) ? $node->content : $node->attributes['value'];

			} else {
				$this->xml_array[$full_path] = !isset($node->attributes['value']) ? $node->content : $node->attributes['value'];
			}
		}

		if (!empty($this->xml_indexes))
		{
			$tmp = $this->xml_indexes[sizeof($this->xml_indexes)-1];
			if ($tmp['depth'] >= $gylis)
			{
				$shit = array_pop($this->xml_indexes);
			}
		}

		return true;

	}

/******************************************************************************/
  function md5_file($file) {
    if(!file_exists($file)) {
        return false;
    }
    else {
        $filecontent = implode("", file($file));
        return md5($filecontent);
    }
	}


  function objToXml($obj, $level=1){
	
	if($level==1)
		$xml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	
	if(is_object($obj)){
		$attr = "";
		foreach($obj->attributes as $key=>$val){
			$attr .= "$key=\"$val\" ";
		}
		$xml .= /*str_repeat("\t",$level).*/"<{$obj->name} $attr>";
		if(strlen($obj->content)>0){
        	if (htmlspecialchars($obj->content)!=$obj->content){
          		$xml .= /*str_repeat("\t",$level+1).*/"<![CDATA[{$obj->content}]]>";
          	}else{
          		$xml .= /*str_repeat("\t",$level+1).*/"{$obj->content}";
          	}			
		}
		if(is_array($obj->children)){
			$n = count($obj->children);
			for($i=0; $i<$n; $i++){
				$xml .= $this->objToXml($obj->children[$i], $level+1);
			}
		}
		$xml .= /*str_repeat("\t",$level).*/"</{$obj->name}>";
	}
	
    return $xml;
  }
  
  function arrayToXml($array, $level=1) {

    $xml = '';
    if($level == 1)
	    $xml .= '<?xml version="1.0"?>'.
  	          "\n".
              "<configuration>\n";

    foreach ($array as $key=>$value)
    {
    	$key = strtolower($key);
      if (is_array($value))
      {
        $xml .= str_repeat("\t",$level)."<$key>\n";
        $multi_tags = false;
        foreach($value as $key2=>$value2)
        {
        	if (is_array($value2))
          {
          	$xml .= str_repeat("\t",$level+1)."<$key2>\n";
            $level1 = $level;
            $xml .= $this->arrayToXml($value2, $level+1);
            $level = $level1;
            $xml .= str_repeat("\t",$level)."</$key2>\n";
            $multi_tags = true;
          }
          else
          {
          	/*if (trim($value2)!='')
            {*/
            	if (htmlspecialchars($value2)!=$value2)
              {
              	$xml .= str_repeat("\t",$level).
                				            "<$key2><![CDATA[$value2]]>".
                                    "</$key2>\n";
              }
              else
              {
                $value2 = str_replace("\n", "", $value2);
                $value2 = str_replace("\t", "", $value2);
                $xml .= str_repeat("\t",$level+1).
                                    "<$key2>$value2</$key2>\n";
              }
            /*}*/
            $multi_tags = true;
          }
        }
        $xml .= str_repeat("\t",$level)."</$key>\n";
        if (!$multi_tags and count($value)>0)
        {
        	$xml .= str_repeat("\t",$level)."<$key>\n";
          $level1 = $level;
          $xml .= arrayToXml($value, $level+1);
          $level = $level1;
          $xml .= str_repeat("\t",$level)."</$key>\n";
        }
      }
      else
      {
      	if (trim($value)!='')
        {
        	if (htmlspecialchars($value)!=$value)
          {
          	$xml .= str_repeat("\t",$level)."<$key>".
            			            "<![CDATA[$value]]></$key>\n";
          }
          else
          {
          	$xml .= str_repeat("\t",$level).
            		               "<$key>$value</$key>\n";
          }
        }
      }
    }

    if($level == 1)
	    $xml .= "</configuration>\n";
    return $xml;
	}

}
?>