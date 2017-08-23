<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entitydevice/Entitydevice.js",CClientScript::POS_END);
//    print_r($magnitudes);
?>
<section class="content" id="divMagnitude">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de magnitudes</h3>
                </div>
                <?php $formMagnitude=$this->beginWidget('CActiveForm', array(
                    'id'=>'magnitude-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>false,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    ),
                )); ?>
                <div class="box-body">
                    <?php echo  $formMagnitude->errorSummary($modelMagnitudeEntDev,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'position_dataframe'); ?>
                        <?php echo $formMagnitude->numberField($modelMagnitudeEntDev,'position_dataframe', array ('class' => 'form-control','placeholder'=>'Digite la posición de la magnitud en la trama')); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'position_dataframe'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'id_magnitude'); ?>
                        <?php echo $formMagnitude->dropDownList($modelMagnitudeEntDev,'id_magnitude',CHtml::listData($typemagnitudes, 'id_magnitude', 'magnitude_name'),array ('class' => 'form-control',"prompt"=>"Seleccione magnitud")); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'id_magnitude',array("class"=>"errorMessage")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'serialid_sensor'); ?>
                        <?php echo $formMagnitude->dropDownList($modelMagnitudeEntDev,'serialid_sensor',CHtml::listData($sensors, 'serialid_sensor', 'sensor_name'),array ('class' => 'form-control',"prompt"=>"Seleccione un sensor")); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'serialid_sensor',array("class"=>"errorMessage")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'id_measscale'); ?>
                        <?php echo $formMagnitude->dropDownList($modelMagnitudeEntDev,'id_measscale',CHtml::listData($measScale, 'id_measscale', 'measscale_name', 'measscale_unity'),array ('class' => 'form-control',"prompt"=>"Seleccione sistema de medida")); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'id_measscale',array("class"=>"errorMessage")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'min_magnitude'); ?>
                        <?php echo $formMagnitude->textField($modelMagnitudeEntDev,'min_magnitude', array ('class' => 'form-control','placeholder'=>'Digite límite inferior de la medición para alarmas')); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'min_magnitude'); ?>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'max_magnitude'); ?>
                        <?php echo $formMagnitude->textField($modelMagnitudeEntDev,'max_magnitude', array ('class' => 'form-control','placeholder'=>'Digite límite superior de la medición para alarmas')); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'max_magnitude'); ?>
                    </div>
                        <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'min_magnitude_wr'); ?>
                        <?php echo $formMagnitude->textField($modelMagnitudeEntDev,'min_magnitude_wr', array ('class' => 'form-control','placeholder'=>'Digite límite inferior de la medición para alarmas')); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'min_magnitude_wr'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $formMagnitude->labelEx($modelMagnitudeEntDev,'max_magnitude_wr'); ?>
                        <?php echo $formMagnitude->textField($modelMagnitudeEntDev,'max_magnitude_wr', array ('class' => 'form-control','placeholder'=>'Digite límite superior de la medición para alarmas')); ?>
                        <?php echo $formMagnitude->error($modelMagnitudeEntDev,'max_magnitude_wr'); ?>
                    </div>
                    </div>
                <div class="box-footer">
                    <div class="col-xs-2">
                        <?php echo $formMagnitude->hiddenField($modelMagnitudeEntDev,'id_entdev',array("value"=> $id_entdev)); ?>
                        <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegMagnitude')); ?>
                        <?php echo CHtml::button('Editar', array ('class' => 'btn btn-warning','id'=>'btnEditaMagnitude')); ?>
                    </div>
                    <div class="col-xs-2">
                        <?php echo CHtml::button('Cancelar edición', array ('class' => 'btn btn-danger','id'=>'btnCancelaEdicion')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Magnitudes</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableEntityMagnitude" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Posición en trama</th>
                                <th>Sensor</th>
                                <th>Magnitud</th>
                                <th>Unidad de medida SI</th>
                                <th>Mínimo de medición</th>
                                <th>Máximo de medición</th>
                                <th>Mínimo para alertar</th>
                                <th>Máximo para alertar</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($magnitudes)):
                                foreach($magnitudes as $magnitude):
                                    $sensor="N.A";
                                    if(!empty($magnitude["sensor_name"])){
                                        $sensor=$magnitude["sensor_name"];
                                    }
                                ?>  
                                    <tr>
                                        <td><?php echo $magnitude["position_dataframe"]?></td>
                                        <td><?php echo $sensor?></td>
                                        <td><?php echo $magnitude["magnitude_name"]?></td>
                                        <td><?php echo $magnitude["measscale_name"]." - ".$magnitude["measscale_unity"]?></td>
                                        <td><?php echo $magnitude["min_magnitude"]?></td>
                                        <td><?php echo $magnitude["max_magnitude"]?></td>
                                        <td><?php echo $magnitude["min_magnitude_wr"]?></td>
                                        <td><?php echo $magnitude["max_magnitude_wr"]?></td>
                                        <td><a href='javascript:Entitydevice.loadMagnitudeToForm("<?php echo $id_entdev?>","<?php echo $magnitude["id_magnitude"]?>");'>Editar</a></td>
                                    </tr>
                                <?php endforeach;
                            endif;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Posición en trama</th>
                                <th>Sensor</th>
                                <th>Magnitud</th>
                                <th>Sistema de medida</th>
                                <th>Mínimo de medición</th>
                                <th>Máximo de medición</th>
                                <th>Mínimo para alertar</th>
                                <th>Máximo para alertar</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
 <?php 
    Yii::app()->clientScript->registerScript('cargaMagnitudeAJs', '
       Entitydevice.arrayMagnitude='.json_encode($magnitudes).';
   ');