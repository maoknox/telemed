<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Telemedition.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("//cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.4/all/gauge.min.js",CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Graphics.js",CClientScript::POS_END);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//    print_r($positionsDF);
?>
<section class="content" id="divTelemed">
    <?php if(!empty($dataObjects)):?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Identificación de objeto</h3>
                    </div>
                    <div class="box-body">
                        <p>Nombre de objeto: <?php echo $object->object_name?></p>
                        <p>Hora última medición: <div id="timelecture"><?php echo $time;?></div></p>
                    <p><?php echo CHtml::link('Consultar gráfica', '#', array('onclick'=>''
                            . '$("#historicChart").dialog("open"); return false;'));?></p>
                    <p><?php echo CHtml::link('Consultar reporte', '#', array('onclick'=>''
                            . '$("#reportTelemed").dialog("open"); return false;'));?></p>
                    <p><?php echo CHtml::link('Consultar históricos', '#', array("submit"=>array("showFormHistoricTelemed"),"params"=>array("identdev"=>$dataFrames->id_entdev)));?></p>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <?php if(isset($positionsDF) && !empty($positionsDF)):?>
                 <?php foreach($positionsDF as $pk=>$position):?>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Magnitud: <?php echo $position["magnitude_name"]." - ".$position["measscale_name"]." - ".$position["measscale_unity"]?> </h3>
                            </div>
                            <div class="box-body" >
                                <div id="magnitude<?=$pk?>">
                                    <?php 
                                        //$idMagnitude="";
                                        echo $dataObjects["data"][$pk];
                                        $idMagnitude=$dataObjects["data"][$pk];
                                    ?>
                                </div>
                                <canvas id="gr<?=$pk?>" ></canvas>
                            </div>

                        </div>
                    </div>
            <?php endforeach;    endif;?>
            <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                    'id'=>'historicChart',
                    'options'=>array(
                        'title'=>'Grafica de históricos',
                        'autoOpen'=>false,
                        'width'=>'60%',
                         'height'=>'auto',
                        'htmlOptions' => array( 'style' => ' z-index: 100000' ),

                ))); 
                $this->renderPartial("_graficostl",array("identdev"=>$dataFrames->id_entdev,"positiondf"=>$positionsDF));          
                $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                    'id'=>'reportTelemed',
                    'options'=>array(
                        'title'=>'Consultar reporte vs rango de fecha',
                        'autoOpen'=>false,
                        'width'=>'60%',
                         'height'=>'auto',
                        'htmlOptions' => array( 'style' => ' z-index: 100000' ),

                ))); 
                $this->renderPartial("_reportetelemed",array("identdev"=>$dataFrames->id_entdev));          
                $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
        </div>
            <?php else:?>
             <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Mensaje:</h3>
                    </div>
                    <div class="box-body">
                        <p>Aún no hay datos que mostrar para este objeto: <?php echo $object->object_name?></p>
                    </div>
                </div>
            </div>
        </div>
            <?php endif;?>
</section>
 <?php 
 Yii::app()->clientScript->registerScript('cargaDataObject', '
    Telemedition.idEntdev='.$identdev.'
    Telemedition.searchDataTelemed();
    Graphics.showGauges('.CJSON::encode($positionsDF).','.CJSON::encode($dataObjects["data"]).');
');
