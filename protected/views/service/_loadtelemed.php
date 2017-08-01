<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerCssFile('http://api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("http://api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Telemedition.js",CClientScript::POS_END);
?>
<section class="content" id="divTelemed">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableTelemed" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Dispositivo</th>
                                <th>Nombre Objeto</th>
                                <th>Descripción del objeto</th>
                                <th>Anclado al inicio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($devices)){
                                    foreach($devices as $pk=>$device):
                                        $object=$modelObject->findByPk($device->serialid_object);
                                        $modelObjectUbication=  ObjectUbication::model();
                                        $resModel=$modelObjectUbication->findByAttributes(array("serialid_object"=>$device->serialid_object));
                                        $ubications[$pk]["lat"]=$resModel->ubication_lat;
                                        $ubications[$pk]["long"]=$resModel->ubication_long;
                                        $ubications[$pk]["nameobj"]=$object->object_name;
                                        $ubications[$pk]["id_entdev"]=$device["id_entdev"];
                                    ?>
                                        <tr>
                                            <td><?php echo $device->id_device."-".$device->id_entdev?></td>
                                            <td><?php echo $object->object_name?></td>
                                            <td><?php echo $object->object_description?></td>
                                            <td>
                                                <?php 
                                                    
                                                    if(empty($device->entdev_anchorage) || $device->entdev_anchorage==2){
                                                        $checked=false;
                                                        $value=1;
                                                    }
                                                    elseif($device->entdev_anchorage==1){
                                                        $checked=true;
                                                        $value=2;
                                                    }
                                                ?>
                                                <?php echo CHtml::CheckBox('entdev_anchorage',$checked, array ('id'=>$device->id_entdev,'value'=>$value,'onClick'=>"js:Telemedition.anchorage('".$device->id_entdev."');")); ?> 
                                            </td>
                                            <td><?php echo CHtml::link('consultar',array('showDataObjectTelemed'), array('submit'=>array('showDataObjectTelemed'),'params'=>array('id_entdev'=>$device["id_entdev"]))); ?></td>                              
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
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Ubicación de objetos</h3>
                </div>
                <div class="box-body">
                    <div id="map" style="width: 100%; height: 50em; float:left; display: inline"></div>
                </div>
            </div>
        </div>
    </div>
</section>
 <?php 
 Yii::app()->clientScript->registerScript('cargaDataObject', '
    Telemedition.iniMap('.CJSON::encode($ubications).');');