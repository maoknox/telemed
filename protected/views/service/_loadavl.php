<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<section class="content" id="divDevice">
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableDevice" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Dispositivo</th>
                                <th>Nombre Objeto</th>
                                <th>Descripción del objeto</th>
                                <th>Estado del dispositivo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($devices)){
                                    foreach($devices as $device):
                                        $object="";
                                        $object=$modelObject
                                        ?>
                                        <tr>
                                            <td><?php echo $device["id_device"]?></td>
                                            <td>N.A</td>
                                            <td>N.A</td>
                                            <td>N.A</td>
                                            <td><a href=''>consultar</a></td>
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
                                <th>Estado del dispositivo</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>