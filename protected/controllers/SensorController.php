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

        }
    }
}