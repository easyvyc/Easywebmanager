<?php

include_once("../../../inc/config.inc.php");

?>
<!-- Value between [] brackets, for example [#FFFFFF] shows default value which is used if this parameter is not set -->
<!-- This means, that if you are happy with this value, you can delete this line at all and reduce file size -->
<!-- value or explanation between () brackets shows the range or type of values you should use for this parameter -->
<settings> 
  <type>column</type>                                         <!-- [column] (column / bar) -->

  <width></width>                                             <!-- [] (Number) if empty, will be equal to width of your flash movie -->
  <height></height>                                           <!-- [] (Number) if empty, will be equal to height of your flash movie -->

  <data_type>xml</data_type>                                  <!-- [xml] (xml / csv) -->
  <csv_separator>;</csv_separator>                            <!-- [;] (string) csv file data separator (you need it only if you are using csv file for your data) -->     
  <skip_rows>0</skip_rows>                                    <!-- [0] (Number) if you are using csv data type, you can set the number of rows which should be skipped here -->
  <font>Garamond</font>                                       <!-- [Arial] (font name) use device fonts, such as Arial, Times New Roman, Tahoma, Verdana... -->
  <text_size>11</text_size>                                   <!-- [11] (Number) text size of all texts. Every text size can be set individually in the settings below -->
  <text_color>#000000</text_color>                            <!-- [#000000] (hex color code) main text color. Every text color can be set individually in the settings below-->
  <decimals_separator>,</decimals_separator>                  <!-- [,] (string) decimal separator. Note, that this is for displaying data only. Decimals in data xml file must be separated with dot -->
  <thousands_separator> </thousands_separator>                <!-- [ ] (string) thousand separator -->
  <redraw>true</redraw>                                       <!-- [false] (true / false) if your chart's width or height is set in percents, and redraw is set to true, the chart will be redrawn then screen size changes -->
                                                              <!-- this function is beta, be careful. Legend, buttons labels will not be repositioned if you set your x and y values for these objects -->
  <reload_data_interval>0</reload_data_interval>              <!-- [0] (Number) how often data should be reloaded (time in seconds) -->
  <add_time_stamp>false</add_time_stamp>                      <!-- [false] (true / false) if true, a unique number will be added every time flash loads data. Mainly this feature is useful if you set reload _data_interval -->
  <precision>2</precision>                                    <!-- [2] (Number) shows how many numbers should be shown after comma for calculated values (percents) -->
  <depth>30</depth>                                           <!-- [0] (Number) the depth of chart and columns (for 3D effect) -->
  <angle>25</angle>                                           <!-- [30] (0 - 90) angle of chart area and columns (for 3D effect) -->
  
  <column>
    <type>clustered</type>                                    <!-- [clustered] (stacked, 100% stacked) -->
    <width>50</width>                                         <!-- [80] (0 - 100) width of column (in percents)  -->
    <spacing>0</spacing>                                      <!-- [5] (Number) space between columns of one category axis value, in pixels. Negative values can be used. -->
    <grow_time>0</grow_time>                                  <!-- [0] (Number) grow time in seconds. Leave 0 to appear instantly -->
    <grow_effect>elastic</grow_effect>                        <!-- [elastic] (elastic, regular, strong) -->    
    <alpha>100</alpha>                                        <!-- [100] (Number) alpha of all columns -->
    <border_color>#FFFFFF</border_color>                      <!-- [#FFFFFF] (hex color code) -->
    <border_alpha></border_alpha>                             <!-- [0] (Number) -->
    <data_labels>
      <![CDATA[]]>                                            <!-- [] ({title} {value} {series} {percents}) You can format any data label: {title} will be replaced with real title, {value} - with value and so on. You can add your own text or html code too. -->
    </data_labels>
    <data_labels_text_color></data_labels_text_color>         <!-- [text_color] (hex color code) --> 
    <data_labels_text_size></data_labels_text_size>           <!-- [text_size] (Number) -->
    <link_target></link_target>                               <!-- [] (_blank, _top ...) -->                         
  </column>
  
  <background>                                                <!-- BACKGROUND -->
    <color>#FFFFFF</color>                                    <!-- [#FFFFFF] (hex color code) -->
    <alpha></alpha>                                           <!-- [0] (0 - 100) use 0 if you are using custom swf or jpg for background -->
    <border_color>#000000</border_color>                      <!-- [#FFFFFF] (hex color code) -->
    <border_alpha>15</border_alpha>                           <!-- [0] (0 - 100) -->
    <file></file>                                             <!-- [] (filename) swf or jpg file of a background. Do not use progressive jpg file, it will be not visible with flash player 7 -->
                                                              <!-- The chart will look for this file in amcolumn_path folder (amcolumn_path is set in HTML) -->
  </background>
     
  <plot_area>                                                 <!-- PLOT AREA (the area between axes) -->
    <color>#000000</color>                                    <!-- [#FFFFFF](hex color code) -->
    <alpha>10</alpha>                                         <!-- [0] (0 - 100) if you want it to be different than background color, use bigger than 0 value -->                                        
    <margins>                                                 <!-- plot area margins -->
      <left>30</left>                                         <!-- [60](Number) --> 
      <top>35</top>                                           <!-- [60](Number) --> 
      <right>40</right>                                       <!-- [60](Number) -->
      <bottom>40</bottom>                                     <!-- [80](Number) -->
    </margins>
  </plot_area>
  
  <grid>                                                      <!-- GRID -->
    <category>                                                <!-- category axis grid -->                                                     
      <color>#000000</color>                                  <!-- [#000000] (hex color code) -->
      <alpha>20</alpha>                                       <!-- [15] (0 - 100) -->
      <dashed>true</dashed>                                   <!-- [false](true / false) -->
      <dash_length>5</dash_length>                            <!-- [5] (Number) -->  

    </category>
    <value>                                                   <!-- value axis grid -->      
      <color>#000000</color>                                  <!-- [#000000] (hex color code) -->
      <alpha>20</alpha>                                       <!-- [15] (0 - 100) -->
      <dashed>true</dashed>                                   <!-- [false] (true / false) -->
      <dash_length>5</dash_length>                            <!-- [5] (Number) -->
      <approx_count>10</approx_count>                         <!-- [10] (Number) approximate number of gridlines -->      
    </value>
  </grid>
  
  <values>                                                    <!-- VALUES -->
    <category>                                                <!-- category axis -->
      <enabled>true</enabled>                                 <!-- [true] (true / false) -->    
      <color>#000000</color>                                         <!-- [text_color] (hex color code) -->
      <text_size></text_size>                                 <!-- [text_size] (Number) -->    
    </category>
    <value>                                                   <!-- value axis -->
      <enabled>true</enabled>                                 <!-- [true] (true / false) -->    
      <min>0</min>                                            <!-- [] (Number) minimum value of this axis. If empty, this value will be calculated automatically. -->
      <max></max>                                             <!-- [] (Number) maximum value of this axis. If empty, this value will be calculated automatically -->
                                                              <!-- max and min values are recalculated and may be different from entered here. For example, if you set min value -1000 and max value 994, the max value will be changed to 1000. -->
      <frequency>1</frequency>                                <!-- [1] (Number) how often values should be placed, 1 - near every gridline, 2 - near every second gridline... -->
      <skip_first>true</skip_first>                           <!-- [true] (true / false) to skip or not first value -->
      <skip_last>false</skip_last>                            <!-- [false] (true / false) to skip or not last value -->
      <color></color>                                         <!-- [text_color] (hex color code) --> 
      <text_size></text_size>                                 <!-- [text_size] (Number) -->
      <unit></unit>                                          <!-- [] (text) -->
      <unit_position>right</unit_position>                    <!-- [right] (right / left) -->       
    </value>
  </values>
  
  <axes>                                                      <!-- axes -->
    <category>                                                <!-- category axis -->
      <color>#000000</color>                                  <!-- [#000000] (hex color code) -->
      <alpha>20</alpha>                                       <!-- [100] (0 - 100) -->
      <width>1</width>                                        <!-- [2] (Number) line width, 0 for hairline -->
      <tick_length>7</tick_length>                            <!-- [7] (Number) -->
    </category>
    <value>                                                   <!-- value axis -->
      <color>#000000</color>                                  <!-- [#000000] (hex color code) -->
      <alpha>20</alpha>                                       <!-- [100] (0 - 100) -->
      <width>1</width>                                        <!-- [2] (Number) line width, 0 for hairline -->
      <tick_length>7</tick_length>                            <!-- [7] (Number) -->
    </value>
  </axes>  
  
  <balloon>                                                   <!-- BALLOON -->
    <enabled>true</enabled>                                   <!-- [true] (true / false) -->
    <color></color>                                           <!-- [] (hex color code) balloon background color. If empty, slightly darker then current column color will be used -->
    <alpha>100</alpha>                                        <!-- [100] (0 - 100) -->
    <text_color>#000000</text_color>                          <!-- [text_color] (hex color code) -->
    <text_size></text_size>                                   <!-- [text_size] (Number) -->    
    <show>                                                    
      <![CDATA[{series}<br>{title}: {value}]]>                         <!-- [<![CDATA[{value}]]>] ({title} {value} {series} {percents}) You can format any data label: {title} will be replaced with real title, {value} - with value and so on. You can add your own text or html code too. -->
    </show>  
  </balloon>
    
  <legend>                                                    <!-- LEGEND -->
    <enabled>true</enabled>                                   <!-- [true] (true / false) -->
    <x>30</x>                                                <!-- [] (Number) if empty, will be equal to left margin -->
    <y>180</y>                                                <!-- [] (Number) if empty, will be below plot area -->
    <width></width>                                           <!-- [] (Number) if empty, will be equal to plot area width -->
    <color>#000000</color>                                    <!-- [#FFFFFF] (hex color code) background color -->
    <alpha></alpha>                                           <!-- [0] (0 - 100) background alpha -->
    <border_color>#000000</border_color>                      <!-- [#000000] (hex color code) border color -->
    <border_alpha>0</border_alpha>                            <!-- [0] (0 - 100) border alpha -->
    <text_color></text_color>                                 <!-- [text_color] (hex color code) -->   
    <text_size></text_size>                                   <!-- [text_size] (Number) -->
    <spacing>5</spacing>                                      <!-- [10] (Number) vertical and horizontal gap between legend entries -->
    <margins>0</margins>                                      <!-- [0] (Number) legend margins (space between legend border and legend entries, recommended to use only if legend border is visible or background color is different from chart area background color) -->    
    <key>                                                     <!-- KEY (the color box near every legend entry) -->
      <size>16</size>                                         <!-- [16] (Number) key size-->
      <border_color></border_color>                           <!-- [] (hex color code) leave empty if you don't want to have border-->
    </key>
  </legend>  
  
  <labels>                                                    <!-- LABELS -->
                                                              <!-- you can add as many labels as you want -->
    <label>
      <x>0</x>                                                <!-- [0] (Number) -->
      <y>25</y>                                               <!-- [0] (Number) -->
      <width></width>                                         <!-- [] (Number) if empty, will stretch from left to right untill label fits -->
      <align>center</align>                                   <!-- [left] (left / center / right) -->  
      <text_color></text_color>                               <!-- [text_color] (hex color code) button text color -->
      <text_size>18</text_size>                               <!-- [text_size](Number) button text size -->
      <text></text>                                                  <!-- [] (text) html tags may be used (supports <b>, <i>, <u>, <font>, <a href="">, <br/>. Enter text between []: <![CDATA[your <b>bold</b> and <i>italic</i> text]]>-->
              
    </label>
  </labels>
  
  <graphs>                                                    <!-- GRAPHS SETTINGS. These settings can also be specified in data file, as attributes of <graph>, in this case you can delete everything from <graphs> to </graphs> (including) -->
                                                              <!-- It is recommended to have graph settings here if you don't want to mix data with other params -->
                                                              <!-- copy <graph>...</graph> (including) as many times as many graphs you have and edit settings individually -->
                                                              <!-- if graph settings are defined both here and in data file, the ones from data file are used -->
    <graph gid="0">                                           <!-- if you are using XML data file, graph "gid" must match graph "gid" in data file -->
	  <title><?php echo $cms_phrases['main']['stat']['unique_visitors']; ?></title>
      <color>#FF0F00</color>                                  <!-- [] (hex color code) -->
      <alpha></alpha>                                         <!-- [column.alpha] (0 - 100) -->
    </graph>

    <graph gid="1">                                     
      <title><?php echo $cms_phrases['main']['stat']['referer_visitors']; ?></title>
      <color>#04D215</color>                                   
      <alpha></alpha>                                   
    </graph>      
  </graphs>
</settings>
