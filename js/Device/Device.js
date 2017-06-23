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
var Device = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.arrayDevice=[];
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
    var Device = function() {
        self.div=$("#divDevice");
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
        //Inicializa datatable
        dataTableAct=self.div.find("#dataTableDevice").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
        
        self.div.find("#device-form").change(function (){
            estadoGuarda=false;
        });
        self.div.find("#btnRegDevice").click(function(){
            self.registerDevice();
        });
        self.div.find("#btnEditaDevice").hide();
        self.div.find("#btnCancelaEdicion").hide();
        
        self.div.find("#btnEditaDevice").click(function(){
            self.editDevice();
        });
        self.div.find("#btnCancelaEdicion").click(function (){
            self.cancelEdition();
        });
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    /**
     * Carga datos del Dispositivo seleccionado en el formulario para editar
     */
    self.cargaDeviceAForm=function(idDevice){
        self.div.find("#btnRegDevice").css("display","none");
        self.div.find("#btnEditaDevice").css("display","block");
        self.div.find("#btnCancelaEdicion").css("display","block");
        self.div.find("#device-form #Device_id_device").attr("readonly",true);
        $.each(self.arrayDevice,function(key,value){
            if(value.id_device==idDevice){
                self.div.find("#device-form #Device_id_device").val(value.id_device);
                self.div.find("#device-form #Device_device_name").val(value.device_name);
                self.div.find("#device-form #Device_id_type_device").val(value.id_type_device);
                self.div.find("#device-form #Device_id_statedevice").val(value.id_statedevice);
                var servicesArr=[];
                $.each(value.services,function(pk,val){
                    servicesArr[pk]=val.id_service;
                });
                self.div.find("#device-form #ServiceDevice_id_service").val(servicesArr);
                
            }
        });
    }; 
    /**
     * Cancela edición y limpia formulario
     */
    self.cancelEdition=function(){
        self.div.find("#btnRegDevice").css("display","block");
        self.div.find("#btnEditaDevice").css("display","none");
        self.div.find("#btnCancelaEdicion").css("display","none");
        self.div.find("#device-form").trigger("reset");
        self.div.find("#device-form #Device_id_device").attr("readonly",false);
    };
    
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    
   
    /**
     * Consume webservice registerDevice registrar dispositivo
     */
    self.registerDevice=function(){
        var msg="";
        var typeMsg="";
        var dataDevice=self.div.find("#device-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerDevice',
            data:dataDevice,
            beforeSend: function() {
                self.div.find("#device-form #device-form_es_").html("");                                                    
		self.div.find("#device-form #device-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegDevice").hide();
            }
//            async:false
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Dispositivo registrado satisfactoriamente";
                    typeMsg="success";
                    self.div.find("#device-form").trigger("reset");
                    estadoGuarda=true;
                    self.loadDataDevice(response.data);
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    else{
                        msg="Revise la validación del formuario";
                        typeMsg="warn";
                        var errores="Revise lo siguiente<br/><ul>";
                        $.each(response, function(key, val) {
                            errores+="<li>"+val+"</li>";
                            $("#device-form #"+key+"_em_").text(val);                                                    
                            $("#device-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#device-form #device-form_es_").html(errores);                                                    
                        self.div.find("#device-form #device-form_es_").show(); 
                        self.div.find("#btnRegDevice").show();
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
         
    };
    /**
     * Consume webservice registerDevice registrar dispositivo
     */
    self.editDevice=function(){
        var msg="";
        var typeMsg="";
        var dataDevice=self.div.find("#device-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'editDevice',
            data:dataDevice,
            beforeSend: function() {
                self.div.find("#device-form #device-form_es_").html("");                                                    
		self.div.find("#device-form #device-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
            }
//            async:false
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Dispositivo editado satisfactoriamente";
                    typeMsg="success";
                    self.cancelEdition();
                    estadoGuarda=true;
                    self.loadDataDevice(response.data);
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    else{
                        msg="Revise la validación del formuario";
                        typeMsg="warn";
                        var errores="Revise lo siguiente<br/><ul>";
                        $.each(response, function(key, val) {
                            errores+="<li>"+val+"</li>";
                            $("#device-form #"+key+"_em_").text(val);                                                    
                            $("#device-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#device-form #device-form_es_").html(errores);                                                    
                        self.div.find("#device-form #device-form_es_").show(); 
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al editar el dispositivo, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        }).always(function(){
            $.notify(msg, typeMsg);
        });
         
    };

   /*
    * Carga datos de dispositivo seleccionado al datatable
    * @param array data
    * @returns N.A
    */ 
    self.loadDataDevice=function(data){
        self.arrayDevice=data;
            dataTableAct.clear();
            $.each(data,function(key,value){
                dataTableAct.row.add([
                    value.id_device,
                    value.devicetype_label,
                    value.device_name,
                    value.statedevice_label,
                    "<a href=javascript:Device.cargaDeviceAForm('"+value.id_device+"');>Editar</a>"
                ]).draw();
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
    window.Device=new Device();
});