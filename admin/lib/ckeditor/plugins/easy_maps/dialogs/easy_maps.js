function wait_for_iframe(obj, editor){
    if(typeof(document.getElementById('cke_docProps_preview_iframe'))=='undefined'){
        setTimeout("wait_for_iframe()", 200);
    }else{
        iframe = document.getElementById('cke_docProps_preview_iframe');
        var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;        
        if(iframeDoc.readyState  == 'complete'){
            showMapDlg(obj, editor);
            return;
        }else{
            setTimeout(function(){ wait_for_iframe(obj, editor); }, 200);
        }
    }
}

function showMapDlg($this, editor){
    var selected_element = $this.getSelectedElement();
    if (selected_element && selected_element.is("img") && selected_element.$.className == "easy_maps_img") {
        $this.parts.title.$.innerHTML = editor.lang.easy_maps.edit;
                try {
            CKEDITOR.config.easy_maps_current = JSON.parse(decodeURIComponent(selected_element.$.getAttribute("data-map")));
                } catch (f) {
                    CKEDITOR.config.easy_maps_current = null;
                }
                CKEDITOR.config.easy_maps_current && loadMapFromJSON(CKEDITOR.config.easy_maps_current);
            } else {
                CKEDITOR.config.easy_maps_current = null;
        $this.parts.title.$.innerHTML = editor.lang.easy_maps.insert;
                try {
                    loadMapFromJSON({lat: CKEDITOR.config.easy_maps_default_x, lng: CKEDITOR.config.easy_maps_default_y, zoom: CKEDITOR.config.easy_maps_default_zoom, type: "roadmap", width: CKEDITOR.config.easy_maps_width, height: CKEDITOR.config.easy_maps_height, "settings": {"disableDefaultUI": 1, "disableDoubleClickZoom": 0, "draggable": 1, "mapTypeControl": 1, "zoomControl": 1, "rotateControl": 0, "scaleControl": 1, "streetViewControl": 1, "panControl": 0, "overviewMapControl": 0}});
                } catch (f) {
            console.dir(f);
                }
            }
}

CKEDITOR.dialog.add("easy_maps", function(editor) {
    return{
        title: "Easy Maps", 
        resizable: CKEDITOR.DIALOG_RESIZE_BOTH, 
        minHeight: 400, 
        contents: [
            {
                id: "preview", 
                label: "1111", 
                elements: [
                    {
                        type: "html", 
                        id: "previewHtml", 
                        html: '<iframe src="' + editor.path + "dialogs/easy_maps.html" + '" style="width: 100%; height: ' + 380 + 'px" hidefocus="true" frameborder="0" ' + 'id="cke_docProps_preview_iframe"></iframe>', 
                    }
                ]
            }
        ], 
        onShow: function() {

            var $this = this;
            wait_for_iframe($this, editor);
            
        }, onLoad: function() {
            this.on("resize", function(selected_element) {
                document.getElementById("cke_docProps_preview_iframe").style.height = selected_element.data.height + "px";
                triggerResize && triggerResize.call && triggerResize(selected_element.data.height - 60);
            });
        }, onOk: function() {
            var gnrtdimg = generateCodeMap();
            if(CKEDITOR.config.easy_maps_current){
                var selected_element = this.getSelectedElement();
                selected_element.setAttribute('data-map', encodeURIComponent(JSON.stringify(gnrtdimg)));
                selected_element.setAttribute('src', generateStatMap(gnrtdimg));
                selected_element.data("cke-saved-src",generateStatMap(gnrtdimg));
                //var img_map_html = '<img class="easy_maps_img" data-map="' + encodeURIComponent(JSON.stringify(gnrtdimg)) + '" contenteditable="false" src="' + generateStatMap(gnrtdimg) + '"/>';
                //selected_element.setHtml(img_map_html);
            }else{
                var b = '<figure class="easy_maps" contenteditable="false"><img class="easy_maps_img" data-map="' + encodeURIComponent(JSON.stringify(gnrtdimg)) + '" contenteditable="false" src="' + generateStatMap(gnrtdimg) + '"/></figure>';
                var c = CKEDITOR.dom.element.createFromHtml(b);
                editor.insertElement(c);
            }
        }};
});