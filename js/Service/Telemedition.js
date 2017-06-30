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
       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.searchDataTelemed= function(){
        setTimeout("Telemedition.searchDataTelemedWs()", 5000);
    };
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
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
                    
                    self.loadDataTelemed(response.data);
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al crear el dispositivo, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
            self.div.find("#btnRegDevice").show();
        }).always(function(){
            self.div.find("#btnRegDevice").show();
            $.notify(msg, typeMsg);
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
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.Telemedition=new Telemedition();
});