<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/charts/charts.css');
//    Yii::app()->clientScript->registerCssFile("https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"); 
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/modules/series-label.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/LecturaAgua/ReporteAgua.js",CClientScript::POS_END);
?>
<section class="content" id="sectionReportesPeriodo"> 
    <h1>Reportes por periodo</h1>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
//print_r($services);
?>
    <div class="row">
        <!-- left column -->
        <div class="col-md-4 col-md-offset-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">1. Seleccione geografía y empresa</h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <?php $formEntityService=$this->beginWidget('CActiveForm', array(
                    'id'=>'consultalect-form',
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>false,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    )
            )); ?>
            <div class="box-body">
                <?php echo  $formEntityService->errorSummary(array($modelDepartamento,$modelMunicipio,$modelEmpresa),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelDepartamento,'Departamento'); ?>
                    <?php echo $formEntityService->dropDownList($modelDepartamento,'id_departamento', CHtml::listData($departamentos, "id_departamento", "nombre_departamento"),array ('class' => 'form-control','prompt'=>'- Seleccione un departamento -')); ?>
                    <?php echo $formEntityService->error($modelDepartamento,'id_departamento',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <?php echo $formEntityService->labelEx($modelMunicipio,'Municipio'); ?>
                    <?php echo $formEntityService->dropDownList($modelMunicipio,'id_municipio', array(""=>"Seleccione Departamento"),array ('class' => 'form-control')); ?>
                    <?php echo $formEntityService->error($modelMunicipio,'id_municipio',array("class"=>"errorMessage")); ?>
                </div>
                <div class="form-group">
                    <label for="periodo">Periodo</label>
                    <select class="form-control" name="Anio[id_anio]" id="Anio_id_anio">
                        <option value="">- Seleccione año -</option>
                        <option value="2017">2017</option>
                    </select>         
                </div>
                <div class="form-group">
                    <label for="periodo">Periodo</label>
                    <select class="form-control" name="Periodo[id_periodo]" id="Periodo_id_periodo">
                        <option value="">- Seleccione un periodo -</option>
                        <option value="1">Periodo 1</option>
                        <option value="2">Periodo 2</option>
                        <option value="3">Periodo 3</option>
                        <option value="4">Periodo 4</option>
                        <option value="5">Periodo 5</option>
                        <option value="6">Periodo 6</option>
                    </select>         
                </div>
                <div class="form-group  row">
                    <div class="col-md-8">
                    <label for="separador">Seleccionar separador para el archivo csv ; o ,</label><br>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control " name="Separador[id_separador]" id="Separador_id_separador">
                            <option value="1">;</option>
                            <option value="2">,</option>
                        </select>  
                    </div>
                </div>
                <div class="box-footer">
                    <?php echo CHtml::button('Generar reporte', array ('class' => 'btn btn-primary','id'=>'btnRepoLecturas')); ?>
                </div>
            </div>
            <?php
            $this->endWidget()?>
          </div>
        </div>
    </div>
</section> 

