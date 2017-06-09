<?php

class DeviceController extends Controller{
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
    /*
     * Registra dispositivo
     * 
     */
    public function actionRegisterDevice(){
        $modelDevice=new Device();
        $devices=$modelDevice->searchDeviceAll();
        $modelServiceDevice=new ServiceDevice();
        $serviceDevices=$modelServiceDevice->searchServiceDevice($devices);
        $modelTypDevice=  TypeDevice::model()->findAll();
        $modelStateDevice=  StateDevice::model()->findAll();
        $modelService=  Service::model()->findAll();
        
        if(empty($_POST)){
            $this->render('_registerDevice',array(
                "modelDevice"=>$modelDevice,
                "devices"=>$serviceDevices,
                "modelServiceDevice"=>$modelServiceDevice,
                "modelTypDevice"=>$modelTypDevice,
                "modelStateDevice"=>$modelStateDevice,
                "modelService"=>$modelService
            ));
        }
        else{
            $modelDevice->attributes=Yii::app()->request->getPost("Device");
            $modelDevice->device_associated=2;
            $modelServiceDevice->attributes=Yii::app()->request->getPost("ServiceDevice");
            $modelServiceDevice->id_device=$modelDevice->id_device;
            $nameForm="device-form";
            $services=Yii::app()->request->getPost("ServiceDevice");
            
            $this->performAjaxValidation(array($modelDevice,$modelServiceDevice),$nameForm);
            if($modelDevice->validate()&&$modelServiceDevice->validate()){
                $device=$modelDevice->findByPk($modelDevice->id_device);
                if(empty($device)){
                    $transaction=Yii::app()->db->beginTransaction();
                    try{
                        $modelDevice->save();
                        foreach($services["id_service"] as $service){
                            $modelServiceDevice=new ServiceDevice();
                            $modelServiceDevice->id_device=$modelDevice->id_device;
                            $modelServiceDevice->id_service=$service;
                            $modelServiceDevice->save();
                        }
                        $transaction->commit();
                        $devices=$modelDevice->searchDeviceAll();
                        $serviceDevices=$modelServiceDevice->searchServiceDevice($devices);
                        $response["status"]="exito";
                        $response["msg"]="El dispositivo ha sido registrado";
                        $response["data"]=$serviceDevices;
                    }
                    catch(ErrorException $e){
                        $transaction->rollback();
                        throw new CHttpException($e->get,$e->getMessage());
                    }
                }
                else{
                    $response["status"]="noexito";
                    $response["msg"]="El identificador del dispositivo ya ha esta registrado";
                }
                echo CJSON::encode($response);
            }
            else{
                echo CActiveForm::validate(array($modelDevice,$modelServiceDevice));                
            }
        }
    }
    /*
     * Edita dispositivo 
     */
    public function actionEditDevice(){
        $modelDevice=Device::model();
        $modelDevice->attributes=Yii::app()->request->getPost("Device");
        $modelServiceDevice=  ServiceDevice::model();
        $modelServiceDevice->attributes=Yii::app()->request->getPost("ServiceDevice");
        $modelServiceDevice->id_device=$modelDevice->id_device;
        $transaction=Yii::app()->db->beginTransaction();
        $modelServiceDevice->deleteAllByAttributes(array("id_device"=>$modelServiceDevice->id_device));
        $modelServiceDevice->id_device=$modelDevice->id_device;
        $nameForm="device-form";
        $this->performAjaxValidation(array($modelDevice,$modelServiceDevice),$nameForm);
        $services=Yii::app()->request->getPost("ServiceDevice");
        $idDevice=$modelDevice->findByPk($modelDevice->id_device);
        if($modelDevice->validate() && $modelServiceDevice->validate()){
            if(!empty($idDevice)){
                try{
                    $modelDevice->save();
                    foreach($services["id_service"] as $service){
                        $modelServiceDevice=new ServiceDevice();
                        $modelServiceDevice->id_device=$modelDevice->id_device;
                        $modelServiceDevice->id_service=$service;
                        $modelServiceDevice->save();
                    }
                    $transaction->commit();
                    $devices=$modelDevice->searchDeviceAll();
                    $serviceDevices=$modelServiceDevice->searchServiceDevice($devices);
                    $response["status"]="exito";
                    $response["msg"]="El dispositivo ha sido registrado";
                    $response["data"]=$serviceDevices;
                }
                catch(ErrorException $e){
                    $transaction->rollback();
                    throw new CHttpException($e->get,$e->getMessage());
                }
            }
            else{
                $response["status"]="noexito";
                $response["msg"]="No existe un dispositivo con el id registrado";
            }
            echo CJSON::encode($response);
        }
        else{
            echo CActiveForm::validate(array($modelDevice,$modelServiceDevice)); 
        }
    }
    /**
    * Valida los modelos.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    protected function performAjaxValidation($model,$nameForm){
        if(isset($_POST['ajax']) && $_POST['ajax']==$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
}