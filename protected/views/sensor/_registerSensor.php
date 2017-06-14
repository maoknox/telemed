<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Sensor/Sensor.js",CClientScript::POS_END);
?>

<section class="content" id="divSensor">
    <div class="row">
        <!-- left column -->
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Sensores</h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formSensor=$this->beginWidget('CActiveForm', array(
                    'id'=>'sensor-form',
                    'enableClientValidation'=>true,
//                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    )
            )); ?>
            <div class="box-body">
                <?php echo  $formSensor->errorSummary($modelSensor,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'id_sensor'); ?>
                    <?php echo $formSensor->textField($modelSensor,'id_sensor', array ('class' => 'form-control','placeholder'=>'Digite el identificador del sensor')); ?>
                    <?php echo $formSensor->hiddenField($modelSensor,'serialid_sensor', array ('class' => 'form-control','placeholder'=>'Digite el identificador del sensor')); ?>
                    <?php echo $formSensor->error($modelSensor,'id_sensor'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'sensor_name'); ?>
                    <?php echo $formSensor->textField($modelSensor,'sensor_name', array ('class' => 'form-control','placeholder'=>'Digite un nombre para el sensor')); ?>
                    <?php echo $formSensor->error($modelSensor,'sensor_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'id_typesensor'); ?>
                    <?php echo $formSensor->dropDownList($modelSensor,'id_typesensor',CHtml::listData($typeSensor,"id_typesensor", "typesensor_label"),array ('class' => 'form-control','prompt'=>'Seleccione tipo de sensor')); ?>
                    <?php echo $formSensor->error($modelSensor,'id_typesensor',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'sensor_brand'); ?>
                    <?php echo $formSensor->textField($modelSensor,'sensor_brand', array ('class' => 'form-control','placeholder'=>'Digite la marca del sensor')); ?>
                    <?php echo $formSensor->error($modelSensor,'sensor_brand'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'magnitude_min'); ?>
                    <?php echo $formSensor->textField($modelSensor,'magnitude_min', array ('class' => 'form-control','placeholder'=>'Digite magnitud mínima')); ?>
                    <?php echo $formSensor->error($modelSensor,'magnitude_min'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formSensor->labelEx($modelSensor,'magnitude_max'); ?>
                    <?php echo $formSensor->textField($modelSensor,'magnitude_max', array ('class' => 'form-control','placeholder'=>'Digite magnitud máxima')); ?>
                    <?php echo $formSensor->error($modelSensor,'magnitude_max'); ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <div class="col-xs-4">
                    <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegSensor')); ?>
                    <?php echo CHtml::button('Editar', array ('class' => 'btn btn-warning','id'=>'btnEditaSensor')); ?>
                </div>
                <div class="col-xs-4">
                    <?php echo CHtml::button('Cancelar edición', array ('class' => 'btn btn-danger','id'=>'btnCancelaEdicion')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
          </div>
            
        </div>
        
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sensores registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableSensorActualiza" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Sensor</th>
                                <th>Tipo de Sensor</th>
                                <th>Nombre del Sensor</th>
                                <th>Marca del sensor</th>
                                <th>Magnitud máxima del sensor</th>
                                <th>Magnitud mínima del sensor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($listSensors)){
                                    foreach($listSensors as $listSensor):?>
                                        <tr>
                                            <td><?php echo $listSensor["id_sensor"]?></td>
                                            <td><?php echo $listSensor["typesensor_label"]?></td>
                                            <td><?php echo $listSensor["sensor_name"]?></td>
                                            <td><?php echo $listSensor["sensor_brand"]?></td>
                                            <td><?php echo $listSensor["magnitude_min"]?></td>
                                            <td><?php echo $listSensor["magnitude_max"]?></td>
                                            <td><a href='javascript:Sensor.loadSensorToForm("<?php echo $listSensor["serialid_sensor"]?>");'>Editar</a></td>
                                        </tr>
                                    <?php endforeach;
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id Sensor</th>
                                <th>Tipo de Sensor</th>
                                <th>Nombre del Sensor</th>
                                <th>Marca del sensor</th>
                                <th>Magnitud máxima del sensor</th>
                                <th>Magnitud mínima del sensor</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
 <?php 
 Yii::app()->clientScript->registerScript('cargaSensorAJs', '
    Sensor.arraySensor='.json_encode($listSensors).';
');