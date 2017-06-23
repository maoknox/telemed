<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Entitydevice/Entitydevice.js",CClientScript::POS_END);
?>
<section class="content" id="divEntityDevice">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Objeto</h3>
                </div>
            
                <div class="box-body">
                    <?php
                        echo $id_entdev;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>