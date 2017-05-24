<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Service.js",CClientScript::POS_END);
?>
<section class="content" id="divEntitiService">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro de servicio a empresa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formEntityService=$this->beginWidget('CActiveForm', array(
                    'id'=>'entityservice-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    ),
//                    'htmlOptions'=>array(
//                        'onChange'=>'js:estadoGuarda=false'
//                    )
            )); ?>
            <div class="box-body">
                <?php echo  $formEntityService->errorSummary($modelEntityService,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group" id="divEntity">
                    <?php echo $formEntityService->labelEx($modelEntityService,'id_entity'); ?>
                    <?php echo CHtml::textField('nameEntity', '',array('id'=>'nameEntity','class' => 'form-control','placeholder'=>'Digite nombre o identificación de la empresa')); ?>
                    <?php echo $formEntityService->hiddenField($modelEntityService,'id_entity', array ('class' => 'form-control','placeholder'=>'Seleccione una empresa')); ?>
                    <?php echo $formEntityService->error($modelEntityService,'id_entity'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelEntityService,'id_service'); ?>
                    <?php echo $formEntityService->dropDownList($modelEntityService,'id_service',CHtml::listData($modelService, 'id_service', 'service_name'),array ('class' => 'form-control', 'prompt'=>'Seleccione servicio')); ?>
                    <?php echo $formEntityService->error($modelEntityService,'id_service',array("class"=>"errorMessage")); ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegEntityService')); ?>
            </div>
            <?php $this->endWidget(); ?>
          </div>
            
        </div>
    </div>
</section>
