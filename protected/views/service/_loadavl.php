<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Service/Avl.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerCssFile('https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.css');
    Yii::app()->clientScript->registerCssFile('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.css');
    Yii::app()->clientScript->registerScriptFile("https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.js",CClientScript::POS_END);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<section class="content" id="divAvl">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dispositivos registrados</h3>
                </div>
                <div class="box-body">
                    <table id="dataTableAvl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Dispositivo</th>
                                <th>Nombre Objeto</th>
                                <th>Descripción del objeto</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($devices)){
                                    foreach($devices as $device):
                                        $object="";
                                        $object=$modelObject->findByPk($device->serialid_object);
                                    ?>
                                        <tr>
                                            <td><?php echo $device->id_device."-".$device->id_entdev?></td>
                                            <td><?php echo $object->object_name?></td>
                                            <td><?php echo $object->object_description?></td>
                                            <td><?php echo CHtml::link('consultar',array('showDataObjectAvl'), array('submit'=>array('showDataObjectAvl'),'params'=>array('id_entdev'=>$device["id_entdev"]))); ?></td>                              
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id='map' style="width: 100%; height: 600px;"></div>
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRecorrido',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	
	<div class="row">
            
		<?php echo CHtml::hiddenField('the_geom'); ?>
	</div>

	<div class="row">
    	
	</div>
		<?php    
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('tpmsgps/crearRuta'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormUsr").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#Mensaje").html("Los datos se han enviado satisfactoriamente");
										$("#formularioRecorrido #formularioRecorrido_es_").html("");                                                    
										$("#formularioRecorrido #formularioRecorrido_es_").hide(); 	
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.resultado);
										$("#formularioRecorrido #formularioRecorrido_es_").html("");                                                    
										$("#formularioRecorrido #formularioRecorrido_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormUsr").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioRecorrido #"+key+"_em_").text(val);                                                    
										$("#formularioRecorrido #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioRecorrido #formularioRecorrido_es_").html(errores);                                                    
									$("#formularioRecorrido #formularioRecorrido_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormUsr").show();
								}
								else{
									if(xhr.status==500){
										$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#Mensaje").html("Hubo un error en la creación del registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormUsr','name'=>'btnFormUsr')
				);
 ?>
 <?php echo $boton;?>

<?php $this->endWidget(); ?>
        </div>
    </div>
</section>