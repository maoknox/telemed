<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerCssFile('http://api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Avl.js",CClientScript::POS_END);
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="content" id="divAvl">
          <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-5 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Identificación de objeto</h3>
                </div>
                <div class="box-body">
                    <p>Nombre de objeto: <?php echo $object->object_name?></p>
                </div>
            </div>
          <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableObject" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Fecha-hora</td>
                            <?php 
                                foreach($positionsDF as $position):?>
                                <td><?php echo $position["magnitude_name"]?></td>
                                <?php endforeach;
                            ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($dataObjects) && !empty($dataObjects)):
                                foreach($dataObjects as $dataObject):?>
                                    <tr>
                                        <td><?php echo $dataObject["time"]?></td>
                                   <?php foreach($dataObject["data"] as $data):?>
                                        <td><?php echo $data?></td>
                                    <?php endforeach;?>
                                    </tr>
                                 <?php endforeach;endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Fecha-hora</td>
                            <?php 
                                foreach($positionsDF as $position):?>
                                <td><?php echo $position["magnitude_name"]?></td>
                                <?php endforeach;
                            ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-7 connectedSortable">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Ubicación del vehículo</h3>
                    </div>
                    <div class="box-body">
                        <div id="map" style="width: 100%; height: 50em; float:left; display: inline"></div>
                </div>
            </div>
          

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
      </section>
    
 <?php 
 Yii::app()->clientScript->registerScript('cargaDataObject', '
    Avl.idEntdev='.$identdev.'
    Avl.searchDataAvl();
    Avl.iniMap("'.$latitude.'","'.$longitude.'","'.$time.'");
');