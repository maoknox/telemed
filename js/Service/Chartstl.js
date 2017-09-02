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
var Chartstl = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.count=0;
    self.idEntdev="";
    self.datosExport=[];
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
    var Chartstl = function() {
        self.div=$("#divCharts");
        self.divi=$("#divChartsRepo");
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
//        Highcharts.setOptions({
//            global: {
//                    useUTC: false
//            }
//        });
       self.div.find("#formularioHist").validate({
            rules: {
                "ConsHist[variablesSelect]": "required",
                "ConsHist[fecha_inicial]":"required",
                "ConsHist[fecha_final]":"required",
                "ConsHist[id_entdev]":"required"
            },
            messages: {
                "ConsHist[variablesSelect]": "Seleccione una variable",
                "ConsHist[fecha_inicial]":"Seleccione una fecha inicial",
                "ConsHist[fecha_final]":"Seleccione una fecha final",
                "ConsHist[id_entdev]":"No ha asociado un id de dispositivo"
            }
        });
        self.div.find('#fechaInicial').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
        self.div.find('#fechaFinal').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
        self.divi.find("#formularioRep").validate({
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
        self.divi.find('#fechaInicialRepo').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
        self.divi.find('#fechaFinalRepo').datetimepicker({
            controlType: 'select',
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            format:"yyyy-mm-dd"
        });
        self.div.find("#consultaCharts").click(function(){
            self.enviaDatos();
        });
       Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
     self.exportCsv=function(){
        if(self.datosExport!=""){
//              JSONToCSVConvertor(datosExport, true);
            self.JSONToCSVConvertor(self.datosExport,$("#variablesSelect :selected").text()+" vs tiempo", true);
        }
        else{
            console.log("error");
        }
        
    };
    
   
   self.exportExcel=function(){
        if(self.datosExport!=""){
//              JSONToCSVConvertor(datosExport, true);
            self.JSONToXLSConvertor(self.datosExport,$("#variablesSelect :selected").text()+" vs tiempo", true);
        }
        else{
             console.log("error");
        }
    };
    
    self.JSONToCSVConvertor=function(JSONData, ReportTitle, ShowLabel) {
            console.debug(JSONData);
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
        var CSV = '';    
        //Set Report title in first row or line

        CSV += ReportTitle + '\r\n\n';

        //This condition will generate the Label/Header
        if (ShowLabel) {
            var row = "";

            //This loop will extract the label from 1st index of on array
            for (var index in arrData[0]) {

                //Now convert each value to string and comma-seprated
                row += index + ',';
            }

            row = row.slice(0, -1);

            //append Label row with line break
            CSV += row + '\r\n';
        }

        //1st loop is to extract each row
        for (var i = 0; i < arrData.length; i++) {
            var row = "";

            //2nd loop will extract each column and convert it in string comma-seprated
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }

            row.slice(0, row.length - 1);

            //add a line break after each row
            CSV += row + '\r\n';
        }

        if (CSV == '') {        
            alert("Invalid data");
            return;
        }   

        //Generate a file name
        var fileName = "MyReport_";
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += ReportTitle.replace(/ /g,"_");   

        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

        window.open( uri,ReportTitle);
    };
    self.JSONToXLSConvertor=function(JSONData, ReportTitle, ShowLabel) {
        //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
        
        
            console.debug(JSONData);
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
        var CSV = '';    
        //Set Report title in first row or line

        CSV += ReportTitle + '\r\n\n';

        //This condition will generate the Label/Header
        if (ShowLabel) {
            var row = "";

            //This loop will extract the label from 1st index of on array
            for (var index in arrData[0]) {

                //Now convert each value to string and comma-seprated
                row += index + ',';
            }

            row = row.slice(0, -1);

            //append Label row with line break
            CSV += row + '\r\n';
        }

        //1st loop is to extract each row
        for (var i = 0; i < arrData.length; i++) {
            var row = "";

            //2nd loop will extract each column and convert it in string comma-seprated
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }

            row.slice(0, row.length - 1);

            //add a line break after each row
            CSV += row + '\r\n';
        }

        if (CSV == '') {        
            alert("Invalid data");
            return;
        }   

        //Generate a file name
        var fileName = "MyReport_";
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += ReportTitle.replace(/ /g,"_");   

        //Initialize file format you want csv or xls
        var uri = 'data:text/vnd.ms-excel;charset=utf-8,' + escape(CSV);
        window.open( uri,ReportTitle);
    };
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    self.enviaDatos=function(){
        self.datosExport=[{
           magnitud:$("#variablesSelect :selected").text(),
           time:"Tiempo"
        }];
        if ($("#formularioHist").valid()) {
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
                    text: $("#variablesSelect :selected").text()+' vs Tiempo'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
                },
                yAxis: {
                    title: {
                        text: $("#variablesSelect :selected").text()
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
                    name: $("#variablesSelect :selected").text()+' vs Tiempo',
                    data: (function () {
                        var dataPost=$("#formularioHist").serialize();
                        // generate an array of random data
                        var data = [],time = (new Date()).getTime(),i = -19;
                        $.ajax({
                            url: "muestrahistorico",    
                            //url: "muestraArrayPuntos",                        
                            dataType:"json",
                            data:dataPost,
                            type: "post",
                            async:false,
                            //beforeSend:function (){Loading.show();},
                            success: function(dataJson){
                               $.each(dataJson.datos,function(key,value){ 
                                   datoExport={
                                        magnitud:value.magnitud,
                                        time:value.tempbd
                                     };
                                   self.datosExport.push(datoExport);
//                                   console.debug(value.time);
//                                   console.debug(value.magnitud);
                                    var d=new Date(value.time);
                                    data.push({
                                        x: (d).getTime(),
                                        y: value.magnitud
                                    });
                               });
                               console.debug(self.datosExport);
                            },
                            error:function (err){
                                console.debug(err);
                            }
                        }); 
                        return data;
//                        for (i = -19; i <= 0; i += 1) {
//                            var dTime=time + i * 1000;
//                            console.debug(new Date(dTime));
//                                    data.push({
//                                        x:dTime,
//                                        y: Math.random()
//                                    });
//                                }
//                               console.debug(data);
//                                return data;
                    }())
                }]
            }); 
        }
        
    };
    self.enviaDatosHisotric=function(identdev,posdf,msname,msunit){
//        console.log("pasa");return;
        if ($("#formularioRep").valid()) {
            $('#divgrhtl').highcharts({
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
                    text: msname+"-"+msunit+' vs Tiempo'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
                },
                yAxis: {
                    title: {
                        text: msname+"-"+msunit
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
                    name: msname+"-"+msunit+' vs Tiempo',
                    data: (function () {
//                        var dataPost=$("#formularioHist").serialize();//identdev,posdf,msname,msunit
                        var fechaIni=$("#formularioRep #fechaInicialRepo").val();
                        var fechaFin=$("#formularioRep #fechaFinalRepo").val();
                        var dataPost={
                            "Hist[identdev]":identdev,
                            "Hist[posdf]":posdf,
                            "Hist[msname]":msname,
                            "Hist[msunit]":msunit,
                            "Hist[fechaIni]":fechaIni,
                            "Hist[fechaFin]":fechaFin,
                            "Hist[time]":"Tiempo"
                         };
                        // generate an array of random data
                        var data = [];
                        $.ajax({
                            url: "muestrahistoricotl",    
                            //url: "muestraArrayPuntos",                        
                            dataType:"json",
                            data:dataPost,
                            type: "post",
                            async:false,
                            //beforeSend:function (){Loading.show();},
                            success: function(dataJson){
                               $.each(dataJson.datos,function(key,value){ 
                                   datoExport={
                                        magnitud:value.magnitud,
                                        time:value.tempbd
                                     };
                                   self.datosExport.push(datoExport);
//                                   console.debug(value.time);
//                                   console.debug(value.magnitud);
                                    var d=new Date(value.time);
                                    data.push({
                                        x: (d).getTime(),
                                        y: value.magnitud
                                    });
                               });
                               console.debug(self.datosExport);
                            },
                            error:function (err){
                                console.debug(err);
                            }
                        }); 
                        return data;
//                        for (i = -19; i <= 0; i += 1) {
//                            var dTime=time + i * 1000;
//                            console.debug(new Date(dTime));
//                                    data.push({
//                                        x:dTime,
//                                        y: Math.random()
//                                    });
//                                }
//                               console.debug(data);
//                                return data;
                    }())
                }]
            }); 
        }
        
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

    window.Chartstl=new Chartstl();
});