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
var Graphics = function(){
    
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
    var Graphics = function() {
        self.div=$("#divTelemed");
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
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.showGauges=function(graphics,data){
        console.log(data);
        $.each(graphics,function(key,value){
            console.log(key+" "+value.graphic_code);
            var maxVal;
            var units;
            var minTicks=20;
            if(value.magnitude_code=="BARP"){
                maxVal=760;
                minTicks=76;
            }
            else if(value.magnitude_code=="WSPE" || value.magnitude_code=="MWSP"){
                maxVal=100;
                units="km/h";
            }
            else if(value.magnitude_code=="RINF" || value.magnitude_code=="RIND"){
                maxVal=100;
                units="mm";
            }
            else if(value.magnitude_code=="TEMP"){
                maxVal=100;
                units="°C";
            }
            else if(value.magnitude_code=="HM"){
                maxVal=100;
                units="%";
            }
            majTicks=self.calcMajorTicks(maxVal,minTicks);
            
            rendTo="gr"+key;
            switch(value.graphic_code) {
                case "COMPASS":
                    self.showCompassGauge(rendTo,data[key]);
                    break;
                case "RADIAL": 
                    self.showRadialGauge(rendTo,data[key],units,majTicks,maxVal);
                    break;
                case "LINEAR": 
                    self.showLinearGauge(rendTo,data[key],units,majTicks,maxVal,minTicks);
                    break;
                case "RADIALMIDLE": 
                    self.showMiddleRadGauge(rendTo,data[key],units,majTicks,maxVal);
                    break; 
            } 
        });
    };
    self.calcMajorTicks=function(maxVal,minTicks){
        var majTicksAux=[];
        var range=minTicks;//=maxVal/2;
        
        for(i=0;i<=maxVal;i++){
            majTicksAux.push(i);
            i+=range-1;
        }
        
        
        console.log(majTicksAux);
        return majTicksAux;
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Filtra por texto digitado las empresas creadas
     */
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    /*
     * Crea gauge radial para magnitudes como velocidad
     * 
     */
    self.showRadialGauge=function(rendTo,value,units,majTicks,maxVal){
       new RadialGauge({
            renderTo: rendTo,
            width: 150,
            height: 150,
            units: units,
            title: false,
            value: value,
            minValue: 0,
            maxValue: 100,
            majorTicks:majTicks ,
            minorTicks: 10,
            strokeTicks: true,
//            highlights:hl ,
            borderInnerWidth: 0,
            borderMiddleWidth: 0,
            borderOuterWidth: 1,
            colorCircleInner: "#000",
            colorNeedleCircleOuter: "#000",
                colorBorderOuter: "#ccc",
            colorBorderOuterEnd: "#ccc",
                borders: true,
            /*colorPlate: '#222',
            colorMajorTicks: '#f5f5f5',
            colorMinorTicks: '#ddd',
            colorTitle: '#fff',
            colorUnits: '#ccc',
            colorNumbers: '#eee',*/
            colorNeedle: 'rgba(240, 128, 128, 1)',
            colorNeedleEnd: 'rgba(255, 160, 122, .9)',
            valueBox: true
            //animationRule: 'bounce',
            //animationDuration: 500
        }).draw();
    };
    /*
     * Muestra gauge linear para magnitudes como temperatura
     * 
     */
    self.showLinearGauge=function(rendTo,val,units,majTicks,maxVal,minTicks){
        new LinearGauge({
            renderTo: rendTo,
            type:"linear-gauge",
            width: 200,
            height: 100,
            borders:0,
            barStrokeWidth:5,
            maxValue:maxVal,
            minorTicks:minTicks,
            majorTicks:majTicks,
//            colorNumbers:["red","green","blue","#000","#000","#000","#000","#000","#000","#000","#000"],
//            colorMajorTicks:["red","green","blue","#000","#000","#000","#000","#000","#000","#000","#000"],
            colorBarStroke:"#444",
            units:units,
            value:val,
            valueBox: false,
            colorValueBoxShadow:false,
            tickSide:"left",
            numberSide:"left",
            needleSide:"left",
            animateOnInit:true,
            colorPlate:"#fff",
            barBeginCircle:false
        }).draw();
    };
    
    self.showCompassGauge=function(rendTo,value){
       new RadialGauge({
            renderTo: rendTo,
            minValue: 0,
            maxValue: 360,
            width:150,
            height:150,
            majorTicks: [
                "N",
                "NE",
                "E",
                "SE",
                "S",
                "SW",
                "W",
                "NW",
                "N"
            ],
            minorTicks: 22,
            ticksAngle: 360,
            startAngle: 180,
            strokeTicks: true,
            highlights: true,
            colorPlate: "#a33",
            colorMajorTicks: "#f5f5f5",
            colorMinorTicks: "#ddd",
            colorNumbers: "#ccc",
            colorNeedle: "rgba(240, 128, 128, 1)",
            colorNeedleEnd: "rgba(255, 160, 122, .9)",
            valueBox: true,
            valueTextShadow: false,
            colorCircleInner: "#fff",
            colorNeedleCircleOuter: "#ccc",
            needleCircleSize: 15,
            needleCircleOuter: false,
            animationRule: "linear",
            needleType: "line",
            needleStart: 75,
            needleEnd: 99,
            needleWidth: 3,
            borders: true,
            borderInnerWidth: 0,
            borderMiddleWidth: 0,
            borderOuterWidth: 2,
            colorBorderOuter: "#ccc",
            colorBorderOuterEnd: "#ccc",
            colorNeedleShadowDown: "#222",
            borderShadowWidth: 0,
            animationTarget: "plate",
            animationDuration: 1500,
            value: value,
            animateOnInit: true
        }).draw(); 
    };
    self.showMiddleRadGauge=function(rendTo,value,units,majTicks,maxVal){
        new RadialGauge({
            renderTo: rendTo,
            width: 150,
            height: 150,
            units: units,
            minValue: 0,
            startAngle: 90,
            ticksAngle: 180,
            valueBox: false,
            value:value,
            maxValue: maxVal,
            majorTicks: majTicks,
            minorTicks: 10,
            strokeTicks: true,
            colorPlate: "#fff",
            borderShadowWidth: 0,
            borders: false,
            needleType: "arrow",
            needleWidth: 2,
            needleCircleSize: 7,
            needleCircleOuter: true,
            needleCircleInner: false,
            animationDuration: 1500,
            animationRule: "linear",
            animateOnInit: true
        }).draw();
    };
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    window.Graphics=new Graphics();
});