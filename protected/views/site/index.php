<?php

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/DataForAnch.js",CClientScript::POS_END);
//    print_r($services);
?>
<section class="content" id="sectionIndex"> 
    <h1>Bienvenido a <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
//print_r($services);
if(!empty($services)):
    foreach ($services as $service):?>
        <div class="row ">
            
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Servicio: <?php echo $service["service_name"]?></h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                              <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php
                        $anch=1;
                            $objectAnchoraged=  EntityDevice::model()->searchObjectAnchorage($service["id_service"]);
                            if(empty($objectAnchoraged)):
                                echo "No hay objetos anclado para este servicio";
                            $anch=2;
                            else: foreach($objectAnchoraged as $object):?>
                                    <div class="col-md-4" id="service<?= $object["id_entdev"]?>">
                                        <div class="box box-primary">
                                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                                <h3 class="box-title">Objeto: <?= $object["object_name"]?></h3><br>
                                                <div class="pull-right box-tools">
                                                    
                                                    <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                                                      <i class="fa fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <?php if(!empty($object["data"])):?>
                                                    Fecha de última medición: <div id="fechaMed<?= $object["id_entdev"]?>"><?= $object["time"]?></div>
                                                    <table id="dataTableObject<?php echo $object["id_entdev"]?>" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Magnitud</th>
                                                                    <th>Medición</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($object["positions"] as $pkpos=>$position):?>
                                                                <tr>
                                                                    <td><?php echo $position["magnitude_name"]?></td>
                                                                    <td id="<?= $position["magnitude_code"]?>"><?php echo $object["data"][$pkpos]?></td>
                                                                </tr>

                                                                <?php endforeach;?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Magnitud</th>
                                                                    <th>Medición</th>
                                                                </tr>
                                                            </tfoot>
                                                    </table>
                                                    <?php else:
                                                        echo "Este objeto aún no tiene mediciones";
                                                    endif;?>
                                                
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endforeach;
//                                print_r($objectAnchoraged);
                            endif;
                        ?>
                    </div>
                </div>
            </div>
            <input type="hidden" class="<?php echo $service["service_code"]?>" value="<?php echo $anch?>">
        </div>
    <?php endforeach;
endif;
?>
</section> 
<?php 
//$oauthToken="sadfasdfasd";
//    Yii::app()->clientScript->registerScript('cargaMagnitudeAJs', '
//       localStorage.setItem("lastname", "'.$oauthToken.'");
//   ');
