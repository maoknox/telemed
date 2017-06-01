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
var Entitydevice = function(){
    
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
    var Entitydevice = function() {
        self.div=$("#divEntityDevice");
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
       self.div.find("#dataTableEntityMagnitude").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
        self.div.find("#btnRegEntityDevice").click(function (){
            self.registerEntityDevice();
        });
        self.div.find("#btnRegMagnitude").click(function (){
            self.registerMagnitude();
        });
        self.div.find("#nameEntity").keyup(function(){
            if(self.div.find("#nameEntity").val().length==0){
                self.div.find("#entitydevice-form #EntityDevice_id_entity").val("");
                self.div.find("#EntityDevice_id_service").html("<option value=''>Seleccione otra empresa</option>");
                self.div.find("#EntityDevice_id_device").html("<option value=''>Seleccione Servicio</option>");
                
            }
        });
        self.div.find("#EntityDevice_id_service").change(function (){
            if(self.div.find("#entitydevice-form #EntityDevice_id_service").val()==0){
                self.div.find("#EntityDevice_id_device").html("<option value=''>Seleccione Servicio</option>");
            }
            else{
                self.searchDevice(self.div.find("#entitydevice-form #EntityDevice_id_service").val());
            }
        });
        self.div.find("#entitydevice-form").keyup(function (){
            estadoGuarda=false;
        });
        self.div.find("#entitydevice-form").change(function (){
            estadoGuarda=false;
        });
        self.div.find("#magnitude-form").keyup(function (){
            estadoGuarda=false;
        });
        self.div.find("#magnitude-form").change(function (){
            estadoGuarda=false;
        });
        
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Busca dispositivos por tipo de servicio
     */
    self.searchDevice=function(idService){ 
        var msg="";
        var typeMsg;
        console.log(idService);
        self.div.find("#entitydevice-form #EntityDevice_id_device").html("");;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchDevice',
            data:{idService:idService}
        }).done(function(response) {
            if(response.length>0){
                self.div.find("#EntityDevice_id_device").append("<option value=''>Seleccione un dispositivo</option>");
                $.each(response,function(key, value){
                    self.div.find("#EntityDevice_id_device").append("<option value='"+value.id_device+"'>"+value.id_device+"</option>");
                });
            }
            else{
                $.notify("No hay dispositovos libres o registrados para este servicio", "warn");
                self.div.find("#EntityDevice_id_device").html("<option value=''>Seleccione otra empresa</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los servicios, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    /**
     * Filtra por texto digitado las empresas creadas
     */
    self.filtraEntity=function(){
        self.div.find("#entitydevice-form #nameEntity").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"../person/searchEntity",
                    data: {stringentity:self.div.find("#entitydevice-form #nameEntity").val()},
                    beforeSend:function (){
                        self.div.find("#entitydevice-form #EntityDevice_id_entity").val("");
                    },
                    success: response,
                    error: function(jqXHR, textStatus, errorThrown){
                        $.notify("Error en la consulta de empresas", "error");
                    },
                    dataType: 'json',
                    minLength: 1,
                    delay: 100
                });
            },
            minLength: 1,
            select: function(event, ui) {
                if(ui.item.id!="#"){
                    self.div.find("#entitydevice-form #EntityDevice_id_entity").val(ui.item.id);
                    self.consultaServicios(ui.item.id);
                }
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });
    };
    /**
     * Consume webservice de consulta de servicios relacionados a empresa
     */
    self.consultaServicios=function(idEntity){ 
        var msg="";
        var typeMsg;
        self.div.find("#EntityDevice_id_service").html("");
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchService',
            data:{idEntity:idEntity}
        }).done(function(response) {
            if(response.length>0){
                self.div.find("#EntityDevice_id_service").append("<option value=''>Seleccione un servicio</option>");
                $.each(response,function(key, value){
                    self.div.find("#EntityDevice_id_service").append("<option value='"+value.id_service+"'>"+value.service_name+"</option>");
                });
            }
            else{
                $.notify("No hay servicios registrados para esta empresa", "warn");
                self.div.find("#EntityDevice_id_service").html("<option value=''>Seleccione otra empresa</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los servicios, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    /**
     * Consume webservice createEntityDevice para registrar dispositivo
     */
    self.registerMagnitude=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#magnitude-form").serialize();
//        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerMagnitude',
            data:dataEntity,
            beforeSend: function() {
                self.div.find("#magnitude-form #magnitude-form_es_").html("");                                                    
		self.div.find("#magnitude-form #magnitude-form_es_").hide();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").hide();
                self.div.find("#btnRegMagnitude").hide();
            }
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
                    self.div.find("#magnitude-form").trigger("reset");  
                    self.div.find("#magnitude-form #EntityService_id_entity").val("");  
                    estadoGuarda=true;
                    self.div.find("#dataTableEntityMagnitude").DataTable().clear();
                    $.each(response.data,function(key,value){
                    self.div.find("#dataTableEntityMagnitude").DataTable().row.add([
                        value.position_dataframe,
                        value.magnitude_name,
                        value.meassystem_spanish,
                        value.min_magnitude,
                        value.max_magnitude
                    ]).draw();
                    self.div.find("#btnRegMagnitude").show();
            });
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
                            $("#magnitude-form #"+key+"_em_").text(val);                                                    
                            $("#magnitude-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#magnitude-form #magnitude-form_es_").html(errores);                                                    
                        self.div.find("#magnitude-form #magnitude-form_es_").show(); 
                    }  
                    self.div.find("#btnRegMagnitude").show(); 
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al asociar la magnitud, el código del error es: "+error.status+" "+xhr;
            typeMsg="error"; 
            self.div.find("#btnRegMagnitude").show();
        }).always(function(){
            $.notify(msg, typeMsg);
        });
    };
    
    
    /**
     * Consume webservice createEntityDevice para registrar dispositivo
     */
    self.registerEntityDevice=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#entitydevice-form").serialize();
//        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerObjectDevice',
            data:dataEntity,
            beforeSend: function() {
                self.div.find("#entitydevice-form #entitydevice-form_es_").html("");                                                    
		self.div.find("#entitydevice-form #entitydevice-form_es_").hide();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").hide();
                self.div.find("#btnRegEntityDevice").hide();
            }
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
                    self.div.find("#entitydevice-form").trigger("reset");  
                    self.div.find("#entitydevice-form #EntityService_id_entity").val(""); 
                    self.div.find('#entitydevice-form').find('input, textarea, select').attr('disabled','disabled');
                    estadoGuarda=true;
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
                            $("#entitydevice-form #"+key+"_em_").text(val);                                                    
                            $("#entitydevice-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#entitydevice-form #entitydevice-form_es_").html(errores);                                                    
                        self.div.find("#entitydevice-form #entitydevice-form_es_").show(); 
                    }  
                    self.div.find("#btnRegEntityDevice").show(); 
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al asociar el dispositivo, el código del error es: "+error.status+" "+xhr;
            typeMsg="error"; 
            self.div.find("#btnRegEntityDevice").show();
        }).always(function(){
            $.notify(msg, typeMsg);
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

    window.Entitydevice=new Entitydevice();
    Entitydevice.filtraEntity();
    
});