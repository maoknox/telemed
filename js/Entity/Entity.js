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
var Entity = function(){
    
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
    var Entity = function() {
        self.div=$("#divEntity");
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
//        dataTableAct=self.div.find("#dataTableActividades").DataTable({
//            oLanguage: IcetexApp.getDatatableLang(),
//            scrollX: true
//        });
      
//        self.div.find("#divRegPerson").hide();

        self.div.find("#Country_id_country").change(function (){
            if(self.div.find("#Country_id_country").val().length==0){
                self.div.find("#State_id_state").html("<option val=''>Debe seleccionar un departamento</option>");
            }
            else{
                self.searchState(self.div.find("#Country_id_country").val());
            }
        });
        self.div.find("#State_id_state").change(function (){
            if(self.div.find("#State_id_state").val().length==0){
                self.div.find("#CityEntity_id_city").html("<option val=''>Debe seleccionar una ciudad</option>");
            }
            else{
                self.searchCity(self.div.find("#State_id_state").val());
            }
        });
        self.div.find("#entity-form").change(function (){
            estadoGuarda=false;
        });
        self.div.find("#entity-form").keyup(function (){
            estadoGuarda=false;
        });
        self.div.find("#cityEntity-form").change(function (){
            estadoGuarda=false;
        });
        
        self.div.find("#Entity_id_typeent").change(function(){
            if(self.div.find("#Entity_id_typeent").val()==1){
                self.div.find("#entityLastName").css("display","block");
            }
            else{
                self.div.find("#entityLastName").css("display","none");
                self.div.find("#Entity_entity_lastname").val("");
            }
        });
        self.div.find("#btnRegEntity").click(function(){
            self.registerEntity();
        });
        self.div.find("#btnRegCityEntity").click(function (){
           self.registerCityEntity();
        });
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    
    /**
     * Consume webservice consultaState para consultar los departamentos
     */
    
    self.searchState=function(idCountry){
        var msg="";
        var typeMsg;
        self.div.find("#State_id_state").html("");
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchState',
            data:{idCountry:idCountry}
        }).done(function(response) {
            if(response.length>0){
                self.div.find("#State_id_state").append("<option value=''>Seleccione un departamento</option>");
                $.each(response,function(key, value){
                    self.div.find("#State_id_state").append("<option value='"+value.id_state+"'>"+value.state_name+"</option>");
                });
            }
            else{
                $.notify("No hay departamentos regitrados para este país", "warn");
                self.div.find("#State_id_state").html("<option value=''>Seleccione otro país</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los departaentos, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    /**
     * Consume webservice consultaCity para consultar las ciudades
     */
    
    self.searchCity=function(idState){
        var msg="";
        var typeMsg;
        self.div.find("#CityEntity_id_city").html("");
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchCity',
            data:{idState:idState}
        }).done(function(response) {
            if(response.length>0){
                self.div.find("#CityEntity_id_city").append("<option value=''>Seleccione una ciudad</option>");
                $.each(response,function(key, value){
                    self.div.find("#CityEntity_id_city").append("<option value='"+value.id_city+"'>"+value.city_name+"</option>");
                });
            }
            else{
                $.notify("No hay ciudades regitradas para este departamento", "warn");
                self.div.find("#CityEntity_id_city").html("<option value=''>Seleccione otro departamento</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar las ciudades, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    /**
     * Consume webservice createEntitypara registrar entidad
     */
    self.registerEntity=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#entity-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'createEntity',
            data:dataEntity,
            beforeSend: function() {
                self.div.find("#entity-form #entity-form_es_").html("");                                                    
		self.div.find("#entity-form #entity-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegEntity").hide();
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
                    msg="Cliente registrado satisfactoriamente";
                    typeMsg="success";
//                    self.div.find("#divRegPerson").css("display","block");
                    self.div.find('#entity-form').find('input, textarea, select').attr('disabled','disabled');
                    self.div.find("#CityEntity_id_entity").val(response.idempresa);
                    estadoGuarda=true;
                }
                else{
                    msg="Revise la validación del formuario";
                    typeMsg="warn";
                    var errores="Revise lo siguiente<br/><ul>";
                    $.each(response, function(key, val) {
                        errores+="<li>"+val+"</li>";
                        $("#entity-form #"+key+"_em_").text(val);                                                    
                        $("#entity-form #"+key+"_em_").show();                                                
                    });
                    errores+="</ul>";
                    self.div.find("#entity-form #entity-form_es_").html(errores);                                                    
                    self.div.find("#entity-form #entity-form_es_").show(); 
                    self.div.find("#btnRegEntity").show();
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al crear el cliente, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
            self.div.find("#btnRegEntity").show();
        }).always(function(){
            $.notify(msg, typeMsg);
        });
         
    };
    /**
     * Consume webservice registerCityEntity para registrar ciudad donde opera la entidad
     */
    self.registerCityEntity=function(){
        var msg="";
        var typeMsg="";
        var dataCityEntity=self.div.find("#cityEntity-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerCityEntity',
            data:dataCityEntity,
            beforeSend: function() {
                self.div.find("#cityEntity-form #cityEntity-form_es_").html("");                                                    
		self.div.find("#cityEntity-form #cityEntity-form_es_").show();
                self.div.find(".errorCityEntity").html("");                                                    
		self.div.find(".errorCityEntity").show();
                self.div.find("#btnRegCityEntity").hide();
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
                    msg="Ciudad registrada satisfactoriamente,  puede registrar varias ciudades.";
                    typeMsg="success";
                    $("#Country_id_country").val("");
                    $("#State_id_state").val("");
                    $("#CityEntity_id_city").val("");
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
                            $("#cityEntity-form #"+key+"_em_").text(val);                                                    
                            $("#cityEntity-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#cityEntity-form #cityEntity-form_es_").html(errores);                                                    
                        self.div.find("#cityEntity-form #cityEntity-form_es_").show(); 
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al crear la ciudad, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        }).always(function(){
            $.notify(msg, typeMsg);
            self.div.find("#btnRegCityEntity").show();
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

    window.Entity=new Entity();
    
});