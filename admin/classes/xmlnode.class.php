<?php
/**
	xml node

	Created: js, 2003.04.03
	___________________________________________________________
	This file is part of flexiUpdate, content control framework

* @package core
*/
/**
*/

class xmlNode
{
	var $name;
	var $type;
	var $content = '';
	var $attributes = array();

	var $children = array();
	var $children_names = array();

	function xmlNode($name = '', $attr = array(), $content = '')
	{
		$this->name = $name;
		$this->attributes = $attr;
		$this->content = $content;
	}

	function setName($name)
	{
		$this->name = $name;
	}

	function getName()
	{
		return $this->name;
	}

	function setContent($content)
	{
		$this->content = $content;
	}

	function addContent($content)
	{
		$this->content .= $content;
	}

	function getContent()
	{
		return $this->content;
	}

	function setType($type)
	{
		$this->type = $type;
	}

	function getType()
	{
		return $this->type;
	}

	function isOneLiner()
	{
		return 'oneliner' == $this->getType();
	}

	function setAttributes($attr = array())
	{
		$this->attributes = $attr;
	}

	function getAttributes()
	{
		return $this->attributes;
	}

	function addChild(&$child)
	{
		$this->children[] =& $child;
		$this->children_names[$child->getName()][] =& $child;
	}

	function &getChild($name)
	{
		if (isset($this->children_names[$name][0]))
			return $this->children_names[$name][0];

		return null;
	}

	function &getChildAt($addr)
	{
		if ($pos = strpos($addr, '/'))
		{
			list($name, $addr) = split('/', $addr, 2);
			$tmp =& $this->getChild($name);
			return $tmp->getChildAt($addr);
		}
		else
		{
			return $this->getChild($addr);
		}
	}

	function hasChildren()
	{
		return count($this->children) > 0;
	}

	function getChildrenCount()
	{
		return count($this->children);
	}

	/**
	* return xml string of tree structure
	*/
	function toString()
	{
		$out = '<?xml version="1.0"?'.">\n<!-- <?php -->\n";
		$out .= $this->_writeTag(0);
		return $out;
	}


	/**
	* recursive routine for string representation
	*
	* @todo htmlencode content and attributes
	* @access private
	*/
	function _writeTag($depth)
	{
		$tabs = '';
		if ($depth) $tabs = str_repeat("\t", $depth);
		$out = $tabs;

		$childs = $this->getChildrenCount();


		// opentag
		$out .= "<".$this->getName();
		if ($this->attributes)
		{
			foreach($this->attributes as $key=>$val)
			{
				$out .= " $key=\"$val\"";
			}
		}
		if ($this->isOneLiner()) $out .= '/';
		$out .= '>';
		if ($childs || $this->isOneLiner()) $out .= "\n";

		// content
		if (!$this->isOneLiner() && ($content = $this->getContent()))
		{
			$out .= $content;
			if ($childs) { $out .= "\n"; }
		}

		// children
		if ($childs)
		{
			for ($i = 0; isset($this->children[$i]); $i++)
			{
				$out .= $this->children[$i]->_writeTag($depth+1);
			}
		}

		// closetag
		if (!$this->isOneLiner())
		{
			if ($childs) $out .= "$tabs";
			$out .= '</' . $this->getName() . ">\n";

		}

		return $out;
	}

}

?>