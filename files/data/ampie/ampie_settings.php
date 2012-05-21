<?php

include_once("../../../inc/config.inc.php");

?>
// version 1.0
// amPie settings file 
// www.amcharts.com/pie/
// created by Antanas Marcelionis

// all x, y positions, widths and heights, text sizes are measured in pixels
// y = 0 is in top of the flash, going down y increases
// you can delete all comments in order to load this settings file faster

// DATA //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

dataFileName = <?php echo Config::$val['site_url'].("xml.php?get=stat/{$_GET['stat']}&from_date={$_GET['from_date']}&to_date={$_GET['to_date']}"); ?>        // data file name
                                       // this file must be in the same or deeper folder where am_pie.swf file is
                                       // if you wish to have this file somewhere else, indicate absolute URL like:
                                       // http://www.yourdomain.com/somefolder/settingsfile.txt or
                                       // http://www.yourdomain.com/someotherfolder/settingsfile.xml

csv = false                             // if false, data file name is parsed as XML, if true - as coma separated value file

csvSeparator = ;                       // data separator in csv file  


// TITLE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

titleText =            // pie title. Use \n for new line

titleX = 0                             // x position of title

titleY = 0                            // y position of title

titleTextBoxWidth = 0                // width of a title text box
                                       
titleAlign = center                     // (left, center, right) alignment of the title text

titleTextColor = #000000               // (hex value) color of the title text

titleTextSize = 0                     // title text size

titleBold = false                       // (true, false) whether title must be bold or not


// SOURCE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

sourceText =       // data source

sourceLink =    // data source link

sourceX = 0                            // x position of source

sourceY = 0                          // y position of source

sourceTextBoxWidth = 0               // width of a source text box
      
sourceAlign = left                     // (left, center, right) alignment of the source text

sourceTextColor = #0055CC              // (hex value) color of the source text

sourceTextSize = 0                    // source text size

sourceBold = false                     // (true, false) whether source must be bold or not


// GENERAL ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

font = Tahoma                           // Font of all texts in a pie 
                                       // Use default fonts such as Verdana, Arial, Courier, Times New Roman
                                       
//backgroundFile = am_background.jpg   // you can use your custom background, SWF or JPG file.
                                       // JPG file can not be saved as "progressive"
                                       // use absolute url (with http://) if this file is not in the same as am_pie.swf folder
                                       

// PIE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

pieX = 210                             //  x position of a pie (for middle of the flash use flashWidth/2)

pieY = 110                             //  y position of a pie (for middle of the flash use flashHeight/2)

radius = 100                           //  radius of a pie

pieAngle = 45                           // (0 - 90) angle (for 3D effect) 0 for 2d circle
     
innerRadius = 40                       // (0 - xRadius) radius of a hole inside the pie (to have doughnut effect)
                                       // use 0 for full pie
                                       
height = 5                             // (0 - ...) height of a pie (for 3D effect)

pieOutlineColor = #FFFFFF              // (hex value) pie outline color

pieOutlineAlpha = 0                    // (0 - 100) pie outline alpha. 0 if you don't want outline at all

pullOutRadius = 15                     // (0 - ...) distance to pull out slice on click


// PIE COLORS /////////////////////////////////////////////////////////////////////////////////////////////////////////////

pieColors = #FF0F00, #FF6600, #FF9E01, #FCD202, #F8FF01, #B0DE09, #04D215, #0D8ECF, #0D52D1, #2A0CD0, #8A0CCF, #CD0D74 
                                       // color array. Colors set in XML or CSV file overwrites these colors 
                                       // if there are more slices then colors, the cycle starts from the beginning
                                       // Leave empty, delete or comment this line if you want to use baseColor
                                       
                                               
baseColor = #CC0000                    // (hex value) base color of the first slice. 
                                       // used if colors XML or CSV file and in pieColors are not specified
                                       
brightnessStep = 20                    // (-100 - 100) if baseColor is used, every next slice is filled with lighter by brightnessStep % color
                                       // use negative value if you want to get darker colors
                                       

// APPEARANCE /////////////////////////////////////////////////////////////////////////////////////////////////////////////

bounce = true                          // (true, false) true if you want pie slices to bounce, false - if not

startRadius = 200                      // (0 - ....) distance from which slices should start fly in
                                       // use 0 if you don't want them to fly
                                        
startAlpha = 0                         // (0 - 100) start alpha of slices
                                       
startTime = 1.5                        // (0 - ...) time of fly-in and fade-in effect, in seconds
                                       // use 0 for instant appearance
                                       

// LABEL //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

labelRadius = 30                       // (-xRadius - ...) distance of the labels from the pie
                                       // use negative value to place labels on the pie

labelTextColor = #000000               // (hex value) label text color

labelTextSize = 11                     // label text size

showInLabel = title                  // (percent, value, title) which data must be shown in label
                                       // can be empty, one, two or all three values.
                                        
labelSeparator = \n                    // if there are more than one data shown in a label, you can specify separator
                                       // use \n is for a new line
                                       // use &nbsp; for space
                                                   
showLines = true                       // (true, false) lines from slices to labels
 
lineColor = #DADADA                    // (hex value) lines color

valueUnits =                       // value units. Will be shown near value in a label and indicator if value is specified to be shown
 
percentPrecision = 1                   // (0 - ...) how many numbers must be left after coma in a displayed percent value
                                       // (both in label and indicator, if specified to be shown)
                                       
skipLabelsPercent = 3                  // Labels of slices less then [skipLabelsPercent]% will be not displayed
                                       // to avoid label overlapping if there are many small pie slices                                          
                                       

// GROUP TO OTHER /////////////////////////////////////////////////////////////////////////////////////////////////////////

groupToOtherPercent = 0                // (0 - 100) if the calculated percent value is less than specified and there are more
                                       // than one such values, they can be grouped to "The others" slice
                                       
otherColor = #FFFFFF                   // color of "The others" slice
                                       // leave empty if you are using pieColors or baseColor
                                            
otherTitle = The Others                // Title of "The others" slice
 
otherPullOut = false                   // (true, false) whether to pull out the other slice or not


// ROLL OVER INDICATOR ////////////////////////////////////////////////////////////////////////////////////////////////////

indicatorColor = #CC0000               // (hex value) indicator (shown on roll over the slice event) color

indicatorAlpha = 85                    // (0 - 100) indicator alpha

indicatorTextColor = #FFFFFF           // (hex value) indicator text color
 
indicatorTextSize = 14                 // indicator text size

indicatorSeparator = \n                // if there are more then one data shown in the indicator, you can specify separator
                                       // use \n is for new line
                                       // use &nbsp; for space 
                                       
showInIndicator = title, value,percent         // (percent, value, title) which data must be shown in the indicator
                                       // can be empty, one, two or all three values
                                       

// LEGEND /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

showLegend = true                      // (true, false) whether to show legend or not

legendWidth = 320                       // width of the legend
 
legendX = 420                           // x position of the legend

legendY = 25                            // y position of the legend

legendTextColor = #000000               // (hex value) legend text color
            
legendTextSize = 11                     // legend text size

legendColorBoxSize = 14                 // size of a small box indicating color

legendColorBoxBorderColor = #000000     // (hex value) color of this small box border

legendBoxColor = #FFFFFF                // (hex value) color of legend box

legendBoxAlpha = 0                      // (0-100) alpha of legend box. 0 if you don't want it at all

legendBoxOutlineColor = #000000         // (hex value) color of legend box outline

legendBoxOutlineAlpha = 0               // (0-100) alpha of legend box. 0 if you don't want it at all

legendBoxMargins = 0                    // legend box margins


// OUTLINE & BACKGROUND COLOR ///////////////////////////////////////////////////////////////////////////////////////////////

outlineAlpha = 0                        // (0 - 100) outline alpha. 0 if you don't want it at all

outlineColor = #000000                  // (hex value) color of outline

outlineX = 0                            // x position of outline

outlineY = 0                            // y position of outline

outlineWidth = 0                        // outline width in pixels. Leave 0 if you want it to match your flash movie size

outlineHeight = 0                       // outline height in pixels. Leave 0 if you want it to match your flash movie size

backgroundColor = #FFFFFF //#FEF9F3             // by default, background color is specified in html file
                                        // the size and position of this background will be equal to outline size and position.
                                        // do not use this setting if you are using background picture or swf   
