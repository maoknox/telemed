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
var DataForAnch = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
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
    var DataForAnch = function() {
        self.div=$("#sectionIndex");
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
        
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
        
       
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    self.searchdataServices=function(){
        console.log( localStorage.getItem("lastname"));
       $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchservices',
            data: {"status": true },
             beforeSend: function(xhr) {
                xhr.setRequestHeader("oauthtoken", localStorage.getItem("lastname"));
              }
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                $.each(response,function(key,value){
                    if(value.anchorage==1){
                        $.each(value.objects,function(keyi,valuei){
                            if(valuei.data!="null"){
                                self.bindData(valuei);
                            }
                        });
                    }
                });
                
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al registrar los datos de la persona, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        }).always(function(){
            setTimeout("DataForAnch.searchdataServices()",5000);
        });
    };
        
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    self.bindData=function(object){
        self.div.find("#fechaMed"+object.id_entdev).text(object.time);
//        self.div.find("#service"+object.id_entdev+" #dataTableObject"+object.id_entdev+" #DIRW").text("0");
//        console.log(object.data[1-1]);
        $.each(object.positions,function(keyii,valueii){
//            console.log(valueii);
            self.div.find("#service"+object.id_entdev+" #dataTableObject"+object.id_entdev+" #"+valueii.magnitude_code).text(object.data[valueii.position_dataframe-1]);
        });
    };
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    window.DataForAnch=new DataForAnch();
//    if(DataForAnch.div.find(".TELEMEDICION").val()==1){
//         var tid = setInterval(function(){
            //called 5 times each time after one second  
          //before getting cleared by below timeout. 
            setTimeout("DataForAnch.searchdataServices()",5000);
//        },5000); 
//    }
});