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
var Sensor = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.arraySensor=[];
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
    var Sensor = function() {
        self.div=$("#divSensor");
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
        dataTableSensorAct=self.div.find("#dataTableSensorActualiza").DataTable({
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
        
        self.div.find("#sensor-form").change(function (){
            estadoGuarda=false;
        });
        self.div.find("#btnRegSensor").click(function(){
            self.registerSensor();
        });
        self.div.find("#btnEditaSensor").hide();
        self.div.find("#btnCancelaEdicion").hide();
        
        self.div.find("#btnEditaSensor").click(function(){
            self.editSensor();
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
    self.loadSensorToForm=function(idSensor){
        self.div.find("#btnRegSensor").css("display","none");
        self.div.find("#btnEditaSensor").css("display","block");
        self.div.find("#btnCancelaEdicion").css("display","block");
        self.div.find("#sensor-form #Sensor_id_sensor").attr("readonly",true);
        $.each(self.arraySensor,function(key,value){
            if(value.serialid_sensor==idSensor){
                self.div.find("#sensor-form #Sensor_serialid_sensor").val(value.serialid_sensor);
                self.div.find("#sensor-form #Sensor_id_sensor").val(value.id_sensor);
                self.div.find("#sensor-form #Sensor_sensor_name").val(value.sensor_name);
                self.div.find("#sensor-form #Sensor_id_typesensor").val(value.id_typesensor);
                self.div.find("#sensor-form #Sensor_sensor_brand").val(value.sensor_brand);
                self.div.find("#sensor-form #Sensor_magnitude_min").val(value.magnitude_min);
                self.div.find("#sensor-form #Sensor_magnitude_max").val(value.magnitude_max);
            }
        });
    }; 
    /**
     * Cancela edición y limpia formulario
     */
    self.cancelEdition=function(){
        self.div.find("#btnRegSensor").css("display","block");
        self.div.find("#btnEditaSensor").css("display","none");
        self.div.find("#btnCancelaEdicion").css("display","none");
        self.div.find("#sensor-form #Sensor_serialid_sensor").removeAttr("value");
        self.div.find("#sensor-form").trigger("reset");
        self.div.find("#sensor-form #Sensor_id_sensor").attr("readonly",false);
    };
    
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    
   
    /**
     * Consume webservice registerSensor registrar dispositivo
     */
    self.registerSensor=function(){
        var msg="";
        var typeMsg="";
        var dataSensor=self.div.find("#sensor-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerSensor',
            data:dataSensor,
            beforeSend: function() {
                self.div.find("#sensor-form #sensor-form_es_").html("");                                                    
		self.div.find("#sensor-form #sensor-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegSensor").hide();
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
                    self.div.find("#sensor-form").trigger("reset");
                    estadoGuarda=true;
                    self.loadDataSensorAct(response.data);
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
                            $("#sensor-form #"+key+"_em_").text(val);                                                    
                            $("#sensor-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#sensor-form #sensor-form_es_").html(errores);                                                    
                        self.div.find("#sensor-form #sensor-form_es_").show(); 
                        self.div.find("#btnRegSensor").show();
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al crear el dispositivo, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
            self.div.find("#btnRegSensor").show();
        }).always(function(){
            self.div.find("#btnRegSensor").show();
            $.notify(msg, typeMsg);
        });
         
    };
    /**
     * Consume webservice registerSensor registrar dispositivo
     */
    self.editSensor=function(){
        var msg="";
        var typeMsg="";
        var dataSensor=self.div.find("#sensor-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'editSensor',
            data:dataSensor,
            beforeSend: function() {
                self.div.find("#sensor-form #sensor-form_es_").html("");                                                    
		self.div.find("#sensor-form #sensor-form_es_").show();
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
                    self.loadDataSensorAct(response.data);
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
                            $("#sensor-form #"+key+"_em_").text(val);                                                    
                            $("#sensor-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#sensor-form #sensor-form_es_").html(errores);                                                    
                        self.div.find("#sensor-form #sensor-form_es_").show(); 
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
    self.loadDataSensorAct=function(data){
        self.arraySensor=data;
        dataTableSensorAct.clear();
        $.each(data,function(key,value){
            dataTableSensorAct.row.add([
                value.id_sensor,
                value.typesensor_label,
                value.sensor_name,
                value.sensor_brand,
                value.magnitude_min,
                value.magnitude_max,
                "<a href=javascript:Sensor.loadSensorToForm('"+value.serialid_sensor+"');>Editar</a>"
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
    window.Sensor=new Sensor();
});