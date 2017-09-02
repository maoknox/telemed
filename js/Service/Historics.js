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
var Historics = function(){
    
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
    var Historics = function() {
        self.div=$("#divhisttl");
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
        dataTableRepHist=self.div.find("#dataTableTelemedHist").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true,
            order: [[ 0, "desc" ]],
            "bDestroy": true
        });
       self.div.find("#formularioRep").validate({
            rules: {
                "ConsRep[fecha_inicial]":"required",
                "ConsRep[fecha_final]":"required",
                "ConsRep[id_entdev]":"required"
            },
            messages: {
                "ConsRep[fecha_inicial]":"Debe seleccionar una fecha inicial",
                "ConsRep[fecha_final]":"Debe seleccionar una fecha final",
                "ConsRep[id_entdev]":"No ha asociado un id de dispositivo"
            }
        });
        self.div.find('#fechaInicialRepo').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
        self.div.find('#fechaFinalRepo').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    /*
     * 
     * @param {type} identdev
     */
    self.showHistoricRepo=function(identdev){
        if (self.div.find("#formularioRep").valid()) {
//            self.showHistoric();
            self.loadPartDatatable();
//            console.log(identdev);
        }
    };
        
        
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /*
     * 
     * @returns {undefined}
     */
    self.loadPartDatatable=function(){
        var params=self.div.find("#formularioRep").serialize();
//        self.div.find("#dataTableTelemedHist").DataTable();
        dataTableRepHist=self.div.find("#dataTableTelemedHist").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"showHistoricTelemedPart", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                data: {
                    "params[identdev]": $("#id_entdev").val(),
                    "params[fechaini]":$("#fechaInicialRepo").val(),
                    "params[fechafin]":$("#fechaFinalRepo").val()
                },
                error: function(){
                    console.debug("error");
                }
            },
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true,
            "bDestroy": true
        });  
    };
    
    
    
    /**
     * Consume webservice createEntityDevice para registrar dispositivo en formulario 2
     */
    self.showHistoric=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#formularioRep").serialize();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'showHistoricTelemed',
            data:dataEntity,
//            async:false
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg=response.msg;
                    typeMsg="success";
//                    console.log(JSON.stringify(response.data));
                    self.div.find("#dataTableTelemedHist").DataTable().clear().draw();
                    $.each(response.data,function(key,value){
//                        console.log(value);
                        var fruits=[];
                        $.each(value,function(keyi,valuei){
                            fruits[keyi]=valuei;
//                            self.div.find("#dataTableTelemedHist").DataTable().row.add(fruits[keyi]).draw();
                        });
                        self.div.find("#dataTableTelemedHist").DataTable().row.add(fruits).draw();
//                        console.log(fruits);
//                        $.each(fruits,function(keyii,fruit){
//                            self.div.find("#dataTableTelemedHist").DataTable().row.add(fruit).draw();
//                        });
//                        
                    });
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    } 
                }
            }
        }).fail(function(error, textStatus, xhr) {
//            msg="Error, el código del error es: "+error.status+" "+xhr;
//            typeMsg="error"; 
            
        });
    };
   
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
   
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.Historics=new Historics();
});