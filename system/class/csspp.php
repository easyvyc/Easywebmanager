<?php

class CSSPP
{
  // Regex for CSS expanders. Order in this array matters.
  static public $expanders = array(
    '#\s*appearance\s*:\s*(.+);#i' => '$0 -moz-appearance: $1; -o-appearace: $1; -webkit-appearance: $1;',
    '#\s*background\-image\s*:\s*gradient\((.+)\)\s*;#' => 'background-image: gradient($1); background-image: -moz-gradient($1); background-image: -o-gradient($1); background-image: -webkit-gradient($1);',
    '#\s*background\s*:.+gradient\((.+)\).+;#' => '$0 background-image: -moz-gradient($1); background-image: -o-gradient($1); background-image: -webkit-gradient($1);',
    '#\s*background\-clip\s*:\s*(.+);#i' => '$0 -moz-background-clip: $1; -o-background-clip: $1; -webkit-background-clip: $1;',
    '#\s*background\-origin\s*:\s*(.+);#i' => '$0 -moz-background-origin: $1; -o-background-origin: $1; -webkit-background-origin: $1;',
    '#\s*background\-size\s*:\s*(.+);#i' => '$0 -moz-background-size: $1; -o-background-size: $1; -webkit-background-size: $1;',
    '#\s*border\-radius\s*:\s*(.+);#i' => '$0 -moz-border-radius: $1; -o-border-radius: $1; -webkit-border-radius: $1;',
    '#\s*border-bottom-left-radius\s*:\s*(.+);#i' => '$0 -moz-border-radius-bottomleft: $1; -o-border-bottom-left-radius: $1; -webkit-border-bottom-left-radius: $1;',
    '#\s*border-bottom-right-radius\s*:\s*(.+);#i' => '$0 -moz-border-radius-bottomright: $1; -o-border-bottom-right-radius: $1; -webkit-border-bottom-right-radius: $1;',
    '#\s*border-top-left-radius\s*:\s*(.+);#i' => '$0 -moz-border-radius-topleft: $1; -o-border-top-left-radius: $1; -webkit-border-top-left-radius: $1;',
    '#\s*border-top-right-radius\s*:\s*(.+);#i' => '$0 -moz-border-radius-topright: $1; -o-border-top-right-radius: $1; -webkit-border-top-right-radius: $1;',
    '#\s*box\-shadow\s*:\s*(.+);#i' => '$0 -moz-box-shadow: $1; -o-box-shadow: $1; -webkit-box-shadow: $1;',
    '#\s*box\-sizing\s*:\s*(.+);#i' => '$0 -moz-box-sizing: $1; -o-box-sizing: $1; -webkit-box-sizing: $1;',
    '#\s*transition\s*:\s*(.+);#i' => '$0 -moz-transition: $1; -o-transition: $1 -webkit-transition: $1;',
    '#\s*transition-duration\s*:\s*(.+);#i' => '$0 -moz-transition-duration: $1; -o-transition-duration: $1; -webkit-transition-duration: $1;',
    '#\s*transition-property\s*:\s*(.+);#i' => '$0 -moz-transition-property: $1; -o-transition-property: $1; -webkit-transition-property: $1;',
    '#\s*transition-timing-function\s*:\s*(.+);#i' => '$0 -moz-transition-timing-function: $1; -o-transition-timing-function: $1; -webkit-transition-timing-function: $1;',
    '#\s*user-drag\s*:\s*(.+);#i' => '$0 -moz-user-drag: $1; -o-user-drag: $1; -webkit-user-drag: $1;',
    '#\s*user-select\s*:\s*(.+);#i' => '$0 -moz-user-select: $1; -o-user-select: $1; -webkit-user-select: $1;'
  );
  
  private $base_dir;
  private $css;
  private $file;
  private $included = array();
  private $options = array(
    'bases' => TRUE,
    'comments' => FALSE,
    'expanders' => TRUE,
    'includes' => TRUE,
    'imports' => TRUE,
    'minify' => TRUE,
    'variables' => TRUE
  );
  
  // Constructor method
  // Requires a file and a base directory
  function __construct($options=array())
  {
    // Set any options passed in
    $this->setOptions($options);
  }
  
  public function add($file_path)
  {
    // Append the intial CSS file into an instance variable
    $this->append(file_get_contents($file_path));
  }

  // Magic method for outputing the CSS using an echo statement
  public function __toString()
  {
    return $this->process();
  }
  
  // Appends some text (Hopefully CSS) to the end of the CSS
  public function append($css)
  {
    $this->css .= $css;
  }

  // Replace all instances of @include with the contents of the file
  private function includeExternals()
  {
    
    // Find all instances of @include
    preg_match_all('#@include\s*\'(.+)\';#i', $this->css, $found);
    
    // Search through all of the found instances of @include and replace it
    // with the contents of the file it references
    foreach($found[1] as $i => $include)
    {
      $file = preg_replace('#^("|\')|("|\')$#', '', $include);

      // Make sure we haven't included the file already
      if (!in_array($file, $this->included))
      {
        if (substr($file, 0, 1) == '/')
        {
          $file_name = $file;
        }
        else
        {
          $file_name = $this->css_dir . '/' . $file;
        }
        $css = file_get_contents($file_name);
        $this->css = str_replace($found[0][$i], $css, $this->css);
        array_push($this->included, $file);
      }
      else
      {
        $this->css = str_replace($found[0][$i], '', $this->css);
      }
    }
  }

  // Replace all instances of @import with the contents of the file recursivelly
  private function importExternals()
  {
    
    // Find all instances of @include
    preg_match_all('#@import\s*"(.+)";#i', $this->css, $found);
    
    // Search through all of the found instances of @include and replace it
    // with the contents of the file it references
    foreach($found[1] as $i => $include)
    {
      $file = preg_replace('#^("|\')|("|\')$#', '', $include);

      // Make sure we haven't included the file already
      if (!in_array($file, $this->included))
      {
        $base_dir = $this->css_dir . DS;
        if (substr($file, 0, 1) == '/')
        {
          $base_dir = $this->base_dir;
        }
        $filename = realpath($base_dir . $file);
        $csspp = new CSSPP(basename($filename), dirname($filename) . DS, $this->options);
        $css = (string)$csspp;
        $this->css = str_replace($found[0][$i], $css, $this->css);
        array_push($this->included, $file);
      }
      else
      {
        $this->css = str_replace($found[0][$i], '', $this->css);
      }
    }
  }
  
  // Remove any extra, unneed stuff from the CSS to make it as small as possible
  private function minify()
  {
    $this->removeWhitespace();
    $this->removeLastSemicolon();
  }
  
  // Processed the CSS
  public function process()
  {
    if ($this->options['includes'])
    {
      $this->includeExternals();
    }

    if ($this->options['imports'])
    {
      $this->importExternals();
    }
    
    if (!$this->options['comments'])
    {
      $this->removeComments();
    }
    
    if ($this->options['variables'])
    {
      $this->replaceVariables();
    }
    
    if ($this->options['expanders'])
    {
      $this->replaceExpanders();
    }
    
    if ($this->options['bases'])
    {
      $this->replaceBases();
    }
    
    if ($this->options['minify'])
    {
      $this->minify();
    }
    
    return $this->css;
  }
  
  // Remove all of the comments from the CSS file
  private function removeComments()
  {
    $this->css = preg_replace('#\/\*[\d\D]*?\*\/|\t+#', '', $this->css);
  }
  
  // Remove the last semicolon of each selector block
  private function removeLastSemicolon()
  {
    $this->css = str_replace(';}', '}', $this->css);
  }
  
  // Remove extra spaces in the CSS
  private function removeWhitespace()
  {
    $this->css = str_replace(array("\n", "\r", "\t"), '', $this->css);
    $this->css = preg_replace('/\s\s+/', '', $this->css);
    $this->css = preg_replace('/\s*({|}|\[|\]|=|~|\+|>|\||;|:|,)\s*/', '$1', $this->css);
  }
  
  // Find the bases and psuedo bases and replace the based-on statements
  private function replaceBases()
  {
    // Find all of the bases with psuedo elements
    preg_match_all('#@base\(([^\s]+)\)\:([^\s\{]+)\s*\{(\s*[^\}]+)\s*\}\s*#i', $this->css, $found);
    foreach ($found[0] as $i => $base)
    {
      // Find all of the based-on statements
      preg_match_all("#\s*([^\}]+)\s*\{[^\{]+based\-on\s*:\s*base\({$found[1][$i]}\)\s*;\s*[^\}]+\s*\}#", $this->css, $property);
      foreach ($property[0] as $j => $parent)
      {
        // Apply the psudeo element to multiple selects
        $selectors = explode(',', $property[1][$j]);
        for ($k = 0; $k < count($selectors); $k++)
        {
          $selectors[$k] = trim($selectors[$k]) . ':' . $found[2][$i];
        }
        $selectors = implode(', ', $selectors);
        
        // And apply the properties to the psuedo bases
        $this->css = str_replace($property[0][$j], "{$property[0][$j]} $selectors {{$found[3][$i]}}", $this->css);
      }
      
      // Remove the psuedo base from the CSS
      $this->css = str_replace($base, '', $this->css);
    }
    
    // Find all of the plain-old base statements
    preg_match_all('#@base\(([^\s\{]+)\)\s*\{(\s*[^\}]+)\s*\}\s*#i', $this->css, $found);
    foreach ($found[0] as $i => $base)
    {
      $this->css = str_replace($base, '', $this->css);
      $this->css = preg_replace("#based\-on\s*:\s*base\({$found[1][$i]}\)\s*;\s*#", trim($found[2][$i]), $this->css);
    }
  }
  
  // Iterates through the css expanders and replaces them
  private function replaceExpanders()
  {
    foreach (self::$expanders as $expander => $replacer)
    {
      $this->css = preg_replace($expander, $replacer, $this->css);
    }
  }
  
  // Find the variable declarations and replace the variables
  private function replaceVariables()
  {
    // Find all of the variable declaration groups
    preg_match_all('#@variables\s*\{\s*([^\}]+)\s*\}\s*#i', $this->css, $found);
    foreach ($found[0] as $i => $variable_group)
    {
      // Remove the variable group from the css
      $this->css = str_replace($variable_group, '', $this->css);
      
      // Find the individual variables
      preg_match_all('#([_a-z0-9\-]+)\s*:\s*([^;]+);#i', $found[1][$i], $variables);
      foreach ($variables[1] as $variable => $name)
      {
        // Replace the variables within the CSS
        $this->css = str_replace("var($name)", $variables[2][$variable], $this->css);
      }
    }
  }
  
  // Set a processor option
  public function setOption($key, $value)
  {
    $this->options[$key] = $value;
  }
  
  // Set multiple processor option at once
  public function setOptions($options)
  {
    foreach ($options as $key => $value)
    {
      $this->setOption($key, $value);
    }
  }
}