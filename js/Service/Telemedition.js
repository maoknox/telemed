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
var Telemedition = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.count=0;
    self.idEntdev="";
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
    var Telemedition = function() {
        self.div=$("#divTelemed");
        self.divi=$("#divhisttl");
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
       
        dataTableAct=self.div.find("#dataTableTelemed").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
        dataTableObject=self.div.find("#dataTableObject").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true,
            order: [[ 0, "desc" ]]
        });
        dataTableRepHist=self.divi.find("#dataTableTelemedHist").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true,
            order: [[ 0, "desc" ]]
        });
       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.searchDataTelemed= function(){
        setTimeout("Telemedition.searchDataTelemedWs()", 5000);
    };
    self.iniMap=function(ubications){
        var latlongs=[];
        $.each(ubications,function(key,value){
            latlongs.push([value.lat, value.long]);
        });
        L.Map = L.Map.extend({
            openPopup: function(popup) {
                this._popup = popup;
                return this.addLayer(popup).fire('popupopen', {
                    popup: this._popup
                });
            }
        });
        self.map = L.map('map').setView([latlongs[0][0], latlongs[0][1]],20);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFva25veCIsImEiOiJmcGJNR09jIn0.d8dHV-Ucm_dxJRbt50d1wA', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.streets'
        }).addTo(self.map);
        var markers=[];
//        fruits.push("Kiwi"); 
        $.each(ubications,function(key,value){
            self.puntoUbication=L.marker([value.lat, value.long]);
            self.puntoUbication.bindPopup("<b>Nombre del objeto: "+value.nameobj);
            self.puntoUbication.on("click",function(){
                $.redirect("showDataObjectTelemed",{
                  id_entdev: value.id_entdev 
                },"POST");
            });
            markers.push(self.puntoUbication);
            self.puntoUbication.on('mouseover', function (e) {
                this.openPopup();
            });
            self.puntoUbication.on('mouseout', function (e) {
                this.closePopup();
            });
        });
        
        var markerGroup = L.featureGroup(markers).addTo(self.map);
        markerGroup.eachLayer(function(layer) {
          layer.openPopup();
        });
        var bounds = new L.LatLngBounds(latlongs);
        self.map.fitBounds(bounds);
//
//        self.popUp=L.popup();
//        self.map.on('click', self.onMapClick);
    };
    self.onMapClick=function(e){
        self.popUp.setLatLng(e.latlng)
            .setContent("Longitud y latitud en la cual hizo click " + e.latlng.toString())
            .openOn(self.map);
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
     /*
    * 
    * @type String
    */
    self.anchorage=function(identdev){
        var anchor=self.div.find("#"+identdev).val();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'objectAnchor',
            data:{"Anchorage[identdev]":identdev,"Anchorage[anchor]":anchor}
        }).done(function(response) {
            var msg="";
            var typeMsg="";
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    if(anchor==1){
                        anchor=2;
                        msg="Objeto anclado del inicio";
                    }
                    else{
                        anchor=1;
                        msg="Objeto desanclado del inicio";
                    }
                    self.div.find("#"+identdev).val(anchor);
                    typeMsg="success";
                }
                else{
                    if(response.status=="noexito"){
                         msg="error al anclar/desanclar el objeto al inicio";
                        typeMsg="warn";
                    }
                    
                }
                $.notify(msg, typeMsg);
            }
        });
        
        
        self.div.find("#"+identdev).val(anchor);
    };
    self.searchDataTelemedWs=function(){
    /**
     * Consume webservice registerDevice registrar dispositivo
     */
    
        var msg="";
        var typeMsg="";
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchDataTelemed',
            data:{"identdev":self.idEntdev}
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    
                    self.loadDataTelemedToDivs(response.data);
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    
                }
            }
        });
        self.searchDataTelemed();
    };
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    /*
    * Carga datos de dispositivo seleccionado al datatable
    * @param array data
    * @returns N.A
    */ 
    self.loadDataTelemed=function(data){
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
    
    self.loadDataTelemedToDivs=function(data){
        self.div.find("#timelecture").text(data.time);
        $.each(data.data,function(key,value){
            var id="gr"+key;
            var gaugeAux=document.gauges.get(id);
            gaugeAux.value=value;
            self.div.find("#magnitude"+key).text(value);
        });
    };
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.Telemedition=new Telemedition();
});