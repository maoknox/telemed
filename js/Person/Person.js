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
var Person = function(){
    
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
    var Person = function() {
        self.div=$("#divPerson");
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
        self.div.find("#btnRegPerson").click(function (){
           self.registerPerson();
        });
        self.div.find("#nameEntity").keyup(function(){
            if(self.div.find("#nameEntity").val().length==0){
                self.div.find("#person-form #EntityPerson_id_entity").val("");
            }
        });
        self.div.find("#User_id_role").change(function(){
            if(self.div.find("#User_id_role").val()==1){
                self.div.find("#divEntity").css("display","none");
                 self.div.find("#nameEntity").val("");
                 self.div.find("#EntityPerson_id_entity").val("");
            }
            else{
                self.div.find("#divEntity").css("display","block");
            }
        });
        self.div.find("#person-form").keyup(function (){
            estadoGuarda=false;
        });
        self.div.find("#person-form").change(function (){
            estadoGuarda=false;
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
     * Filtra por texto digitado las empresas creadas
     */
    self.filtraEntity=function(){
            self.div.find("#person-form #nameEntity").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchEntity",
                        data: {stringentity:self.div.find("#person-form #nameEntity").val()},
                        beforeSend:function (){
                            self.div.find("#person-form #EntityPerson_id_entity").val("");
                        },
                        success: response,
                        dataType: 'json',
                        minLength: 1,
                        delay: 100
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    if(ui.item.id!="#"){
                        self.div.find("#person-form #EntityPerson_id_entity").val(ui.item.id);
                    }
                },
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 1000);
                }
            });
        };
    /**
     * Consume webservice createEntity para registrar entidad
     */
    self.registerPerson=function(){
        var msg="";
        var typeMsg="";
        var dataPerson=self.div.find("#person-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerPerson',
            data:dataPerson,
            beforeSend: function() {
                self.div.find("#person-form #person-form_es_").html("");                                                    
		self.div.find("#person-form #person-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegPerson").hide();
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
                    msg=response.msg;
                    self.div.find("#person-form").trigger("reset");  
                    typeMsg="success";
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
                        $.each(response, function(key, val) {
                            $("#person-form #"+key+"_em_").text(val);                                                    
                            $("#person-form #"+key+"_em_").show();                                                
                        });
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al registrar los datos de la persona, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        }).always(function(){
            $.notify(msg, typeMsg);
            self.div.find("#btnRegPerson").show();
            
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
    
    window.Person=new Person();
    Person.filtraEntity();
});