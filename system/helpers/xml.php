<?php
// {{{ toString()
/**
* This method converts a file to a string. It returns an Error object if it is unable to open the file.
*
* @param    fileName String. The name of the file to convert.
*
* @return    String
* @author  simgar
*/

class XML_Array {

function & toString( $fileName )
{
    if ($content_array = file($fileName))
    {
        return implode("", $content_array);
    }
    else
    {
        // Error
        return false;
    }
}
// }}}

function array_listToXmlString($list, $name){
	$n = count($list);
	for($i=0; $i<$n; $i++){
		$xml .= "<$name>\n" . self::arrayToXmlString($list[$i]) . "</$name>\n";
	}
	return "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<root>\n" . $xml . "</root>";
}

function & arrayToXmlString($array, $level=1){

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
            $xml .= XML_Array::arrayToXmlString($value2, $level+1);
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
          $xml .= XML_Array::arrayToXmlString($value, $level+1);
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

    return $xml;
	
}

// {{{ xmlFileToArray()
/**
* This static method converts an xml file to an associative array
* duplicating the xml file structure.
*
* @param    $fileName. String. The name of the xml file to convert.
*             This method returns an Error object if this file does not
*             exist or is invalid.
* @param    $includeTopTag. booleal. Whether or not the topmost xml tag
*             should be included in the array. The default value for this is false.
* @param    $lowerCaseTags. boolean. Whether or not tags should be
*            set to lower case. Default value for this parameter is true.
* @access    public static
* @return    Associative Array
* @author    simgar
*/
function & xmlStringToArray($string, $includeTopTag = false, $lowerCaseTags = true)
{
    // Definition file not found
    $p = xml_parser_create();
    xml_parse_into_struct($p,$string,$vals,$index);
    xml_parser_free($p);
    $xml = array();
    $levels = array();
    $multipleData = array();
    $prevTag = "";
    $currTag = "";
    $topTag = false;
    
    foreach ($vals as $val)
    {
        // Open tag
        if ($val["type"] == "open")
        {
            if (!XML_Array::_xmlFileToArrayOpen($topTag, $includeTopTag, $val, $lowerCaseTags,
                                           $levels, $prevTag, $multipleData, $xml))
            {
                continue;
            }
        }
        // Close tag
        else if ($val["type"] == "close")
        {
            if (!XML_Array::_xmlFileToArrayClose($topTag, $includeTopTag, $val, $lowerCaseTags,
                                            $levels, $prevTag, $multipleData, $xml))
            {
                continue;
            }
        }
        // Data tag
        else if ($val["type"] == "complete" /*&& isset($val["value"])*/)
        {
            if(!isset($val["value"])) $val["value"]='';
            $loc =& $xml;
            foreach ($levels as $level)
            {
                $temp =& $loc[str_replace(":arr#", "", $level)];
                $loc =& $temp;
            }
            $tag = $val["tag"];
            if ($lowerCaseTags)
            {
                $tag = strtolower($val["tag"]);
            }
            $loc[$tag] = str_replace("\\n", "\n", $val["value"]);
        }
        // Tag without data
        else if ($val["type"] == "complete")
        {
            XML_Array::_xmlFileToArrayOpen($topTag, $includeTopTag, $val, $lowerCaseTags,
                                      $levels, $prevTag, $multipleData, $xml);
            XML_Array::_xmlFileToArrayClose($topTag, $includeTopTag, $val, $lowerCaseTags,
                                      $levels, $prevTag, $multipleData, $xml);
        }
    }
    return $xml;
}
// }}}



// {{{ xmlFileToArray()
/**
* This static method converts an xml file to an associative array
* duplicating the xml file structure.
*
* @param    $fileName. String. The name of the xml file to convert.
*             This method returns an Error object if this file does not
*             exist or is invalid.
* @param    $includeTopTag. booleal. Whether or not the topmost xml tag
*             should be included in the array. The default value for this is false.
* @param    $lowerCaseTags. boolean. Whether or not tags should be
*            set to lower case. Default value for this parameter is true.
* @access    public static
* @return    Associative Array
* @author    simgar
*/
function & xmlFileToArray($fileName, $includeTopTag = false, $lowerCaseTags = true)
{
    // Definition file not found
    if (!file_exists($fileName))
    {
        echo "No config file ".$fileName;
        exit();
        //return Error::logError("XML_Array::xmlFileToArray: Failed - File '" . $fileName .
        //                       "' does not exist", __FILE__, __LINE__, SRA_ERROR_PROBLEM);
    }
    
    return XML_Array::xmlStringToArray(XML_Array::toString($fileName), $includeTopTag = false, $lowerCaseTags = true);
    
}
// }}}

// {{{ _xmlFileToArrayOpen()
/**
* Private support function for XML_Array::xmlFileToArray. Handles an xml OPEN tag.
*
* @param    $topTag. String. xmlFileToArray topTag variable
* @param    $includeTopTag. boolean. xmlFileToArray includeTopTag variable
* @param    $val. String[]. xmlFileToArray val variable
* @param    $currTag. String. xmlFileToArray currTag variable
* @param    $lowerCaseTags. boolean. xmlFileToArray lowerCaseTags variable
* @param    $levels. String[]. xmlFileToArray levels variable
* @param    $prevTag. String. xmlFileToArray prevTag variable
* @param    $multipleData. boolean. xmlFileToArray multipleData variable
* @param    $xml. String[]. xmlFileToArray xml variable
* @access    private static
* @return    boolean
* @author    simgar
*/
function _xmlFileToArrayOpen(& $topTag, & $includeTopTag, & $val, & $lowerCaseTags,
                             & $levels, & $prevTag, & $multipleData, & $xml)
{
    // don't include top tag
    if (!$topTag && !$includeTopTag)
    {
        $topTag = $val["tag"];
        return false;
    }
    $currTag = $val["tag"];
    if ($lowerCaseTags)
    {
        $currTag = strtolower($val["tag"]);
    }
    $levels[] = $currTag;

    // Multiple items w/ same name. Convert to array.
    if ($prevTag === $currTag)
    {
        if (!array_key_exists($currTag, $multipleData) ||
            !$multipleData[$currTag]["multiple"])
        {
            $loc =& $xml;
            foreach ($levels as $level)
            {
                $temp =& $loc[$level];
                $loc =& $temp;
            }
            $loc = array($loc);
            $multipleData[$currTag]["multiple"] = true;
            $multipleData[$currTag]["multiple_count"] = 0;
        }
        $multipleData[$currTag]["popped"] = false;
        $levels[] = ":arr#" . ++$multipleData[$currTag]["multiple_count"];
    }
    else
    {
        $multipleData[$currTag]["multiple"] = false;
    }

    // Add attributes array
    if (array_key_exists("attributes", $val))
    {
        $loc =& $xml;
        foreach ($levels as $level)
        {
            $temp =& $loc[str_replace(":arr#", "", $level)];
            $loc =& $temp;
        }
        $keys = array_keys($val["attributes"]);
        foreach ($keys as $key)
        {
            $tag = $key;
            if ($lowerCaseTags)
            {
                $tag = strtolower($tag);
            }
            $loc["attributes"][$tag] = & $val["attributes"][$key];
        }
    }
    return true;
}
// }}}

// {{{ _xmlFileToArrayClose()
/**
* Private support function for XML_Array::xmlFileToArray. Handles an xml OPEN tag.
*
* @param    $topTag. String. xmlFileToArray topTag variable
* @param    $includeTopTag. boolean. xmlFileToArray includeTopTag variable
* @param    $val. String[]. xmlFileToArray val variable
* @param    $currTag. String. xmlFileToArray currTag variable
* @param    $lowerCaseTags. boolean. xmlFileToArray lowerCaseTags variable
* @param    $levels. String[]. xmlFileToArray levels variable
* @param    $prevTag. String. xmlFileToArray prevTag variable
* @param    $multipleData. boolean. xmlFileToArray multipleData variable
* @param    $xml. String[]. xmlFileToArray xml variable
* @access    private static
* @return    boolean
* @author    simgar
*/
function _xmlFileToArrayClose(& $topTag, & $includeTopTag, & $val, & $lowerCaseTags,
                              & $levels, & $prevTag, & $multipleData, & $xml)
{
    // don't include top tag
    if ($topTag && !$includeTopTag && $val["tag"] == $topTag)
    {
        return false;
    }
    if(!isset($currTag)) $currTag = '';
    if (isset($multipleData[$currTag]["multiple"]))
    {
        $tkeys = array_reverse(array_keys($multipleData));
        foreach ($tkeys as $tkey)
        {
            if ($multipleData[$tkey]["multiple"] && !$multipleData[$tkey]["popped"])
            {
                array_pop($levels);
                $multipleData[$tkey]["popped"] = true;
                break;
            }
            else if (!$multipleData[$tkey]["multiple"])
            {
                break;
            }
        }
    }
    $prevTag = array_pop($levels);
    if (strpos($prevTag, "arr#"))
    {
        $prevTag = array_pop($levels);
    }
    return true;
}
// }}}

}
?>