<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/charts/charts.css');
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile("http://code.highcharts.com/modules/exporting.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://highcharts.github.io/export-csv/export-csv.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js");
    Yii::app()->clientScript->registerScriptFile("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js");
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/jqueryTimePicker.css"); 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jqueryTimePicker.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Historics.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Chartstl.js",CClientScript::POS_HEAD);
    
    $tablaNmag="";
    $tablaMScale="";
    $links="";
    foreach($modelMagnitudeEntDev as $magnitude){
            $modelMagnitude=  Magnitude::model()->findByPk($magnitude->id_magnitude);
            $modelMeasurementScale=  MeasurementScale::model()->findByPk($magnitude->id_measscale);
            $tablaNmag.="<th >".$modelMagnitude->magnitude_name." "
                    . "<a href='javascript:Chartstl.enviaDatosHisotric(\"".$magnitude->id_entdev."\",\"".$magnitude->position_dataframe."\",\"".$modelMagnitude->magnitude_name."\",\"".$modelMeasurementScale->measscale_unity."\");'>graficar</a>"
                    . "</th>";
//            $links.="<a href='javascript:alert(\"hola\");'>graficar</a>";
            $tablaMScale.="<th >".$modelMeasurementScale->measscale_name." - ".$modelMeasurementScale->measscale_unity."</th>";
            $identdev=$magnitude->id_entdev;
    }
//    print_r($modelMeasurementScale);
?>
<section class="content" id="divhisttl">
    <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Selección de fechas</h3><br>
                      <?php echo CHtml::link('<< volver',array('showDataObjectTelemed'), array('submit'=>array('showDataObjectTelemed'),'params'=>array('id_entdev'=>$identdev))); ?>
                    </div>
                    <div class="box-body">
                        <?php echo CHtml::beginForm('#','post',array('id'=>'formularioRep','name'=>'formularioRep'));?>
                        <div class="box">
                            <div class="box-header">                
                                <h5>Fecha inicial</h5>
                            </div>
                            <div class="box-content" >  
                                <input type="text" id="fechaInicialRepo" name="ConsRep[fecha_inicial]">
                            </div>
                        </div>
                        <div class="box">
                           <div class="box-header">                
                               <h5>Fecha final</h5>
                           </div>
                           <div class="box-content" >  
                               <input type="text" id="fechaFinalRepo" name="ConsRep[fecha_final]">
                           </div>
                        </div>
                        <div class="box">
                           <div class="box-content" > 
                               <input type="hidden" id="id_entdev" name="ConsRep[id_entdev]" value="<?php echo $identdev?>">
                               <?php echo CHtml::button("Consultar",array('title'=>"Consultar",'onclick'=>'Historics.showHistoricRepo()')); ?>
                           </div>
                       </div>
                    <?php echo CHtml::endForm() ; ?>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Histórico de medición</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableTelemedHist" class="table table-bordered table-striped">
                        <thead>
                           
                            <tr>
                                <th>--</th>
                                <?php echo $tablaNmag?>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <?php echo $tablaMScale?>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Fecha</th>
                                <?php echo $tablaMScale?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Gráfico</h3>
                </div>
                <div class="box-body">
                    <div id="divgrhtl" ></div>
                </div>
            </div>
        </div>
    </div>
</section>