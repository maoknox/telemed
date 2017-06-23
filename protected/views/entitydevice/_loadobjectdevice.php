<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entitydevice/Entitydevice.js",CClientScript::POS_END);
?>
<section class="content" id="divLoadObj">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Magnitudes</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableObject" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre Empresa</th>
                                <th>Nombre servicio</th>
                                <th>Id del dispositivo</th>
                                <th>Id de objeto</th>
                                <th>Nombre de objeto</th>
                                <th>Descripción de objeto</th>
                                <th>Editar Objeto</th>
                                <th>Editar Magnitudes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($objects):
                                    foreach($objects as $object):?>
                                        <tr>
                                            <td><?php echo $object["entity_name"]?></td>
                                            <td><?php echo $object["service_name"]?></td>
                                            <td><?php echo $object["id_device"]?></td>
                                            <td><?php echo $object["id_object"]?></td>
                                            <td><?php echo $object["object_name"]?></td>
                                            <td><?php echo $object["object_description"]?></td>
                                            <td><?php echo CHtml::link('editar',array('editObject'), array('submit'=>array('editObject'),'params'=>array('id_entdev'=>$object["id_entdev"]))); ?></td>
                                            <td><?php echo CHtml::link('editar',array('editMagnitude'), array('submit'=>array('editMagnitude'),'params'=>array('id_entdev'=>$object["id_entdev"]))); ?></td>
                                        </tr>
                                    <?php  endforeach;
                                endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre Empresa</th>
                                <th>Nombre servicio</th>
                                <th>Id del dispositivo</th>
                                <th>Id de objeto</th>
                                <th>Nombre de objeto</th>
                                <th>Descripción de objeto</th>
                                <th>Editar Objeto</th>
                                <th>Editar Magnitudes</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
