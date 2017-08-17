<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entitydevice/Entitydevice.js",CClientScript::POS_END);
?>
<section class="content" id="divMagnitude">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Magnitudes</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableEntityMagnitude" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id trama</th>
                                <th>trama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($datamace)):?>
                                <?php foreach($datamace as $data):?>
                                <tr>
                                    <td><?php echo $data["id_datamace"]?></td>
                                    <td><?php echo $data["datamace"]?></td>
                                </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>id trama</th>
                                <th>trama</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>