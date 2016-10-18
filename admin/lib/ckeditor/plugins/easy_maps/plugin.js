CKEDITOR.plugins.add("easy_maps", 
        {
            icons: "easy_maps", 
            lang: 'lt,en',
            init: function(editor) {
                
        CKEDITOR.config.easy_maps_width = editor.config.easy_maps_width || 400;
        CKEDITOR.config.easy_maps_height = editor.config.easy_maps_height || 320;
        CKEDITOR.config.easy_maps_default_x = editor.config.easy_maps_default_x || -25.363882;
        CKEDITOR.config.easy_maps_default_y = editor.config.easy_maps_default_y || 131.044922;
        CKEDITOR.config.easy_maps_default_zoom = editor.config.easy_maps_default_zoom || 4;
        CKEDITOR.config.easy_maps_auto_scaling_on_search = editor.config.easy_maps_auto_scaling_on_search || true;
        editor.path = this.path;
        CKEDITOR.dialog.add("easy_maps", this.path + "dialogs/easy_maps.js");
        cmd = editor.addCommand("easy_maps", new CKEDITOR.dialogCommand("easy_maps"));
        editor.ui.addButton("easy_maps", {label: editor.lang.easy_maps.menu, command: "easy_maps"});
        if (editor.contextMenu) {
            editor.addMenuGroup("easy_maps_group");
            editor.addMenuItem("easy_maps_item", {label: editor.lang.easy_maps.edit, command: "easy_maps", icon: this.path + "icons/easy_maps.png", group: "easy_maps_group"});
            editor.contextMenu.addListener(function(i, q) {
                if (i && i.is("img") && i.$.className == "easy_maps_img") {
                    return{easy_maps_item: CKEDITOR.TRISTATE_OFF};
                }
            });
        }
        generateStatMap = function(i) {
            return"http://maps.google.com/maps/api/staticmap?center=" + i.lat + "," + i.lng + "&zoom=" + i.zoom + "&size=" + i.width + "x" + i.height + "&maptype=" + i.type + "&markers=" + (function(u) {
                var r = [];
                for (var q in u) {
                    r.push(u[q][0] + "," + u[q][1]);
                }
                return r.join("|");
            })(i.objects.Marker) + "&sensor=false";
        };
        editor.on("doubleclick", function(i) {
            var q = i.data.element;
            if (q && q.is("img") && q.$.className == "easy_maps_img") {
                i.data.dialog = "easy_maps";
            }
        });
        var g = 1, k = "", n = 0;
        var valueToDataFormat = function(i) {
            return i.replace(/<figure([^>]*class[\s]*=[\s]*"easy_maps"[^>]*)><img[^>]+?class[\s]*=[\s]*"easy_maps_img"[\s]*\/><\/figure>/g, function(figure_attr, r) {
                return '<figure'+figure_attr+'></figure>';
            });
        };
        var figure_search_data_map = function(str) {
            var startpos = str.indexOf("data-map=\"") + 10;
            var endpos = str.indexOf("\"", startpos + 1);
            return str.substring(startpos, endpos);
            //return str.replace(/^loadmap\("easy_maps[0-9]+",/, "").replace(/\);$/, "");
        };
        var valueToHtml = function(q, i) {
            return q.replace(/<figure([^>]*class[\s]*=[\s]*"easy_maps"[^>]*)>([^<]+)<\/figure>/gi, function(figure_tag, figure_attr, figure_content) {
                var r = "", data_map = figure_search_data_map(figure_content);
                try {
                    r = '<figure'+figure_attr+'><img class="easy_maps_img" data-map="' + data_map + '" contenteditable="false" src="' + generateStatMap(JSON.parse(decodeURIComponent(data_map))) + '"/></figure>';
                } catch (v) {
                    r = figure_tag;
                }
                return r;
            });
        };
        editor.on("toDataFormat", function(i) {
            k = "";
            var q = valueToDataFormat(i.data.dataValue);
            i.data.dataValue = (n ? k : "") + q;
        }, null, null, 16);
        editor.on("toHtml", function(i) {
            i.data.dataValue = valueToHtml(i.data.dataValue);
        }, null, null, 1);
    }, });
CKEDITOR.config.easy_maps_width = CKEDITOR.config.easy_maps_width || 400;
CKEDITOR.config.easy_maps_height = CKEDITOR.config.easy_maps_height || 320;