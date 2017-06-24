<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Person/Person.js",CClientScript::POS_END);
?>
<section class="content" id="divPerson">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro de persona</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formPerson=$this->beginWidget('CActiveForm', array(
                    'id'=>'person-form',
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
                <?php echo  $formPerson->errorSummary(array($modelPerson,$modelUser,$modelEntityPerson),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelUser,'id_role'); ?>
                    <?php echo $formPerson->dropDownList($modelUser,'id_role',CHtml::listData($dataRole, 'id_role', 'role_label'),array ('class' => 'form-control', 'prompt'=>'Seleccione rol de usuario')); ?>
                    <?php echo $formPerson->error($modelUser,'id_role',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelPerson,'id_typedocument'); ?>
                    <?php echo $formPerson->dropDownList($modelPerson,'id_typedocument',CHtml::listData($dataTypeDocument, 'id_typedocument', 'document_label'),array ('class' => 'form-control', 'prompt'=>'Seleccione el tipo de documento')); ?>
                    <?php echo $formPerson->error($modelPerson,'id_typedocument',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelPerson,'person_numberid'); ?>
                    <?php echo $formPerson->textField($modelPerson,'person_numberid', array ('class' => 'form-control','placeholder'=>'Digite el número de identificación de la persona')); ?>
                    <?php echo $formPerson->error($modelPerson,'person_numberid'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelPerson,'person_name'); ?>
                    <?php echo $formPerson->textField($modelPerson,'person_name', array ('class' => 'form-control','placeholder'=>'Digite el nombre de la persona')); ?>
                    <?php echo $formPerson->error($modelPerson,'person_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelPerson,'person_lastname'); ?>
                    <?php echo $formPerson->textField($modelPerson,'person_lastname', array ('class' => 'form-control','placeholder'=>'Digite el apellido de la persona')); ?>
                    <?php echo $formPerson->error($modelPerson,'person_lastname'); ?>
                </div>
                <div class="form-group">
                    <?php echo $formPerson->labelEx($modelPerson,'person_email'); ?>
                    <?php echo $formPerson->textField($modelPerson,'person_email', array ('class' => 'form-control','placeholder'=>'Digite el correo electrónico')); ?>
                    <?php echo $formPerson->error($modelPerson,'person_email'); ?>
                </div>
                <div class="form-group" id="divEntity">
                    <?php echo $formPerson->labelEx($modelEntityPerson,'id_entity'); ?>
                    <?php echo CHtml::textField('nameEntity', '',array('id'=>'nameEntity','class' => 'form-control','placeholder'=>'Digite nombre o identificación de la empresa')); ?>
                    <?php echo $formPerson->hiddenField($modelEntityPerson,'id_entity', array ('class' => 'form-control','placeholder'=>'Seleccione una empresa')); ?>
                    <?php echo $formPerson->error($modelEntityPerson,'id_entity'); ?>
                </div>
            </div>
              <!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::button('Registrar Persona', array ('class' => 'btn btn-primary','id'=>'btnRegPerson')); ?>
            </div>
            <?php $this->endWidget(); ?>
          </div>
            
        </div>
    </div>
</section>