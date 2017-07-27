<?php
    
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/charts/charts.css');
//    Yii::app()->clientScript->registerCssFile("https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"); 
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts-more.js",CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/charts/raphael-2.1.4.min.js",CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/charts/justgage.js",CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/charts/mscorlib.js",CClientScript::POS_HEAD);
////    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/charts/PerfectWidgets.js",CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScriptFile("https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile("http://code.highcharts.com/modules/exporting.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://highcharts.github.io/export-csv/export-csv.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js");
    Yii::app()->clientScript->registerScriptFile("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js");
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/jqueryTimePicker.css"); 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jqueryTimePicker.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Chartstl.js",CClientScript::POS_HEAD);
//   echo $identdev;
?>
<section class="content" id="divCharts">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Consulta gráfica históricos</h3>
                </div>
                <div class="box-body">
                    <form id="formularioHist" name="formularioHist">
                        <div class="box box-primary">
                            <div class="box-header with-border">                   
                                <h5 class="box-title">Variables</h5>
                            </div>
                            <div class="box-body" >  
                                <select id="variablesSelect" name="ConsHist[variablesSelect]">
                                    <option value="">Seleccione...</option>
                                    <?php foreach($positiondf as $pk=>$position):?>
                                        <option value="<?php echo $position["position_dataframe"]?>"><?php echo $position["magnitude_name"]?></option>
                                    <?php endforeach;    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="box">
                            <div class="box-header">                
                                <h5>Fecha inicial</h5>
                            </div>
                            <div class="box-content" >  
                                <input type="text" id="fechaInicial" name="ConsHist[fecha_inicial]">
                            </div>
                        </div>
                        <div class="box">
                           <div class="box-header">                
                               <h5>Fecha final</h5>
                           </div>
                           <div class="box-content" >  
                               <input type="text" id="fechaFinal" name="ConsHist[fecha_final]">
                           </div>
                        </div>
                        <div class="box">
                           <div class="box-content" > 
                               <input type="hidden" id="id_entdev" name="ConsHist[id_entdev]" value="<?php echo $identdev?>">
                               <input type="button" id="consultaCharts" name="consulta" value="Consultar" >
                           </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">                
                    <h5 class="box-title">Gráfico</h5>
                </div>
                <div class="box-body" >  
                    <div id="g1"></div>   
                </div>
            </div>
        </div>
    </div>
</section>
