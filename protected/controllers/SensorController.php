<?php

class SensorController extends Controller{
     /**
    * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
    * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
    */
    public function filterEnforcelogin($filterChain){
        if(Yii::app()->user->isGuest){
            if(isset($_POST) && !empty($_POST)){
                $response["status"]="nosession";
                echo CJSON::encode($response);
                exit();
            }
            else{
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $filterChain->run();
    }
    /**
     * @return array action filters
     */
    public function filters(){
        return array(
                'enforcelogin',                      
        );
    }
     /**
    * Carga vista que muestra listado de sensores y formulario de los sensores y registra sensores diligenciados en formjlario.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    public function actionRegisterSensor(){
        $modelSensor=new Sensor();
        $modelTypeSensor=new TypeSensor();
        $typeSensor=$modelTypeSensor->findAll();
        $modelFactorSensor=new FactorSensor();
        $listSensors=$modelSensor->searchSensorUnused();
        if(empty($_POST)){
            $this->render('_registerSensor',array(
                "modelSensor"=>$modelSensor,
                "modelTypeSensor"=>$modelTypeSensor,
                "typeSensor"=>$typeSensor,
                "modelFactorSensor"=>$modelFactorSensor,
                "listSensors"=>$listSensors
            ));
        }
        else{
            $modelSensor->attributes=Yii::app()->request->getPost("Sensor");
            $modelSensor->sensor_associated=2;
            $nameForm="sensor-form";
            $this->performAjaxValidation($modelSensor,$nameForm);
            $idSensor=$modelSensor->findByAttributes(array("id_sensor"=>$modelSensor->id_sensor));
            if($modelSensor->validate()){
                if(empty($idSensor)){
                    if($modelSensor->save()){
                        $listSensors=$modelSensor->searchSensorUnused();
                        $response["status"]="exito";
                        $response["msg"]="El sensor ha sido registrado";
                        $response["data"]=$listSensors;
                    }
                    else{
                        $response["status"]="noexito";
                        $response["msg"]="El sensor no ha sido registrado";
                    }
                }
                else{
                    $response["status"]="noexito";
                    $response["msg"]="El Id del sensor ya ha sido registrado con anterioridad, digite otro";
                }
                echo CJSON::encode($response);
            }
            else{
                echo CActiveForm::validate($modelSensor); 
            }
        }
    }
     /**
    * Edita datos de sensor diligenciado en formulario.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    public function actionEditSensor(){
        $modelSensor=  Sensor::model();
        $modelSensor->scenario="editSensor";
        $modelSensor->attributes=Yii::app()->request->getPost("Sensor");
        $nameForm="sensor-form";
        $this->performAjaxValidation($modelSensor,$nameForm);
        if($modelSensor->validate()){
            if($modelSensor->save()){
                $listSensors=$modelSensor->searchSensorUnused();
                $response["status"]="exito";
                $response["msg"]="El sensor ha sido registrado";
                $response["data"]=$listSensors;
            }
            else{
                $response["status"]="noexito";
                $response["msg"]="El sensor no ha sido registrado";
            }
            echo CJSON::encode($response);
        }
        else{
            echo CActiveForm::validate($modelSensor); 
        }
    }
     /**
    * Valida los modelos.
    *
    * @param $model $nameForm 
    *
    * @return CActiveForm:validate listado de errores en validación
    */
    protected function performAjaxValidation($model,$nameForm){
        if(isset($_POST['ajax']) && $_POST['ajax']==$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
}