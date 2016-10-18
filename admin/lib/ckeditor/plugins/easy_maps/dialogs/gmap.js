CKEDITOR = self.parent.CKEDITOR || {config: {}}, self.parent.google = google;
mode = "";
var map_projection = null;


function initialize() {
    var d = document.getElementById("map-canvas"), b = (CKEDITOR.config.easy_maps_width || 400), o = (CKEDITOR.config.easy_maps_height || 320);
    var h = new google.maps.LatLng((CKEDITOR.config.easy_maps_default_x || -25.363882), (CKEDITOR.config.easy_maps_default_y || 131.044922));
    var g = {zoom: CKEDITOR.config.easy_maps_default_zoom || 4, center: h, disableDefaultUI: true, disableDoubleClickZoom: false, draggable: true, mapTypeControl: true, zoomControl: true, rotateControl: false, scaleControl: true, streetViewControl: false, panControl: false, overviewMapControl: false, draggableCursor: "move", mapTypeId: google.maps.MapTypeId.ROADMAP};
    document.getElementById("width").value = b;
    document.getElementById("height").value = o;
    document.getElementById("zoom").value = CKEDITOR.config.easy_maps_zoom || 4;
    map = new google.maps.Map(document.getElementById("map-canvas"), g);
    CKEDITOR.config.easy_maps_address && (new google.maps.Geocoder()).geocode({"address": CKEDITOR.config.easy_maps_address}, function(q, p) {
        if (p == google.maps.GeocoderStatus.OK) {
            map.setCenter(q[0].geometry.location);
            CKEDITOR.config.easy_maps_default_x = q[0].geometry.location.lan();
            CKEDITOR.config.easy_maps_default_y = q[0].geometry.location.lng();
        }
    });
    var i = '<div id="content" style="position:relative; z-index:999;">' + '<label>Text</label><div style="margin:5px;">' + '<textarea id="area1" rows="5" style="width:99%;resize: none;">{text}</textarea>' + "</div>" + "<div >" + '<input onclick="current_Matker&&current_Matker.setMap(null);delete objects.Marker[objects.Marker.indexOf(current_Matker)]; return false;" style="float:left;" type="button" value="Delete"/>' + '<input onclick="current_Matker&&current_Matker.setTitle(document.getElementById(\'area1\').value);infoWindow&&infoWindow.close();return false;" style="float:right;" type="button" value="OK"/>' + '<input onclick="infoWindow&&infoWindow.close();return false;" style="float:right;" type="button" value="Cancel"/>' + '<div style="clear:both;"></div>' + "</div>" + "</div>", c = '<div id="content" style="position:relative; z-index:999;">' + '<label>Text</label><div style="margin:5px;">' + '<textarea id="area2" rows="5" style="width:99%;resize: none;">{text}</textarea>' + "</div>" + "<div >" + '<input onclick="current_Matker&&current_Matker.setMap(null);delete objects.Text[objects.Text.indexOf(current_Matker)];  return false;" style="float:left;" type="button" value="Delete"/>' + '<input onclick="current_Matker&&current_Matker.set(\'labelContent\',document.getElementById(\'area2\').value);infoWindow&&infoWindow.close();return false;" style="float:right;" type="button" value="OK"/>' + '<input onclick="infoWindow&&infoWindow.close();return false;" style="float:right;" type="button" value="Cancel"/>' + '<div style="clear:both;"></div>' + "</div>" + "</div>";
    infoWindow = new google.maps.InfoWindow, current_Matker = 0;
    var l = function() {
        var p = this;
        current_Matker = p;
        var q = p.getPosition();
        infoWindow.setContent(i.replace("{text}", p.getTitle()));
        infoWindow.open(map, p);
    };
    var k = function() {
        var p = this;
        current_Matker = p;
        var q = p.getPosition();
        infoWindow.setContent(c.replace("{text}", p.get("labelContent")));
        infoWindow.open(map, p);
    };
    google.maps.event.addListener(map, "click", function() {
        infoWindow.close();
    });
    
    google.maps.event.addListenerOnce(map,"projection_changed", function() {
        map_projection = map.getProjection();
    });
    
    markers = [];
    var n = [document.createElement("div"), document.createElement("div"), document.createElement("div"), document.createElement("div"), ];
    for (var a in n) {
        n[a].style.position = "absolute";
        n[a].style.zIndex = 99;
        n[a].style.border = "1px solid #BB1111";
        if (a % 2) {
            n[a].style.width = "1px";
            n[a].style.height = o + "px";
            n[a].style.borderWidth = "0px 0px 0px 1px";
        } else {
            n[a].style.height = "1px";
            n[a].style.width = b + "px";
            n[a].style.borderWidth = "1px 0px 0px 0px";
        }
        document.getElementById("map-canvas").appendChild(n[a]);
    }
    $("#map-canvas").append($("#settings_overlay,#layers_overlay"));
    var setMapSize = function() {
        var q = document.getElementById("map-canvas").offsetWidth, s = document.getElementById("map-canvas").offsetHeight, p = Math.round(q / 2 - b / 2), u = Math.round(s / 2 - o / 2);
        for (var t in n) {
            switch (parseInt(t)) {
                case 0:
                    n[t].style.top = u + "px";
                    n[t].style.left = p + "px";
                    n[t].style.width = b + "px";
                    break;
                case 1:
                    n[t].style.top = u + "px";
                    n[t].style.left = p + "px";
                    n[t].style.height = o + "px";
                    break;
                case 2:
                    n[t].style.top = (o + u) + "px";
                    n[t].style.left = p + "px";
                    n[t].style.width = b + "px";
                    break;
                case 3:
                    n[t].style.left = (b + p) + "px";
                    n[t].style.top = u + "px";
                    n[t].style.height = o + "px";
                    break;
                }
        }
        document.getElementById("width").value = b;
        document.getElementById("height").value = o;
    };
    $(window).keyup(function(q) {
        if (q.which == 46) {
            if (mode != "addpointtocoord") {
                deleteObject(currentObject.type, objects[currentObject.type].indexOf(currentObject));
            } else {
                if (currentObject instanceof google.maps.Polyline) {
                    var p = currentObject.getPath();
                    p.pop();
                    if (p.length) {
                        currentObject.setPath(p);
                    } else {
                        deleteObject(currentObject.type, objects[currentObject.type].indexOf(currentObject));
                        mode = "Polyline";
                    }
                } else {
                    mode = "";
                }
            }
        }
        if (q.which == 27) {
            $(".overlay").fadeOut(500);
            $("#finish_path,#layers_overlay,#settings_overlay,.dummy").hide();
            $("#dialog_box").removeClass("shadow");
            mode = "";
            $(".object").removeClass("active");
        }
    });
    objects = {Marker: [], Circle: [], Polyline: [], Text: [], Polygon: [], Rectangle: [], TrafficLayer: [], WeatherLayer: [], };
    currentObject = 0;
    deleteObject = function(p, q) {
        q = isNaN(q) ? 0 : q;
        if (!objects[p].length) {
            return 0;
        }
        objects[p][q].setMap(null);
        delete objects[p][q];
        objects[p].splice(q, 1);
    };
    function wait_for_map_projection_load(B, x, u, map){
        if(map_projection == null){
            setTimeout(function(){ map_projection = map.getProjection(); wait_for_map_projection_load(B, x, u, map); }, 200);
        }else{

            var q = B.latLng || map.getCenter(), 
                    r = Math.pow(2, map.getZoom()),
                    p = map_projection.fromLatLngToPoint(q), 
                    w = 50, s = null, 
                    t = map_projection.fromPointToLatLng(new google.maps.Point(p.x - (w / 2) / r, p.y - (w / 2) / r)), 
                    z = map_projection.fromPointToLatLng(new google.maps.Point(p.x + (w / 2) / r, p.y - (w / 2) / r)), 
                    v = map_projection.fromPointToLatLng(new google.maps.Point(p.x + (w / 2) / r, p.y + (w / 2) / r)), 
                    y = map_projection.fromPointToLatLng(new google.maps.Point(p.x - (w / 2) / r, p.y + (w / 2) / r));
            switch (mode) {
                case"Marker":
                    s = new google.maps.Marker({position: q, map: map, draggable: true, title: x.text || "Hello World!"});
                    google.maps.event.addListener(s, "click", l);
                    !u && l.apply(s);
                    break;
                case"Rectangle":
                    s = new google.maps.Rectangle({bounds: x.bound || new google.maps.LatLngBounds(t, v), map: map, editable: true, draggable: true, });
                    break;
                case"Polyline":
                case"Polygon":
                    s = new google.maps[mode]({path: x.path || [q], map: map, editable: true, draggable: true, });
                    break;
                case"addpointtocoord":
                    if (currentObject instanceof google.maps.Polyline || currentObject instanceof google.maps.Polygon) {
                        var A = currentObject.getPath();
                        A.push(q);
                        currentObject.setPath(A);
                    } else {
                        mode = "";
                    }
                    break;
                case"Text":
                    s = new MarkerWithLabel({position: q, draggable: true, raiseOnDrag: true, map: map, labelContent: x.text || "Hello World!", labelAnchor: new google.maps.Point(22, 0), labelClass: "labels", labelStyle: {opacity: 1, minWidth: "200px", textAlign: "left"}, icon: {}});
                    google.maps.event.addListener(s, "click", k);
                    !u && k.apply(s);
                    break;
                case"Circle":
                    s = new google.maps.Circle({radius: x.radius || google.maps.geometry.spherical.computeDistanceBetween(t, v), center: q, map: map, editable: true, draggable: true, });
                    break;
                case"WeatherLayer":
                    deleteObject(mode);
                    s = new google.maps.weather.WeatherLayer({temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT, });
                    s.setMap(map);
                    break;
                case"TrafficLayer":
                    deleteObject(mode);
                    s = new google.maps.TrafficLayer();
                    s.setMap(map);
                    break;
            }
            if (s && mode != "addpointtocoord") {
                google.maps.event.addListener(s, "click", function() {
                    currentObject = this;
                });
                currentObject = s;
                s.type = mode;
                objects[s.type].push(s);
                if (!u) {
                    if (mode != "Polyline" && mode != "Polygon") {
                        $(".object").removeClass("active");
                        map.setOptions({draggableCursor: "move"});
                        mode = "";
                    } else {
                        mode = "addpointtocoord";
                        $("#finish_path").show();
                    }
                }
            }

            return false;
        }    
    }    
    clickAddObject = function(B, x, u) {
        x = x || {};
        //map_projection = map.getProjection();
        //console.dir(map_projection);
        
        wait_for_map_projection_load(B, x, u, map);

    };
    google.maps.event.addListener(map, "click", clickAddObject);
    $(".object").click(function() {
        $(".object:not(#" + this.id + ")").removeClass("active");
        $(this).toggleClass("active");
        if (mode = $(this).hasClass("active") ? this.id : "") {
            map.setOptions({draggableCursor: "crosshair"});
        } else {
            map.setOptions({draggableCursor: "move"});
        }
        $("#finish_path").hide();
    });
    var e = {"hybrid": "roadmap", "roadmap": "satellite", "satellite": "terrain", "terrain": "hybrid"};
    google.maps.event.addDomListener(document.getElementById("maptype"), "click", function() {
        map.setMapTypeId(e[map.getMapTypeId()]);
    });
    google.maps.event.addDomListener(map, "maptypeid_changed", function() {
        document.getElementById("maptype_img").src = "images/" + map.getMapTypeId() + ".png";
        var p = map.getMapTypeId();
        document.getElementById("maptype_title").innerHTML = p.charAt(0).toUpperCase() + p.slice(1);
    });
    google.maps.event.addDomListener(map, "zoom_changed", function() {
        document.getElementById("zoom").value = map.getZoom();
    });
    self.parent.triggerResize = function(p) {
        document.getElementById("map-canvas").style.height = p + "px";
        setMapSize();
    };
    google.maps.event.addDomListener(document.getElementById("zoom"), "change", function() {
        map.setZoom(parseInt(this.value));
    });
    google.maps.event.addDomListener(document.getElementById("zoom"), "keyup", function() {
        map.setZoom(parseInt(this.value));
    });
    google.maps.event.addDomListener(document.getElementById("width"), "change", function() {
        b = (parseInt(this.value));
        setMapSize();
    });
    google.maps.event.addDomListener(document.getElementById("height"), "change", function() {
        o = (parseInt(this.value));
        setMapSize();
    });
    google.maps.event.addDomListener(document.getElementById("width"), "keyup", function() {
        b = (parseInt(this.value));
        setMapSize();
    });
    google.maps.event.addDomListener(document.getElementById("height"), "keyup", function() {
        o = (parseInt(this.value));
        setMapSize();
    });
    var j = document.getElementById("target");
    var m = new google.maps.places.SearchBox(j);
    m.bindTo("bounds", map);
    google.maps.event.addListener(m, "places_changed", function() {
        if (CKEDITOR.config.easy_maps_auto_scaling_on_search === false) {
            return true;
        }
        try {
            var p = m.getPlaces()[0];
            if (p.geometry.viewport) {
                map.fitBounds(p.geometry.viewport);
            } else {
                map.setCenter(p.geometry.location);
                map.setZoom(17);
            }
        } catch (q) {
        }
    });
    google.maps.event.addListener(m, "places_changed", function() {
        var p = m.getPlaces();
        map.setCenter(p[0].geometry.location);
    });
    self.parent.loadMapFromJSON = function(x) {
        mode = "";
        $("#finish_path,#layers_overlay,#settings_overlay,.dummy").hide();
        $("#dialog_box").removeClass("shadow");
        $(".object").removeClass("active");
        document.getElementById("target").value = "";
        x.width && (b = x.width);
        x.height && (o = x.height);
        setMapSize();
        map.setCenter(new google.maps.LatLng(parseFloat(x.lat), parseFloat(x.lng)));
        map.setZoom(parseInt(x.zoom));
        map.setMapTypeId(x.type);
        $("#settings_overlay .layers").each(function() {
            map.set(this.id, x.settings[this.id] ? true : false);
        });
        for (var v in objects) {
            for (var u in objects[v]) {
                objects[v][u] && objects[v][u].setMap(null);
                delete objects[v][u];
            }
            objects[v] = [];
        }
        if (x.objects) {
            for (var v in x.objects) {
                for (var u in x.objects[v]) {
                    var q = new google.maps.LatLng(0, 0), w = {};
                    mode = v;
                    switch (v) {
                        case"Marker":
                            q = new google.maps.LatLng(x.objects[v][u][0], x.objects[v][u][1]);
                            w.text = x.objects[v][u][2];
                            break;
                        case"Circle":
                            q = new google.maps.LatLng(x.objects[v][u][0], x.objects[v][u][1]);
                            w.radius = x.objects[v][u][2];
                            break;
                        case"Text":
                            q = new google.maps.LatLng(x.objects[v][u][0], x.objects[v][u][1]);
                            w.text = x.objects[v][u][2];
                            break;
                        case"Rectangle":
                            w.bound = new google.maps.LatLngBounds(new google.maps.LatLng(x.objects[v][u][0][0], x.objects[v][u][0][1]), new google.maps.LatLng(x.objects[v][u][1][0], x.objects[v][u][1][1]));
                            break;
                        case"Polygon":
                        case"Polyline":
                            w.path = [];
                            var y = x.objects[v][u], r = [];
                            for (var t in y) {
                                r.push(new google.maps.LatLng(y[t][0], y[t][1]));
                            }
                            w.path = r;
                            break;
                        case"Polygon":
                            var y = x.objects[v][u], p = [], r = [];
                            for (var t in y) {
                                r = [];
                                for (var s in y[t]) {
                                    r.push(new google.maps.LatLng(y[t][s][0], y[t][s][1]));
                                }
                                p.puth(r);
                            }
                            w.paths = p;
                            break;
                    }
                    clickAddObject({latLng: q}, w, 1);
                }
            }
        }
        mode = "";
    };
    self.parent.generateCodeMap = function() {
        var w = {lat: map.getCenter().lat(), lng: map.getCenter().lng(), zoom: map.getZoom(), type: map.getMapTypeId(), width: b, height: o, settings: {}, objects: {Marker: [], Circle: [], Polyline: [], Text: [], Polygon: [], Rectangle: [], TrafficLayer: [], WeatherLayer: [], }, };
        $("#settings_overlay .layers").each(function() {
            w.settings[this.id] = map.get(this.id) ? 1 : 0;
        });
        for (var v in objects) {
            for (var t in objects[v]) {
                if (!objects[v][t]) {
                    continue;
                }
                switch (v) {
                    case"Marker":
                        w.objects[v].push([objects[v][t].getPosition().lat(), objects[v][t].getPosition().lng(), objects[v][t].getTitle()]);
                        break;
                    case"Circle":
                        w.objects[v].push([objects[v][t].getCenter().lat(), objects[v][t].getCenter().lng(), objects[v][t].getRadius()]);
                        break;
                    case"Text":
                        w.objects[v].push([objects[v][t].getPosition().lat(), objects[v][t].getPosition().lng(), objects[v][t].get("labelContent")]);
                        break;
                    case"Rectangle":
                        w.objects[v].push([[objects[v][t].getBounds().getSouthWest().lat(), objects[v][t].getBounds().getSouthWest().lng(), ], [objects[v][t].getBounds().getNorthEast().lat(), objects[v][t].getBounds().getNorthEast().lng(), ], ]);
                        break;
                    case"Polygon":
                    case"Polyline":
                        var x = objects[v][t].getPath().getArray(), q = [];
                        for (var s in x) {
                            q.push([x[s].lat(), x[s].lng()]);
                        }
                        w.objects[v].push(q);
                        break;
                    case"Polygon":
                        var x = objects[v][t].getPath().getArray(), p = [], q = [];
                        for (var s in x) {
                            q = [];
                            var u = x[s].getArray();
                            for (var r in u) {
                                q.push([u[r].lat(), u[r].lng()]);
                            }
                            p.push(q);
                        }
                        w.objects[v].push(p);
                        break;
                    case"TrafficLayer":
                    case"WeatherLayer":
                        w.objects[v].push(1);
                        break;
                    }
            }
        }
        return w;
    };
    window.setTimeout(setMapSize, 500);
}
google.maps.event.addDomListener(window, "load", initialize);