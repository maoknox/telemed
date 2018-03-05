/**
 * Actividad v.1.6.2
 * Pseudo-Class to manage all the Actividad process
 * @changelog
 *      - 1.6.2: Se reduce la cantidad de consultas para el barrio
 *      - 1.6.1: Función lambda para retornar la dirección
 *      - 1.6.0: Se agrega notificaciones y búsqueda de barrios
 *      - 1.5.1: Se agrega la verificación de si un elemento existe
 * @param {object} params Object with the class parameters
 * @param {function} callback Function to return the results
 */
var Avl = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.count=0;
    self.idEntdev="";
    self.map="";
    self.puntoUbication="";
    self.popUp="";
    //DOM attributes
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        ajaxUrl:'../'
    };
   
    /**
     * Constructor Method 
     */
    var Avl = function() {
        self.div=$("#divAvl");
        setDefaults();
        
    }();
     
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Set defaults for Actividad
     * @returns {undefined}
     */
    function setDefaults(){
        dataTableAct=self.div.find("#dataTableAvl").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
        dataTableObject=self.div.find("#dataTableObject").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true,
            order: [[ 0, "desc" ]]
        });
        /*
         * 
         * @returns {undefined}
         */
        L.mapbox.accessToken = 'pk.eyJ1IjoibWFva25veCIsImEiOiJmcGJNR09jIn0.d8dHV-Ucm_dxJRbt50d1wA';
        var map = L.mapbox.map('map', 'mapbox.streets').setView([4.576092, -74.08157], 17);

        var featureGroup = L.featureGroup().addTo(map);

  // Define circle options
  // http://leafletjs.com/reference.html#circle
        var circle_options = {
            color: '#fff',      // Stroke color
            opacity: 1,         // Stroke opacity
            weight: 10,         // Stroke weight
            fillColor: '#000',  // Fill color
            fillOpacity: 0.6    // Fill opacity
        };

/*  var circle_one = L.circle([38.89415, -77.03738], 20, circle_options).addTo(featureGroup);
  var circle_two = L.circle([38.89415, -77.03578], 20, circle_options).addTo(featureGroup);
*/
  // Create array of lat,lon points
        var pointsArr=Array();

        var line_points = [[38.893596444352134, -77.0381498336792],
            [38.89337933372204, -77.03792452812195],
            [38.89316222242831, -77.03761339187622],
            [38.893028615148424, -77.03731298446655],
            [38.892920059048464, -77.03691601753235],
            [38.892903358095296, -77.03637957572937],
            [38.89301191422077, -77.03592896461487],
            [38.89316222242831, -77.03549981117249],
            [38.89340438498248, -77.03514575958252],
            [38.893596444352134, -77.0349633693695]];

            line_points.push([38.893596444352134, -77.0381498336792]);
            line_points.push([38.89316222242831, -77.03761339187622]);
            // Define polyline options
            // http://leafletjs.com/reference.html#polyline
            var polyline_options = {
                color: '#000'
            };

            // Defining a polygon here instead of a polyline will connect the
            // endpoints and fill the path.
            // http://leafletjs.com/reference.html#polygon
            var polyline = L.polyline(line_points, polyline_options).addTo(featureGroup);

            var drawControl = new L.Control.Draw({
              edit: {
                featureGroup: featureGroup
              }
            }).addTo(map);

            map.on('draw:created', function(e) {
                featureGroup.addLayer(e.layer).bindPopup("bla");
                    var shapes = self.getShapes(featureGroup);
                    var shape = e.layer.toGeoJSON();
                    var shape_for_db = JSON.stringify(shape);
                    console.log(shape_for_db);
                    $("#the_geom").val(shape_for_db);
            });
            
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.getShapes = function(drawnItems) {
        var shapes = [];
        drawnItems.eachLayer(function(layer) {

            // Note: Rectangle extends Polygon. Polygon extends Polyline.
            // Therefore, all of them are instances of Polyline
            if (layer instanceof L.Polyline) {
                shapes.push(layer.getLatLngs());
            }

            if (layer instanceof L.Circle) {
                shapes.push([layer.getLatLng()]);
            }

            if (layer instanceof L.Marker) {
                shapes.push([layer.getLatLng()]);
            }

        });
        return shapes;
    };
    
    
    self.searchDataAvl= function(){
        setTimeout("Avl.searchDataAvlWs()", 5000);
    };
    self.iniMap=function(latitude,longitude,time){
        self.map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFva25veCIsImEiOiJmcGJNR09jIn0.d8dHV-Ucm_dxJRbt50d1wA', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.streets'
        }).addTo(self.map);
        var fecha = new Date();
        var mes = fecha.getMonth()+1;
        self.puntoUbication=L.marker([latitude, longitude]);
        self.puntoUbication.addTo(self.map).bindPopup("<b>Fecha - Hora: "+time +"</b><br />Posición actual.").openPopup();
        self.popUp=L.popup();
        self.map.on('click', self.onMapClick);
        self.searchUbication();
    };
    self.searchUbication=function(){
        setTimeout('Avl.createPoint()',5000);
    };
    self.onMapClick=function(e){
        self.popUp.setLatLng(e.latlng)
            .setContent("Longitud y latitud en la cual hizo click " + e.latlng.toString())
            .openOn(self.map);
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    self.createPoint=function(){
        $.ajax({
            url: "showPoint",
            dataType:'json',
            type:'post',
            data: {"idEntDev":self.idEntdev},
            success: function(response) {
                if(response.status=="nosession"){
                    $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                    setTimeout(function(){document.location.href="site/login";}, 3000);
                    return;
                }
                else{
                    self.map.setView([response.latitude, response.longitude], 13);
                    punto=[response.latitude, response.longitude];
                    self.map.removeLayer(self.puntoUbication);	
                    self.puntoUbication=L.marker(punto);
                    self.puntoUbication.addTo(self.map).bindPopup("<b>Fecha - Hora: "+response.time+" </b><br />Última posición.");//.openPopup();
                    self.map.panTo(new L.LatLng(response.latitude, response.longitude));
                    self.popUp=L.popup();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError);
           }
        });
        self.searchUbication();
    };
    self.searchDataAvlWs=function(){
    /**
     * Consume webservice registerDevice registrar dispositivo
     */
    
        var msg="";
        var typeMsg="";
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchDataAvl',
            data:{"identdev":self.idEntdev}
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    
                    self.loadDataAvl(response.data);
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    
                }
            }
        });
        self.searchDataAvl();
    };
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    /*
    * Carga datos de dispositivo seleccionado al datatable
    * @param array data
    * @returns N.A
    */ 
    self.loadDataAvl=function(data){
        self.arrayDevice=data;
            dataTableObject.clear();
            $.each(data,function(key,value){
                var row=[];
                row.push(value.time);
                $.each(value.data,function(keyi,valuei){
                    row.push(valuei);
                });
                dataTableObject.row.add(row).draw();
            });
            
    };
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.Avl=new Avl();
});