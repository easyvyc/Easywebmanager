var isIE = false;

var req;

function ajaxObj(){

}

ajaxObj.prototype.data = new Object();

function func(){}


ajaxObj.prototype.xmlFunc = new function(){};

ajaxObj.prototype.loadXMLDoc = function loadXMLDoc(url) {
	 
	 this.startAjax();
	 
	 if (window.XMLHttpRequest) {
	     req = new XMLHttpRequest();
	     req.onreadystatechange = this.processReqChange;
	     req.open("GET", url, true);
	     req.send(null);
	 } else if (window.ActiveXObject) {
	     isIE = true;
	     req = new ActiveXObject("Microsoft.XMLHTTP");
	     if (req) {
	         req.onreadystatechange = this.processReqChange;
	         //alert(req.onreadystatechange);
	         req.open("GET", url, true);
	         req.send();
	     }
	 }
	 
	 //this.endAjax();
	 
}

ajaxObj.prototype.processReqChange = function processReqChange() {
	 if (req.readyState == 4) {
	     if (req.status == 200) {
	     	
	     	//this.xmlFunc(startSaxParser(req.responseText));
	     	xmlFunc(startSaxParser(req.responseText));
	     	closeLoading();

	      } else {
	         top.content.showSystemMessage(0);
	         //alert("There was a problem retrieving the XML data:\n" + req.statusText);
	      }
	 }
}

ajaxObj.prototype.loadDoc = function loadDoc(url) {
//    evt = (evt) ? evt : ((window.event) ? window.event : null);
//	if (evt) {
//	    var elem = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
//	    if (elem) {
	        try {
	        	 //alert(url);
	             this.loadXMLDoc(url);
		 	} catch(e) {
	             var msg = (typeof e == "string") ? e : ((e.message) ? e.message : "Unknown Error");
	             top.content.showSystemMessage(0);
	             //alert("Klaida. Negalima užkrauti duomenų iš serverio.\n"/* + msg + " - " + elem.selectedIndex*/);
	             return;
	        }
//	    }
// 	}
}

ajaxObj.prototype.XML2JS = function XML2JS(containerTag) {
    this.data = startSaxParser(this.responseAsString);
    this.xmlFunc(this.data);
}

ajaxObj.prototype.startAjax = function startAjax() {

	openLoading();

	//top.location.href = "http://www.one.lt";
	//parent.frames['modules'].className = "trans";
	
}

ajaxObj.prototype.endAjax = function endAjax() {

	closeLoading();
	//window.frames['parent'].className = "";
	
}