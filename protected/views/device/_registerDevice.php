<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Device/Device.js",CClientScript::POS_END);
?>

<section class="content" id="divDevice">
    <div class="row">
        <!-- left column -->
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Dispositivo</h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formDevice=$this->beginWidget('CActiveForm', array(
                    'id'=>'device-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    )
            )); ?>
            <div class="box-body">
                <?php echo  $formDevice->errorSummary(array($modelDevice,$modelServiceDevice),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
                    <?php echo $formDevice->labelEx($modelDevice,'id_device'); ?>
                    <?php echo $formDevice->textField($modelDevice,'id_device', array ('class' => 'form-control','placeholder'=>'Digite el identificador del dispositivo')); ?>
                    <?php echo $formDevice->error($modelDevice,'id_device'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formDevice->labelEx($modelDevice,'device_name'); ?>
                    <?php echo $formDevice->textField($modelDevice,'device_name', array ('class' => 'form-control','placeholder'=>'Digite un nombre para el dispositivo')); ?>
                    <?php echo $formDevice->error($modelDevice,'device_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formDevice->labelEx($modelServiceDevice,'id_service'); ?>
                    <?php echo $formDevice->dropDownList($modelServiceDevice,'id_service',  CHtml::listData($modelService,"id_service", "service_name"),array ('class' => 'form-control', 'multiple' => 'multiple')); ?>
                    <?php echo $formDevice->error($modelServiceDevice,'id_service',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formDevice->labelEx($modelDevice,'id_type_device'); ?>
                    <?php echo $formDevice->dropDownList($modelDevice,'id_type_device',CHtml::listData($modelTypDevice,"id_type_device", "devicetype_label"),array ('class' => 'form-control','prompt'=>'Seleccione tipo de dispositivo')); ?>
                    <?php echo $formDevice->error($modelDevice,'id_type_device',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formDevice->labelEx($modelDevice,'id_statedevice'); ?>
                    <?php echo $formDevice->dropDownList($modelDevice,'id_statedevice',CHtml::listData($modelStateDevice,"id_statedevice", "statedevice_label"),array ('class' => 'form-control','prompt'=>'Seleccione estado del dispositivo')); ?>
                    <?php echo $formDevice->error($modelDevice,'id_statedevice',array("class"=>"errorMessage")); ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <div class="col-xs-4">
                    <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegDevice')); ?>
                    <?php echo CHtml::button('Editar', array ('class' => 'btn btn-warning','id'=>'btnEditaDevice')); ?>
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
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableDevice" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Dispositivo</th>
                                <th>Tipo de dispositivo</th>
                                <th>Nombre del dispositivo</th>
                                <th>Estado del dispositivo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($devices)){
                                    foreach($devices as $device):?>
                                        <tr>
                                            <td><?php echo $device["id_device"]?></td>
                                            <td><?php echo $device["devicetype_label"]?></td>
                                            <td><?php echo $device["device_name"]?></td>
                                            <td><?php echo $device["statedevice_label"]?></td>
                                            <td><a href='javascript:Device.cargaDeviceAForm("<?php echo $device["id_device"]?>");'>Editar</a></td>
                                        </tr>
                                    <?php endforeach;
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id Dispositivo</th>
                                <th>Tipo de dispositivo</th>
                                <th>Nombre del dispositivo</th>
                                <th>Estado del dispositivo</th>
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
 Yii::app()->clientScript->registerScript('cargaDeviceAJs', '
    Device.arrayDevice='.json_encode($devices).';
');