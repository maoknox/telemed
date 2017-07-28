<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Telemedition.js",CClientScript::POS_END);
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
                        <p>Hora última medición: <div id="timelecture"><?php echo $time?></div></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if(isset($positionsDF) && !empty($positionsDF)):?>
                 <?php foreach($positionsDF as $pk=>$position):?>
                    <div class="col-md-2">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Magnitud: <?php echo $position["magnitude_name"]?> </h3>
                            </div>
                            <div class="box-body" id="magnitude<?=$pk?>">
                                <?php 
                                    //$idMagnitude="";
                                    echo $dataObjects["data"][$pk];
                                    $idMagnitude=$dataObjects["data"][$pk];
                                ?>
                            </div>

                        </div>
                    </div>
            <?php endforeach;    endif;?>
            <div class="col-md-2">
                <div class="box box-primary">
                    <div class="box-body" >
                        <?php echo CHtml::link('Consultar gráfica', '#', array('onclick'=>''
                            . '$("#historicChart").dialog("open"); return false;'));?>
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
                    </div>
                </div>
            </div>
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
');
