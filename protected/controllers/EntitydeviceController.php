<?php

class EntitydeviceController extends Controller{
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
    public function actionIndex(){
            $this->render('index');
    }

    public function actionRegisterObjectDevice(){
        $modelEntityDevice=new EntityDevice();
        $modelObject=new Object();
        $modelObjectUbication=new ObjectUbication();
        $modelMagnitudeEntDev=new MagnitudeEntdev();
        if(empty($_POST)){
            $magnitude=  Magnitude::model()->findAll();
            $meassSystem=  MeasurementSystem::model()->findAll();
            $country=  Country::model()->findAll();
            $state=  State::model()->findAll();
            $city=  City::model()->findAll();
            $service=  Service::model()->findAll();
            $this->render('_registerobjectdevice',array(
                "modelEntityDevice"=>$modelEntityDevice,
                "modelObject"=>$modelObject,
                "modelObjectUbication"=>$modelObjectUbication,
                "modelMagnitudeEntDev"=>$modelMagnitudeEntDev,
                "magnitude"=>$magnitude,
                "meassSystem"=>$meassSystem,
                "country"=>$country,
                "state"=>$state,
                "city"=>$city,
                "service"=>$service
            ));
        }
        else{
            $modelObject->attributes=Yii::app()->request->getPost("Object");
            $modelEntityDevice->attributes=Yii::app()->request->getPost("EntityDevice");
            $modelEntityDevice->serialid_object=0;
            $nameForm="entityservice-form";
            $this->performAjaxValidation(array($modelObject,$modelEntityDevice),$nameForm);
            if($modelObject->validate()&&$modelEntityDevice->validate()){
                $transaction=Yii::app()->db->beginTransaction();
                try{
                    $modelObject->save();
                    $modelEntityDevice->serialid_object=$modelObject->serialid_object;
                    $modelEntityDevice->save();
                    $transaction->commit();
                    $response["status"]="exito";
                    $response["msg"]="Dispositivo registrado satisfactoriamete";
                    echo CJSON::encode($response);
                }
                catch(ErrorException $e){
                    $transaction->rollback();
                    throw new CHttpException($e->get,$e->getMessage());
                }
            }
            else{
                echo CActiveForm::validate(array($modelObject,$modelEntityDevice));
            }
        }
    }
    public function actionRegisterMagnitude(){
        $modelMagnitude=new MagnitudeEntdev();
        $postMagnitude=Yii::app()->request->getPost("MagnitudeEntdev");
        $modelMagnitude->attributes=$postMagnitude;
        $response["data"]="";
        if($modelMagnitude->validate()){
            $position=$modelMagnitude->findByAttributes(array("id_entdev"=>$modelMagnitude->id_entdev,"position_dataframe"=>$modelMagnitude->position_dataframe));
            if(!empty($position)){
                $response["status"]="noexito";
                $response["msg"]="Esta posición ya tiene una magnitud, digite otra";
            }
            else{
                $magnitude=$modelMagnitude->findByAttributes(array("id_entdev"=>$modelMagnitude->id_entdev,"id_magnitude"=>$modelMagnitude->id_magnitude));
                if(!empty($magnitude)){
                    $response["status"]="noexito";
                    $response["msg"]="Magnitud ya registrada para este objeto";
                }
                else{
                    if($modelMagnitude->save()){
                        $response["status"]="exito";
                        $response["msg"]="Magnitud asociada al objeto";
                        $magnitudes=$modelMagnitude->searchMagnitudesByObject($modelMagnitude->id_entdev);
                        $response["data"]=$magnitudes;
                    }
                    else{
                        $response["status"]="noexito";
                        $response["msg"]="No ha sido posible asociar la magnitud";
                    }
                }
            }
            echo CJSON::encode($response);
        }
        else{
            echo CActiveForm::validate($modelMagnitude);
        }
    }
    public function actionSearchService(){
        $idEntity=Yii::app()->request->getPost("idEntity");
        $modeloEntity= Entity::model();
        $services=$modeloEntity->searchService($idEntity);
        echo CJSON::encode($services);
    }
    public function actionSearchDevice(){
        $idService=Yii::app()->request->getPost("idService");
        $modeloDevice= Device::model();
        $devices=$modeloDevice->searchDevice($idService,"OPERATIVO","2");
        echo CJSON::encode($devices);
    }
    /**
    * Valida los modelos.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    protected function performAjaxValidation($model,$nameForm){
        if(isset($_POST['ajax']) && $_POST['ajax']===$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
}