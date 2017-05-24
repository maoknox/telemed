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
var Service = function(){
    
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
    var Service = function() {
        self.div=$("#divEntitiService");
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
       
        self.div.find("#btnRegEntityService").click(function (){
            self.registerEntityService();
        });
        self.div.find("#nameEntity").keyup(function(){
            if(self.div.find("#nameEntity").val().length==0){
                self.div.find("#entityservice-form #EntityService_id_entity").val("");
            }
        });
        self.div.find("#entityservice-form").keyup(function (){
            estadoGuarda=false;
        });
        self.div.find("#entityservice-form").change(function (){
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
     * Filtra por texto digitado las empresas creadas
     */
    self.filtraEntity=function(){
        self.div.find("#entityservice-form #nameEntity").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"../person/searchEntity",
                    data: {stringentity:self.div.find("#entityservice-form #nameEntity").val()},
                    beforeSend:function (){
                        self.div.find("#entityservice-form #EntityService_id_entity").val("");
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
                    self.div.find("#entityservice-form #EntityService_id_entity").val(ui.item.id);
                }
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });
    };
    
    
    /**
     * Consume webservice createEntitypara registrar entidad
     */
    self.registerEntityService=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#entityservice-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerEntityService',
            data:dataEntity,
            beforeSend: function() {
                self.div.find("#entityservice-form #entityservice-form_es_").html("");                                                    
		self.div.find("#entityservice-form #entityservice-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegEntityService").hide();
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
                    self.div.find("#entityservice-form").trigger("reset");  
                    self.div.find("#entityservice-form #EntityService_id_entity").val("");  
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
                            $("#entityservice-form #"+key+"_em_").text(val);                                                    
                            $("#entityservice-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#entityservice-form #entityservice-form_es_").html(errores);                                                    
                        self.div.find("#entityservice-form #entityservice-form_es_").show(); 
                    }
                        
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al asociar el servicio, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        }).always(function(){
            $.notify(msg, typeMsg);
            self.div.find("#btnRegEntityService").show();
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

    window.Service=new Service();
    Service.filtraEntity();
    
});