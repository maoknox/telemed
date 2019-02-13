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
var LecturaAgua = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    var arrayMagnitude="";
    self.dataTable="";
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
    var LecturaAgua = function() {
        self.section=$("#sectionLectura");
        self.divi=$("#divMagnitude");
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
       Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
//        
Highcharts.setOptions({
    lang: {
        loading: 'Cargando...',
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        exportButtonTitle: "Exportar",
        printButtonTitle: "Importar",
        rangeSelectorFrom: "Desde",
        rangeSelectorTo: "Hasta",
        rangeSelectorZoom: "Período",
        downloadPNG: 'Descargar imagen PNG',
        downloadJPEG: 'Descargar imagen JPEG',
        downloadPDF: 'Descargar imagen PDF',
        downloadSVG: 'Descargar imagen SVG',
        printChart: 'Imprimir',
        resetZoom: 'Reiniciar zoom',
        resetZoomTitle: 'Reiniciar zoom',
        thousandsSep: ",",
        decimalPoint: '.'
    }
});
        $("#idMedidor").on("click",function(){
            console.log("Click");
        });
        self.section.find("#Departamento_id_departamento").change(function (){
            self.section.find("#Empresa_id_empresa").html("<option value=''>Seleccione un Municipio</option>");
            if(self.section.find("#Departamento_id_departamento").val()!=""){
                self.section.find("#Municipio_id_municipio").html("");
               self.searchMunicipio(self.section.find("#Departamento_id_departamento").val());
//                console.log(self.section.find("#Departamento_id_departamento").val());
            }
            else{
                self.section.find("#Municipio_id_municipio").html("<option value=''>Seleccione un Municipio</option>");
            }
        });
        self.section.find("#Municipio_id_municipio").change(function (){
            if(self.section.find("#Municipio_id_municipio").val()!=""){
                self.section.find("#Empresa_id_empresa").html("");
               self.searchEmpresa(self.section.find("#Municipio_id_municipio").val());
//                console.log(self.section.find("#Departamento_id_departamento").val());
            }
            else{
                self.section.find("#Empresa_id_empresa").html("<option value=''>Seleccione un Municipio</option>");
            }
        });
        self.section.find("#fechaLectMed").change(function (){
            self.section.find('.cl-datos-med thead tr').html('');
            self.section.find('.cl-datos-med tbody tr').html('');
            if(self.section.find("#fechaLectMed").val()!=""){
               self.showDataHistAforo(self.section.find("#fechaLectMed").val(),localStorage.getItem("idMedidor"));
            }
            else{
                self.section.find("#divDatosLectura").fadeOut("slow");
            }
        });
        
        
        
        self.section.find("#btnConsLecturas").on('click',function(){
            if(self.section.find("#Empresa_id_empresa").val()!=""){
                self.searchMedidor(self.section.find("#Empresa_id_empresa").val())
            }
            else{
                 msg="Debe seleccionar una empresa para la consulta";
                typeMsg="warn";
                $.notify(msg, typeMsg);
            }
        });
        self.section.find("#verHist").on('click',function(){
            self.section.find("#dataTableMedidorDiv").fadeIn("slow");
        });
        self.section.find("#ocultarHist").on('click',function(){
            self.section.find("#dataTableMedidorDiv").fadeOut("slow");
        });
        
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    /**
     * Carga datos del Dispositivo seleccionado en el formulario para editar
     */
    self.loadMagnitudeToForm=function(idEntDev,idMagnitude){
        self.divi.find("#btnRegMagnitude").css("display","none");
        self.divi.find("#btnEditaMagnitude").css("display","block");
        self.divi.find("#btnCancelaEdicion").css("display","block");
        $.each(self.arrayMagnitude,function(key,value){
            if(value.id_magnitude==idMagnitude){
                console.log(value.id_measscale);
                self.divi.find("#magnitude-form #MagnitudeEntdev_position_dataframe").val(value.position_dataframe);
                self.divi.find("#magnitude-form #MagnitudeEntdev_id_magnitude").val(value.id_magnitude);
                self.divi.find("#magnitude-form #MagnitudeEntdev_serialid_sensor").val(value.serialid_sensor);
                self.divi.find("#magnitude-form #MagnitudeEntdev_id_measscale").val(value.id_measscale);
                self.divi.find("#magnitude-form #MagnitudeEntdev_min_magnitude").val(value.min_magnitude);
                self.divi.find("#magnitude-form #MagnitudeEntdev_max_magnitude").val(value.max_magnitude);
                self.divi.find("#magnitude-form #MagnitudeEntdev_min_magnitude_wr").val(value.min_magnitude_wr);
                self.divi.find("#magnitude-form #MagnitudeEntdev_max_magnitude_wr").val(value.max_magnitude_wr);
            }
        });
    };
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Busca Municipio por id departamento
     * @idDepto
     */
    self.searchMunicipio=function(idDepto){ 
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchMunicipio',
            data:{idDepto:idDepto}
        }).done(function(response) {
            console.log(JSON.stringify(response));
            if(response.length>0){
                self.section.find("#Municipio_id_municipio").append("<option value=''>Seleccione un Municipio</option>");
                $.each(response,function(key, value){
                    self.section.find("#Municipio_id_municipio").append("<option value='"+value.id_municipio+"'>"+value.nombre_municipio+"</option>");
                });
            }
            else{
                $.notify("No hay municipios relacionados", "warn");
                self.section.find("#Municipio_id_municipio").html("<option value=''>Seleccione un Departamento</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los servicios, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    /**
     * Busca Empresa por idMunicipio
     */
    self.searchEmpresa=function(idMunicipio){ 
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchEmpresa',
            data:{idMunicipio:idMunicipio}
        }).done(function(response) {
            console.log(JSON.stringify(response));
            if(response.length>0){
                self.section.find("#Empresa_id_empresa").append("<option value=''>Seleccione una Empresa</option>");
                $.each(response,function(key, value){
                    self.section.find("#Empresa_id_empresa").append("<option value='"+value.id_empresa+"'>"+value.nombre_empresa+"</option>");
                });
            }
            else{
                $.notify("No hay empresas relacionadas al municipio", "warn");
                self.section.find("#Empresa_id_empresa").html("<option value=''>Seleccione una empresa</option>");
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los servicios, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    self.searchMedidor=function(idEmpresa){ 
        $('#dataTableMedidor thead tr').html("");
        $('#dataTableMedidor tfoot tr').html("");
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchMedidor',
            data:{idEmpresa:idEmpresa},
//            beforeSend: function(){
//                $.LoadingOverlay("show",{ zIndex: 10000000000000000000   });
//            }
        }).done(function(response) {
                console.log(JSON.stringify(response));
             if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
             }
             else{
                if(JSON.stringify(response).length>0){
                    $.each(response.columns,function(key, value){
                        $('#dataTableMedidor thead tr').append('<td>'+value+'</td>');
                        $('#dataTableMedidor tfoot tr').append('<td>'+value+'</td>');
                    });
                    $('#dataTableMedidorDiv').css("display","block");
                    self.dataTable=$("#dataTableMedidor").DataTable({
    //                    "bProcessing": true,
    //                    "serverSide": true,
                        dom: 'lBfrtip',
                        buttons: [
                           'copyHtml5',
                           'excelHtml5',
                           'csvHtml5',
                           'pdfHtml5'
                       ],
                       lengthMenu: [
                            [25, 50, 100, 200, -1],
                            [25, 50, 100, 200, "All"]
                        ],
                        fixedHeader: {
                            header: true,
                            footer: true
                        },
                        "destroy" : true,
                        oLanguage: Telemed.getDatatableLang(),
                        scrollX: true
                    }); 
                    self.dataTable.clear();
//                    CHtml::link('Consultar gráfica', '#', array('onclick'=>''. '$("#historicChart").dialog("open"); return false;'))
                    $.each(response.data,function(key,value){
                        
                        self.dataTable.row.add([
                            '<a href=javascript:LecturaAgua.showDataHist("'+value.Medidor+'");>'+value.Medidor+'</a>',
                            value.Ubicación,
                            value.Interno,
                            value.Ruta,
                            value.Ciclo,
        //                    
                        ]).draw();
                    });
                }
                else{
                    $.notify("No hay datos para esta empresa", "warn");
                    self.section.find("#Empresa_id_empresa").html("<option value=''>Seleccione una empresa</option>");
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los servicios, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        }).always(function(){
            $.LoadingOverlay("hide");
        });
    };
    self.showDataHist=function(idMedidor){
        if(localStorage.getItem("idMedidor")){
            localStorage.removeItem("idMedidor");
        }
        self.section.find('.cl-datos-med thead tr').html('');
        self.section.find('.cl-datos-med tbody tr').html('');
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchHistFechaMedidor',
            data:{idMedidor:idMedidor}
        }).done(function(response) {
            console.log(JSON.stringify(response));
            if(JSON.stringify(response).length>0){
                self.section.find("#fechaLectMed").html("");
                self.section.find("#fechaLectMed").append("<option value=''>Seleccione una fecha</option>");
                $.each(response.fecha,function(key, value){
                    self.section.find("#fechaLectMed").append("<option value='"+value.Fecha_aforo+"'>"+value.Fecha_aforo+"</option>");
                });
                self.section.find("#dataTableMedidorDiv").fadeOut("slow");
                localStorage.setItem("idMedidor",idMedidor);
            }
            else{
                $.notify("No hay históricos para éste medidor", "warn");
                
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los medidores";
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
//        console.log(idMedidor);
    };
    self.showDataHistAforo=function(fecha,idMedidor){
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'showDataHistAforo',
            data:{fecha:fecha,idMedidor:idMedidor}
        }).done(function(response) {
            console.log(response.datahlect);
            if(JSON.stringify(response).length>0){
                self.section.find("#divDatosLectura").fadeIn("slow");
                $.each(response.colsaforo,function(key, value){
                    self.section.find('#datosGeneralesMed thead tr').append('<td>'+value+'</td>');
                });
                $.each(response.dataaforo,function(key, value){
                    self.section.find('#datosGeneralesMed tbody tr').append('<td>'+value+'</td>');
                });
                $.each(response.colshlect,function(key, value){
                    self.section.find('#histLecMed thead tr').append('<td>'+value+'</td>');
                });
                rowHLecMed="";
                histLectMedFecha=[];
                histLectMed=[];
                data=[];
                $.each(response.datahlect,function(key, value){
                    
                    rowHLecMed="<tr>";
                    $.each(value,function(keyHl, valueHl){
                        rowHLecMed+="<td>"+valueHl+"</td>";
                    });
                    rowHLecMed+="</tr>";
                    self.section.find('#histLecMed thead').append(rowHLecMed);
                    value.lectura=value.lectura*1;
                    myDate=value.fecha_lectura.split("-");
                    var newDate=myDate[1]+"/"+myDate[2]+"/"+myDate[0];
                    value.fecha_lectura=new Date(newDate).getTime();
                    data.push({
                        x: value.fecha_lectura,
                        y: value.lectura
                    });
                });
                 $.each(response.colshcons,function(key, value){
                    self.section.find('#histConsMed thead tr').append('<td>'+value+'</td>');
                });
                console.log(data);
                rowHLecCons="";
                $.each(response.datahcons,function(key, value){
                    rowHLecCons="<tr>";
                    $.each(value,function(keycl, valuecl){
                        rowHLecCons+="<td>"+valuecl+"</td>";
                    });
                    rowHLecCons+="</tr>";
                    self.section.find('#histConsMed thead').append(rowHLecCons);
                });
                $('#g1').highcharts({
                    chart: {
                        defaultSeriesType: 'spline',
                        animation: Highcharts.svg, // don't animate in old IE
                        marginRight: 10,
                        zoomType: 'x'
                    },
                    plotOptions: {
                        spline: {
                            turboThreshold: 9000,
                            lineWidth: 2,
                            states: {
                                hover: {
                                    enabled: true,
                                    lineWidth: 3
                                }
                            },
                            marker: {
                                enabled: false,
                                states: {
                                    hover: {
                                        enabled : true,
                                        radius: 5,
                                        lineWidth: 1
                                    }
                                }  
                            }      
                        }
                    },
                    title: {
                        text: 'Histórico de lecturas'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150
                    },
                    yAxis: {
                        title: {
                            text: 'mts cúbicos'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                        }
                    },
                    legend: {
                        enabled: true
                    },
                    exporting: {
                        enabled: true
                    },
                    series: [{
                        name: 'Consumo vs tiempo',
                        data: data
                    }]
                }); 
            }
            else{
                $.notify("Sin Datos", "warn");
                
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los históricos";
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
     * Consume webservice createEntityDevice para registrar dispositivo en formulario 2
     */
   
    
    /**
     * Consume webservice createEntityDevice para registrar dispositivo en formulario 2
     */
   
    /**
     * Consume webservice createEntityDevice para registrar dispositivo
     */
    
    
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
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
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.LecturaAgua=new LecturaAgua();
//    Entitydevice.filtraEntity();
    
});