
/*
Multiple background CSS Parser for IE6/7/8, Firefox <=3.5
Author: Ben Green (bgreen@chicowebdesign.com)
Date: 101117
License: Free

Usage: background: url(left.gif) no-repeat 0 0, url(right.gif) no-repeat 100% 0, url(middle.gif) repeat-x 0 0;
Also includes support for :active, :hover, and :focus psuedo classes


*/
jQuery(function($){
	//conditional for which browsers you want to support (ie6/7/8,firefox<=3.5)
	if(($.browser.msie && parseFloat($.browser.version)>=6 && parseFloat($.browser.version)< 9)||
	   ($.browser.mozilla && parseInt($.browser.version.substr(0,1))<=1 && parseInt($.browser.version.substr(2,1))<=9 && parseInt($.browser.version.substr(4,1))<=1)){
	   //store the loaded css rules
		var myCss={};
		var putLayerOutside=new Array("input");
	   
		/*
		Supplementary JQuery Extension:

		*
		* @author Terry Wooton+Ben Green
		* @desc Adds a background layer to an element
		* @version 2
		* @example
		* $("#elaement").addLayer("url('/test.gif') bottom left no-repeat");
		* @license free
		* @param background css
		* @param outer boolean
		*
		@modified Ben Green to support padding correctly and took off weird extra divs...
					and the ability to put extra wrappers on the outside of elements
		*/
		$.fn.addLayer = function(bg,outer,params) {
			$(this).each(function() {

				var s = $(this).extend({},params || {});      
				if(outer){
					//put layers on outside
					var $this=$(this);
					$this.wrap('<div class="add_background_outer" />');
					$last=$this.parent();
					
					$last.css({"margin":$this.css("margin"),
								"display":$this.css("display"),
								"position":$this.css("position"),
								"top":$this.css("top"),
								"left":$this.css("left"),
								"right":$this.css("right"),
								"bottom":$this.css("bottom"),
								"float":$this.css("float"),
								"clear":$this.css("clear"),
								"z-index":$this.css("z-index"),
								"height":parseFloat($this.css("height").replace("px",""))+parseFloat($this.css("padding-top").replace("px",""))+parseFloat($this.css("padding-bottom").replace("px","")),
								"width":parseFloat($this.css("width").replace("px",""))+parseFloat($this.css("padding-left").replace("px",""))+parseFloat($this.css("padding-right").replace("px","")),
								"-moz-border-radius-bottomright":$this.css("-moz-border-radius-bottomright"),
								"-moz-border-radius-bottomleft":$this.css("-moz-border-radius-bottomleft"),
								"-moz-border-radius-topleft":$this.css("-moz-border-radius-topleft"),
								"-moz-border-radius-topright":$this.css("-moz-border-radius-topright"),
								"background":bg});
					$this.css({"margin":'',
								"display":'',
								"position":'',
								"top":'',
								"left":'',
								"right":'',
								"bottom":'',
								"float":'',
								"z-index":'',
								"clear":'',
								"height":'',
								"width":'',
								"-moz-border-radius-bottomright":'',
								"-moz-border-radius-bottomleft":'',
								"-moz-border-radius-topleft":'',
								"-moz-border-radius-topright":''});
				}else{
					//put layers on inside

					$last = ($(this).find('.add_background:last').length > 0 ? $(this).find('.add_background:last') : $(this));
					var innerHtml=$last.html();
					if($.browser.msie){
						$last.html('<div class="add_background">'+innerHtml+'</div>');
					}else{
						//firefox will add wrapper divs when setting the innerhtml for some reason
						$last.empty().append('<div class="add_background">'+innerHtml+'</div>');
					};
					$last = $(this).find('.add_background:last');
					if(($.browser.msie && parseFloat($.browser.version)<8)&&($(this).css('position')=="static")){
						//width/height screws up negative margin in ie6/7 on elements without position:relative?
						$last.css({'background':bg});
					}else{
						$last.css({'background':bg,'width':'100%','height':'100%'});
					};
					//take care of any padding that would mess up the layout by using negative margins
					var $parent=$last.parent();
					var p=new Array($parent.css("padding-top"),$parent.css("padding-right"),$parent.css("padding-bottom"),$parent.css("padding-left"),$parent.css("height"));
					if($.browser.msie && parseFloat($.browser.version)<6){
						$parent.css("padding","0");
						$last.css({'padding-top':p[0],'padding-right':p[1],'padding-bottom':p[2],'padding-left':p[3]});
					}else{
						
						$last.css({'padding-top':p[0],'padding-right':p[1],'padding-bottom':p[2],'padding-left':p[3], 'margin-top':'-'+p[0],'margin-right':'-'+p[1],'margin-bottom':'-'+p[2],'margin-left':'-'+p[3]});
						if($.browser.msie && parseInt($.browser.version)<=7){
							//ie 7 wont push everything all the way out all the time so give it a height
							$last.css({'height':p[4]});
						};
					};

					//commented out just like extra wrapper div in the constructor above
					//$last = $(this).find('.add_background div:last');

					if(s.insideCss){
						$last.css(s.insideCss);
					};
					if(s.insideClass)
						$last.addClass(s.insideClass);  	

				};
			});
		};
		//End Supplementary Extension
		  
		//remove a layer
		//@param element: selector for the actual layer element, not the element with the layers
		function removeLayer(element){
			var $layer=$(element);
			var $parent=$layer.parent();
	  		var p=new Array($layer.css("padding-top"),$layer.css("padding-right"),$layer.css("padding-bottom"),$layer.css("padding-left"));
	  		var innerHtml=$layer.html();
	  		$parent.html(innerHtml);
	  		if($.browser.msie && parseFloat($.browser.version)<6){
	  			$parent.css({'padding-top':p[0],'padding-right':p[1],'padding-bottom':p[2],'padding-left':p[3]});
	  		};
		};
		function removeOuterLayer(element){
			var $layer=$(element);
			var $child=$($layer.children()[0]);
			
			$child.css({"margin":$layer.css("margin"),
						"position":$layer.css("position"),
						"top":$layer.css("top"),
						"left":$layer.css("left"),
						"right":$layer.css("right"),
						"bottom":$layer.css("bottom"),
						"float":$layer.css("float"),
						"clear":$layer.css("clear"),
						"z-index":$layer.css("z-index")});
	  		$child.unwrap();
	  		
			
		};

		//find lower/uppercase combinations and replace with lowercase for compatability
		function replaceWithLower(inStr,replaceWith){
			var linStr=inStr.toLowerCase();
			var pos=linStr.indexOf(replaceWith);
			while(pos>-1){
				inStr=inStr.substr(0,pos)+replaceWith+inStr.substr(pos+replaceWith.length);
				pos=linStr.indexOf(replaceWith,pos+1);
			};
			return inStr;
		};
		

		//read in a selector and output and integer precedence score
		function selectorScore(selector,important){
			//decendents and siblings arent any different to us
			selector=selector.replace(">"," ").replace("+"," ");
			var sSpl=selector.split(" ");
			var score=0;
			for(var i=0;i<sSpl.length;i++){
				var cPart=$.trim(sSpl[i]);
				var pos=0;
				while(pos>-1){
					function analyzePosition(p){
						var lowest=10000; /*theorical max selector length*/
						var which=-1;
						for(var i=0;i<p.length;i++){
							if((p[i]<lowest)&&(p[i]>-1)){
								lowest=p[i];
								which=i;
							};
						};
						if(lowest==10000) lowest=-1;
						return {'lowest':lowest,'which':which};
					};
					var p=[cPart.indexOf("#",pos),cPart.indexOf(".",pos),cPart.indexOf(":",pos)];
					var a=analyzePosition(p);
					if(pos==0 && a.lowest>0){
						//this item began with an element
						score+=1;
						pos++;
					}else if(pos==0 && a.lowest==-1){
						//this item is just an element!
						score+=1;
						break;
					}else if(a.lowest>-1){
						if(a.which==0){score+=100; /* id found */ };
						if(a.which==1){score+=10; /* class found */ };
						if(a.which==2){score+=10; /* psuedo-class found */ };
						pos=a.lowest+1;
					}else if(pos==0){ 
						score+=1;  /* element found */
					}else{
						break;
					};
				};
			};
			return score+(important ? 1000 : 0);
		};
		
		//in order to not get messed up on things like:
		//rgba(100,100,100,0.5)
		//change to:
		//rgba(100##comma##100##comma##100##comma##0.5)
		//will only do the change on commas inside of parentheses
		function replaceInnerComma(str){
			var pos=str.indexOf("(");
			while(pos>-1){
				var endPos=str.indexOf(")",pos+1);
				var newMiddle=str.substr(pos,endPos-pos).replace(/,/g,"##comma##");
				str=str.substr(0,pos)+newMiddle+str.substr(endPos);
				pos=str.indexOf("(",endPos+1);
			};
			return str;
		};
				
		//readCSS - main function to read css
		//@param: conts - chunk of css to read in
		//@param: prop - which function to look for
		//@param: path - path which to make the urls change to (false to disable)
		function readCss(conts,prop,path){
			var output={};
			//get rid of comments
			conts=conts.replace(/\/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+\//g,'');
			var pos=conts.indexOf(prop);
			//loop through all backgrounds in the stylesheet
			while(pos>-1){
				var bgVal=replaceWithLower($.trim(conts.substr(conts.indexOf(":",pos+1)+1,conts.indexOf(";",pos+1)-conts.indexOf(":",pos+1)-1)),"url(");
			
				//only do anything if there are actually multiple bgs in the property
				
				bgVal=replaceInnerComma(bgVal);
				if(bgVal.indexOf(",")>-1){
					
					
					//make paths relative to the stylesheet work out
					if(path){
						var urlPos=bgVal.indexOf("url(");
						while(urlPos>-1){
							//dont do any working on absolute urls
							if(bgVal.substr(urlPos+4,7).toLowerCase()!="http://"){
								var extraSlash=(bgVal.substr(urlPos+4,1) == '/');
								var domain=document.URL.substr(0,document.URL.indexOf('/',9));
								bgVal=bgVal.substr(0,urlPos+4)+(extraSlash ? domain :path)+bgVal.substr(urlPos+4);
							};
							//seek to next
							urlPos=bgVal.indexOf("url(",urlPos+1);
						};
					};
				
					//determine if there was an important in this bg value
					var important=bgVal.length;
					bgVal=bgVal.replace("!important","");
					important=(important==bgVal.length ? false : true);
					var prevBrace=conts.lastIndexOf("}",pos)+1;
					//Allow for charset 
					if(conts.lastIndexOf("}",pos)+1>prevBrace) prevBrace=conts.lastIndexOf("}",conts.lastIndexOf("{",pos))+1;
					
					if(prevBrace==-1) prevBrace=0;
					var selector = $.trim(conts.substr(prevBrace,conts.lastIndexOf("{",pos)-prevBrace));
					//account for multiple selectors
					var selSplit=selector.split(",");
					for(var i=0;i<selSplit.length;i++){
						var curSel=$.trim(selSplit[i]);
						curSel=replaceWithLower(curSel,":active");
						curSel=replaceWithLower(curSel,":hover");
						curSel=replaceWithLower(curSel,":focus");
						
					
						output[curSel]={property:prop,value:bgVal,selScore:selectorScore(curSel,important)};
					};
				};
			
			
				pos=conts.indexOf(prop,conts.indexOf(";",pos+1));
			};
			//put the contents into the storage
			$.extend(myCss,output);
		};
	
		//apply a specific background property to a selector
		function applyBg(selector,attr){
			$(selector).each(function(){
				var $element=$(this);
				$element.css("background","none");
			
				//check this current elements selector score against this score
				var curSelector=$element.attr("jQueryMultipleBgCurSelector");
				var newSelector=$element.attr(attr);

				$element.attr("jQueryMultipleBgCurSelector",newSelector);
				vals=myCss[newSelector].value.split(",");
				//fix any commas that may be in each val
				for(var i=vals.length-1;i>=0;i--){
					vals[i]=$.trim(vals[i].replace(/##comma##/g,","));
				};

				if(inArray(putLayerOutside,this.tagName.toLowerCase())){
					//these layers are going on the outside so it may be an input on ie!
					var curLayer=$element.parent();
					while(curLayer.parent().hasClass("add_background_outer")){
						curLayer=curLayer.parent();
					};
					for(var i=vals.length-1;i>=0;i--){
						if(!curLayer.hasClass("add_background_outer")){
							//not enough backgrounds! add more!
							$element.addLayer(vals[i],true);
						}else{
							//we still have backgrounds, let's use 'em
							curLayer.css('background',vals[i]);
							//jump into the next layer
							curLayer=$(curLayer.children()[0]);
						};
					};
					//are there any extra backgrounds?
					//if so, axe them!
					while(curLayer.hasClass("add_background_outer")){
						var saveLayer=curLayer;
						//jump into the next layer
						curLayer=$(curLayer.children()[0]);
						removeOuterLayer(saveLayer);
					};
				}else{
				
					//replacing current backgrounds
					var count=$element.find(".add_background").length;
					var curLayer=$($element.children(".add_background")[0]);
					for(var i=vals.length-1;i>=0;i--){
						if(curLayer.length<1){
							//not enough backgrounds! add more!
							$element.addLayer(vals[i],false);
						}else{
							//we still have backgrounds, let's use 'em
							curLayer.css('background',vals[i]);
							//jump into the next layer
							curLayer=$(curLayer.children(".add_background")[0]);
						};
					};
					//are there any extra backgrounds?
					//if so, axe them!
					while(curLayer.length){
						var saveLayer=curLayer;
						//jump into the next layer
						curLayer=$(curLayer.children(".add_background")[0]);
						removeLayer(saveLayer);
					};
				};
			});
		};
	
	
		//mouseover event for elements with hover multiple bgs
		function elementMouseover(e){
			if($(this).attr("jQueryMultipleBgCurSelector")!=$(this).attr("jQueryMultipleBgActiveSelector")){
				applyBg(this,"jQueryMultipleBgHoverSelector");
			};
		};
		//mouseout event for elements with hover multiple bgs
		function elementMouseout(e){
			applyBg(this,"jQueryMultipleBgStaticSelector");
		};
	
		//mousedown event for elements with active multiple bgs
		function elementMousedown(e){
			applyBg(this,"jQueryMultipleBgActiveSelector");
		};
		//mouseup event for elements with active multiple bgs
		function elementMouseup(e){
			if($(this).attr("jQueryMultipleBgHoverSelector")){
				applyBg(this,"jQueryMultipleBgHoverSelector");
			}else{
				applyBg(this,"jQueryMultipleBgStaticSelector");
			};
		};
	
		//focus event for elements with focus multiple bgs
		function elementFocus(e){
			applyBg(this,"jQueryMultipleBgFocusSelector");
		};
		//blur event for elements with focus multiple bgs
		function elementBlur(e){
			applyBg(this,"jQueryMultipleBgStaticSelector");
		};
		
		// Returns true if the passed value is found in the
		// array. Returns false if it is not.
		function inArray(myArray,value,caseSensitive) {
			var i;
			for (i=0; i < myArray.length; i++) {
				// use === to check for Matches. ie., identical (===),
				if(caseSensitive){ //performs match even the string is case sensitive
					if (myArray[i].toLowerCase() == value.toLowerCase()) {
						return true;
					};
				}else{
					if (myArray[i] == value) {
						return true;
					};
				};
			};
			return false;
		};
	
		//apply an array of css selectors with multiple backgrounds
		function applyCss(root){
			
			if(root==undefined) root=document;
			for(var sel in myCss){
				
				var lsel=sel.toLowerCase();
				if((lsel.indexOf(":hover")>-1)||(lsel.indexOf(":active")>-1)||(lsel.indexOf(":focus")>-1)){
					var leftSide, rightSide;
					if(lsel.indexOf(":hover")>-1){
						leftSide=sel.substr(0,lsel.indexOf(":hover"));
						rightSide=sel.substr(lsel.indexOf(":hover")+6);
						
						//set the reference selector on each element
						$(leftSide+rightSide,root).each(function(){
							var curSelector=$(this).attr("jQueryMultipleBgHoverSelector");
							//make sure the current selector still works
							if((curSelector)&&(!inArray($(replaceWithLower(curSelector,":hover").replace(/:hover/g,'')),this))) curSelector=undefined;
							if((!curSelector)||(myCss[curSelector].selScore<myCss[sel].selScore)){
								$(this).attr("jQueryMultipleBgHoverSelector",sel);
								if(!curSelector) $(this).hover(elementMouseover,elementMouseout);
							};
						});
					
					}else if(lsel.indexOf(":active")>-1){
						leftSide=sel.substr(0,lsel.indexOf(":active"));
						rightSide=sel.substr(lsel.indexOf(":active")+7);
					
						//set the reference selector on each element
						$(leftSide+rightSide,root).each(function(){
							var curSelector=$(this).attr("jQueryMultipleBgActiveSelector");
							//make sure the current selector still works
							if((curSelector)&&(!inArray($(replaceWithLower(curSelector,":active").replace(/:active/g,'')),this))) curSelector=undefined;
							if((!curSelector)||(myCss[curSelector].selScore<myCss[sel].selScore)){
								$(this).attr("jQueryMultipleBgActiveSelector",sel);
								if(!curSelector) $(this).mousedown(elementMousedown).mouseup(elementMouseup);
							};
						});
					}else if(lsel.indexOf(":focus")>-1){
						leftSide=sel.substr(0,lsel.indexOf(":focus"));
						rightSide=sel.substr(lsel.indexOf(":focus")+6);
					
						//set the reference selector on each element
						$(leftSide+rightSide,root).each(function(){
							var curSelector=$(this).attr("jQueryMultipleBgFocusSelector");
							//make sure the current selector still works
							if((curSelector)&&(!inArray($(replaceWithLower(curSelector,":focus").replace(/:focus/g,'')),this))) curSelector=undefined;
							if((!curSelector)||(myCss[curSelector].selScore<myCss[sel].selScore)){
								$(this).attr("jQueryMultipleBgFocusSelector",sel);
								if(!curSelector) $(this).focus(elementFocus).blur(elementBlur);
							};
						});
					}
				}else{
					//set the reference selector on each element
					$(sel,root).each(function(){
						var curSelector=$(this).attr("jQueryMultipleBgStaticSelector");
						//make sure the current selector still works
						if(!inArray($(curSelector),this)) curSelector=undefined;
						if((!curSelector)||(myCss[curSelector].selScore<myCss[sel].selScore)){
							$(this).attr("jQueryMultipleBgStaticSelector",sel);
							applyBg(this,"jQueryMultipleBgStaticSelector");
						};
					});
					
				};
			};
		};
	
		//put our functions in the jQuery object
		jQuery.fn.extend({
			multipleBgReadCss: readCss,
			multipleBgApplyCss: applyCss,
			multipleBgApplyBg: applyBg,
			multipleBgRules: myCss
		});

	
		//actually call the functions now
		//read style tags
		$("style").each(function(){
			var conts=$(this).html();
			readCss(conts,"background",false);
		});
		//read linked stylesheets
		$("link[rel=stylesheet]").each(function(){
			var href=$(this).attr("href");
			//dont load any stylesheets from other domains
			if(href.substr(0,7).toLowerCase()!="http://"){
				var path=href.slice(0, href.lastIndexOf("/") + 1);
				$.ajax({
					async: false,
					url: $(this).attr("href"),
					success: function(conts) {
						readCss(conts,"background",path);
						}
				});
			}
		});
	
		applyCss();
	
			
	}else{
		//give every other browser some dummy functions so there arent errors
		jQuery.fn.extend({
			multipleBgReadCss: function(conts,prop,path){return false;},
			multipleBgApplyCss: function(root){return false;},
			multipleBgApplyBg: function(selector,attr){return false},
			multipleBgRules: {}
		});
	};
		

});
	


