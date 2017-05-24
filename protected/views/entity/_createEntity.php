<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entity/Entity.js",CClientScript::POS_END);
?>
<section class="content" id="divEntity">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
             <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro de empresa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'entity-form',
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
                <?php echo  $form->errorSummary($modelEntity,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
                    <?php echo $form->labelEx($modelEntity,'id_typeent'); ?>
                    <?php echo $form->dropDownList($modelEntity,'id_typeent',CHtml::listData($modelTypeEntity, 'id_typeent', 'typeent_name'),array ('class' => 'form-control', 'prompt'=>'Seleccione tipo de empresa')); ?>
                    <?php echo $form->error($modelEntity,'id_typeent'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($modelEntity,'entity_number'); ?>
                    <?php echo $form->textField($modelEntity,'entity_number', array ('class' => 'form-control','placeholder'=>'Digite el número de identificación de la empresa')); ?>
                    <?php echo $form->error($modelEntity,'entity_number'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($modelEntity,'entity_name'); ?>
                    <?php echo $form->textField($modelEntity,'entity_name', array ('class' => 'form-control','placeholder'=>'Digite el nombre de la empresa')); ?>
                    <?php echo $form->error($modelEntity,'entity_name'); ?>
                </div>
                <div class="form-group" id="entityLastName">
                    <?php echo $form->labelEx($modelEntity,'entity_lastname'); ?>
                    <?php echo $form->textField($modelEntity,'entity_lastname', array ('class' => 'form-control','placeholder'=>'Digite el apellido de la empresa')); ?>
                    <?php echo $form->error($modelEntity,'entity_lastname'); ?>
                </div>
                
                  <div class="form-group" >
                    <?php echo $form->labelEx($modelEntity,'entity_address'); ?>
                    <?php echo $form->textField($modelEntity,'entity_address', array ('class' => 'form-control','placeholder'=>'Digite la dirección de la empresa')); ?>
                    <?php echo $form->error($modelEntity,'entity_address'); ?>
                </div>
            </div>
              <!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::button('Registrar Empresa', array ('class' => 'btn btn-primary','id'=>'btnRegEntity')); ?>
            </div>
            <?php $this->endWidget(); ?>
          </div>
        </div>
        <!--formulario de persona-->
        <div class="col-md-6" id="divRegCityEntity">
             <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro de ubicación de empresa (Puede registrar varias ciudades)</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $cityEntityForm=$this->beginWidget('CActiveForm', array(
                    'id'=>'cityEntity-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    ),
//                    'htmlOptions'=>array(
//                        'onChange'=>'js:estadoGuarda=false'
//                    )
            )); ?>
            <div class="box-body" id="divCityEntity">
                <?php echo  $cityEntityForm->errorSummary($modelCityEntity,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
                    <?php echo $cityEntityForm->labelEx($modelCountry,'id_country'); ?>
                    <?php echo $cityEntityForm->dropDownList($modelCountry,'id_country',CHtml::listData($dataCountry, 'id_country', 'country_name'),array ('class' => 'form-control', 'prompt'=>'Seleccione País')); ?>
                    <?php echo $cityEntityForm->error($modelCountry,'id_country',array("class"=>"errorMessage errorCityEntity")); ?>
                </div>
                <div class="form-group">
                    <?php echo $cityEntityForm->labelEx($modelState,'id_state'); ?>
                    <?php echo $cityEntityForm->dropDownList($modelState,'id_state',array(""=>"Seleccione un país"),array ('class' => 'form-control')); ?>
                    <?php echo $cityEntityForm->error($modelState,'id_state',array("class"=>"errorMessage errorCityEntity")); ?>
                </div>
                <div class="form-group">
                    <?php echo $cityEntityForm->labelEx($modelCityEntity,'id_city'); ?>
                    <?php echo $cityEntityForm->dropDownList($modelCityEntity,'id_city',array(""=>"Seleccione un departamento"),array ('class' => 'form-control')); ?>
                    <?php echo $cityEntityForm->error($modelCityEntity,'id_city',array("class"=>"errorMessage errorCityEntity")); ?>
                    <?php echo $cityEntityForm->hiddenField($modelCityEntity,'id_entity', array ('class' => 'form-control')); ?>
                </div>
            </div>
              <!-- /.box-body -->
            <div class="box-footer">
                <?php echo CHtml::button('Registrar Ciudad', array ('class' => 'btn btn-primary','id'=>'btnRegCityEntity')); ?>
            </div>
            <?php $this->endWidget(); ?>
          </div>
        </div>
    </div>
</section>