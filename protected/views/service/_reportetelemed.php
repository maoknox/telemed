<section class="content" id="divChartsRepo">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Consultar reporte</h3>
                </div>
                <div class="box-body">
                    <?php echo CHtml::beginForm('showReportObjectTelemed','post',array('id'=>'formularioRep','name'=>'formularioRep'));?>
                        <div class="box">
                            <div class="box-header">                
                                <h5>Fecha inicial</h5>
                            </div>
                            <div class="box-content" >  
                                <input type="text" id="fechaInicialRepo" name="ConsRep[fecha_inicial]">
                            </div>
                        </div>
                        <div class="box">
                           <div class="box-header">                
                               <h5>Fecha final</h5>
                           </div>
                           <div class="box-content" >  
                               <input type="text" id="fechaFinalRepo" name="ConsRep[fecha_final]">
                           </div>
                        </div>
                        <div class="box">
                           <div class="box-content" > 
                               <input type="hidden" id="id_entdev" name="ConsRep[id_entdev]" value="<?php echo $identdev?>">
                               <?php echo CHtml::submitButton('Generar'); ?>
                           </div>
                       </div>
                    <?php echo CHtml::endForm() ; ?>
                </div>
            </div>
        </div>
    </div>
</section>
