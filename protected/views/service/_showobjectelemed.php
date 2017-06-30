<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Telemedition.js",CClientScript::POS_END);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="content" id="divTelemed">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Identificación de objeto</h3>
                </div>
                <div class="box-body">
                    <p>Nombre de objeto: <?php echo $object->object_name?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableObject" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <?php 
                                foreach($positionsDF as $position):?>
                                <td><?php echo $position["magnitude_name"]?></td>
                                <?php endforeach;
                            ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($magnitudes as $magnitud):?>
                                    <tr>
                                   <?php foreach($magnitud as $data):?>
                                        <td><?php echo $data?></td>
                                    <?php endforeach;?>
                                    </tr>
                                 <?php endforeach;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
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
        </div>
    </div>
</section>
 <?php 
 Yii::app()->clientScript->registerScript('cargaDataObject', '
     Telemedition.idEntdev='.$identdev.'
    Telemedition.searchDataTelemed();
');