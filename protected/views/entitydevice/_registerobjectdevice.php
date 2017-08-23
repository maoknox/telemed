<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entitydevice/Entitydevice.js",CClientScript::POS_END);
?>
<section class="content" id="divEntityDevice">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Objeto</h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formEntityService=$this->beginWidget('CActiveForm', array(
                    'id'=>'entitydevice-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    )
            )); ?>
            <div class="box-body">
                <?php echo  $formEntityService->errorSummary(array($modelEntityDevice,$modelObject,$modelObjectUbication),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group" id="divEntity">
                    <?php echo $formEntityService->labelEx($modelEntityDevice,'id_entity'); ?>
                    <?php echo CHtml::textField('nameEntity', '',array('id'=>'nameEntity','class' => 'form-control','placeholder'=>'Digite nombre o identificación de la empresa')); ?>
                    <?php echo $formEntityService->hiddenField($modelEntityDevice,'id_entity', array ('class' => 'form-control','placeholder'=>'Seleccione una empresa')); ?>
                    <?php echo $formEntityService->error($modelEntityDevice,'id_entity'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelEntityDevice,'id_service'); ?>
                    <?php echo $formEntityService->dropDownList($modelEntityDevice,'id_service',array(""=>"Seleccione empresa"),array ('class' => 'form-control')); ?>
                    <?php echo $formEntityService->error($modelEntityDevice,'id_service',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelEntityDevice,'id_device'); ?>
                    <?php echo $formEntityService->dropDownList($modelEntityDevice,'id_device',array(""=>"Seleccione servicio"),array ('class' => 'form-control')); ?>
                    <?php echo $formEntityService->error($modelEntityDevice,'id_device',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelObject,'id_object'); ?>
                    <?php echo $formEntityService->textField($modelObject,'id_object', array ('class' => 'form-control','placeholder'=>'Digite el identificador del objeto')); ?>
                    <?php echo $formEntityService->error($modelObject,'id_object'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelObject,'object_name'); ?>
                    <?php echo $formEntityService->textField($modelObject,'object_name', array ('class' => 'form-control','placeholder'=>'Digite el nombre del objeto')); ?>
                    <?php echo $formEntityService->error($modelObject,'object_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelObject,'object_description'); ?>
                    <?php echo $formEntityService->textArea($modelObject,'object_description', array ('class' => 'form-control','placeholder'=>'Digite una descripción del objeto')); ?>
                    <?php echo $formEntityService->error($modelObject,'object_description'); ?>
                </div>
                <div class="form-group locationCl">
                    <?php echo $formEntityService->labelEx($modelObjectUbication,'ubication_lat'); ?>
                    <?php echo $formEntityService->textField($modelObjectUbication,'ubication_lat', array ('class' => 'form-control','placeholder'=>'Seleccione latitud')); ?>
                    <?php echo $formEntityService->error($modelObjectUbication,'ubication_lat'); ?>
                </div>
                <div class="form-group locationCl">
                    <?php echo $formEntityService->labelEx($modelObjectUbication,'ubication_long'); ?>
                    <?php echo $formEntityService->textField($modelObjectUbication,'ubication_long', array ('class' => 'form-control','placeholder'=>'Seleccione longitud')); ?>
                    <?php echo $formEntityService->error($modelObjectUbication,'ubication_long'); ?>
                    <?php echo CHtml::link('open dialog', '#', array(
   'onclick'=>'$("#mydialog").dialog("open"); return false;',
));?>
                </div>
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Dialog box 1',
        'autoOpen'=>false,
        'width'=>'40%',
         'height'=>'auto',
        'htmlOptions' => array( 'style' => ' z-index: 1000' ),

    ),
));

    $this->renderPartial("_selectcoords");

$this->endWidget('zii.widgets.jui.CJuiDialog');

// the link that may open the dialog

                ?>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegEntityDevice')); ?>
            </div>
            <?php $this->endWidget(); ?>
          </div>
            
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de magnitudes</h3>
                </div>
                <?php $formMagnitude=$this->beginWidget('CActiveForm', array(
                    'id'=>'magnitude-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
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
                        <?php echo $formMagnitude->dropDownList($modelMagnitudeEntDev,'id_magnitude',CHtml::listData($magnitude, 'id_magnitude', 'magnitude_name'),array ('class' => 'form-control',"prompt"=>"Seleccione magnitud")); ?>
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
                    </div>
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
                    <?php echo $formMagnitude->hiddenField($modelMagnitudeEntDev,'id_entdev'); ?>
                    <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegMagnitude')); ?>
                </div>
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
        <div class="col-md-5">
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
                                <th>Unidad de medida</th>
                                <th>Mínimo de medición</th>
                                <th>Máximo de medición</th>
                                <th>Mínimo para alertar</th>
                                <th>Máximo para alertar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Posición en trama</th>
                                <th>Sensor</th>
                                <th>Magnitud</th>
                                <th>Unidad de medida</th>
                                <th>Mínimo de medición</th>
                                <th>Máximo de medición</th>
                                <th>Mínimo para alertar</th>
                                <th>Máximo para alertar</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
