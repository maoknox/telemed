<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/charts/charts.css');
//    Yii::app()->clientScript->registerCssFile("https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"); 
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/modules/series-label.js",CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/LecturaAgua/LecturaAgua.js",CClientScript::POS_END);
?>
<section class="content" id="sectionLectura"> 
    <h1>Bienvenido a <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
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
                    <?php echo $formEntityService->labelEx($modelEmpresa,'Empresa'); ?>
                    <?php echo $formEntityService->dropDownList($modelEmpresa,'id_empresa', array(""=>"Seleccione Municipio"),array ('class' => 'form-control')); ?>
                    <?php echo $formEntityService->error($modelEmpresa,'id_empresa',array("class"=>"errorMessage")); ?>
                </div>
                <div class="box-footer">
                    <?php echo CHtml::button('Consultar', array ('class' => 'btn btn-primary','id'=>'btnConsLecturas')); ?>
                </div>
            </div>
            <?php
            
            $this->endWidget()?>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">2. Seleccione un medidor</h3>
                    <div class="box-tools pull-right">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" id="dataTableMedidorDiv">
                    <table id="dataTableMedidor" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                               
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">3. Seleccione una fecha de aforo</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <label>Seleccione fecha de aforo</label> 
                            <select id="fechaLectMed" class="form-control">
                                <option value="">Seleccione Medidor</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="divDatosLectura" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box ">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Datos generales</h3>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body" style=" overflow-x: scroll;">
                                      <table class="table table-bordered cl-datos-med" id="datosGeneralesMed">
                                          <thead>
                                              <tr>
                                              </tr>
                                          </thead>
                                          <tbody>
                                                <tr>
                                                </tr>
                                          </tbody>
                                      </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                          <div class="box-header with-border">
                                            <h3 class="box-title">Histórico lecturas</h3>
                                          </div>
                                          <!-- /.box-header -->
                                          <div class="box-body">
                                              <table class="table table-bordered cl-datos-med" id="histLecMed">
                                                  <thead>
                                                      <tr>

                                                      </tr>
                                                  </thead>
                                                  <tbody>

                                                  </tbody>
                                              </table>
                                          </div>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                          <div class="box-header with-border">
                                            <h3 class="box-title">Histórico consumo</h3>
                                          </div>
                                           /.box-header 
                                          <div class="box-body">
                                              <table class="table table-bordered cl-datos-med" id="histConsMed">
                                                  <thead>
                                                      <tr>

                                                      </tr>
                                                  </thead>
                                                  <tbody>

                                                  </tbody>
                                              </table>
                                          </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">                
                                        <h5 class="box-title">Gráfico</h5>
                                    </div>
                                    <div class="box-body" >  
                                        <div id="g1"></div>   
                                    </div>
                                </div>
                            </div>
                        
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section> 

