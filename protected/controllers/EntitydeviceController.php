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
    /**
    * Carga datos de objetos y renderiza vista para cargar datos en datatable
    */
    public function actionLoadDataEntityService(){
        $modelEntityDevice=  EntityDevice::model();
        $objects=$modelEntityDevice->searchAllObjects();
        $this->render("_loadobjectdevice",array("objects"=>$objects));
    }
    /**
    * Carga datos de objetos y renderiza vista para cargar datos en datatable
    */
    public function actionEditObject(){
        if(!empty($_POST)){
            $idEntdev=Yii::app()->request->getPost("id_entdev");
            $this->render("_editobject",array("id_entdev"=>$idEntdev));
        }
        else{
            throw new Exception("No se ha especificado id de objeto");
        }
    }
    /**
    * Carga datos de objetos y renderiza vista para modificar magnitudes de objeto
    */
    public function actionEditMagnitude(){
        if(!empty($_POST)){
            $idEntdev=Yii::app()->request->getPost("id_entdev");
            $modelMagnitudeEntdev= MagnitudeEntdev::model();
            $typemagnitudes=  Magnitude::model()->findAll();
            $modelSensor=Sensor::model();
            $sensors=$modelSensor->searchSensorUnused();
            $meassSystem=  MeasurementSystem::model()->findAll();
            $magnitudes=$modelMagnitudeEntdev->searchMagnitudesByObject($idEntdev);
            $this->render("_editmagnitude",array(
                "id_entdev"=>$idEntdev,
                "magnitudes"=>$magnitudes,
                "modelMagnitudeEntDev"=>$modelMagnitudeEntdev,
                "typemagnitudes"=>$typemagnitudes,
                "sensors"=>$sensors,
                "meassSystem"=>$meassSystem
            ));
        }
        else{
            $modelEntityDevice=  EntityDevice::model();
            $objects=$modelEntityDevice->searchAllObjects();
            $this->render("_loadobjectdevice",array("objects"=>$objects));
        }
    }
    
    /**
    * Carga formulario de regsitro de objeto y si variable $_POST no está vacía registra objeto de acuerdo al cliente.
    *
    */
    public function actionRegisterObjectDevice(){
        $modelEntityDevice=new EntityDevice();
        $modelObject=new Object();
        $modelObjectUbication=new ObjectUbication();
        $modelMagnitudeEntDev=new MagnitudeEntdev();
        $modelSensor=  Sensor::model();
        if(empty($_POST)){
            $magnitude=  Magnitude::model()->findAll();
            $meassSystem=  MeasurementSystem::model()->findAll();
            $country=  Country::model()->findAll();
            $state=  State::model()->findAll();
            $city=  City::model()->findAll();
            $service=  Service::model()->findAll();
            $sensors=$modelSensor->searchSensorUnused();
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
                "service"=>$service,
                "sensors"=>$sensors
            ));
        }
        else{
            $modelObject->attributes=Yii::app()->request->getPost("Object");
            $modelEntityDevice->attributes=Yii::app()->request->getPost("EntityDevice");
            $modelEntityDevice->serialid_object=0;
            $nameForm="entitydevice-form";
            $this->performAjaxValidation(array($modelObject,$modelEntityDevice),$nameForm);
            if($modelObject->validate()&&$modelEntityDevice->validate()){
                $device=  Device::model()->findByAttributes(array("id_device"=>$modelEntityDevice->id_device,"device_associated"=>1));
                if(empty($device)){
                    $transaction=Yii::app()->db->beginTransaction();
                    try{
                        $modelObject->save();
                        $modelEntityDevice->serialid_object=$modelObject->serialid_object;
                        $modelEntityDevice->save();
                        $modelDevice = Device::model()->findByPk($modelEntityDevice->id_device);
                        $modelDevice->device_associated=1;
                        $modelDevice->update(array('device_associated'));
                        $transaction->commit();
                        $response["status"]="exito";
                        $response["msg"]="Objeto registrado satisfactoriamete";
                        $response["id_entdev"]=$modelEntityDevice->id_entdev;
                    }
                    catch(ErrorException $e){
                        $transaction->rollback();
                        throw new CHttpException($e->get,$e->getMessage());
                    }
                }
                else{
                    $response["status"]="noexito";
                    $response["msg"]="El dispositivo con id ".$modelEntityDevice->id_device." ha sido asociado a otro objeto, seleccione otro";
                }
                echo CJSON::encode($response);
            }
            else{
                echo CActiveForm::validate(array($modelObject,$modelEntityDevice));
            }
        }
    }
    /**
    * Registra magnitud de objeto registrado.
    *
    * @param type array $postMagnitude captura el array del formulario de la magnitud.
    *
    * @return $response json del listado de dispositivos
    */
    public function actionRegisterMagnitude(){
        $modelMagnitude=new MagnitudeEntdev();
        $postMagnitude=Yii::app()->request->getPost("MagnitudeEntdev");
        $modelMagnitude->attributes=$postMagnitude;
        $modelSensor=  Sensor::model();
        $response["data"]="";
        $sensor="";
        if($modelMagnitude->validate()){
            $position=$modelMagnitude->findByAttributes(array("id_entdev"=>$modelMagnitude->id_entdev,"position_dataframe"=>$modelMagnitude->position_dataframe));
            if(!empty($modelMagnitude->serialid_sensor)){    
                $sensor=$modelMagnitude->findByAttributes(array("serialid_sensor"=>$modelMagnitude->serialid_sensor));
            }
            if(!empty($sensor)){
                $response["status"]="noexito";
                $response["msg"]="Este sensor ya ha sido asociado a una magnitud";
            }
            else{
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
                            $modelSensor->sensor_associated=1;
                            $modelSensor->serialid_sensor=$modelMagnitude->serialid_sensor;
                            $modelSensor->update(array('sensor_associated'));
                            $magnitudes=$modelMagnitude->searchMagnitudesByObject($modelMagnitude->id_entdev);
                            $response["data"]=$magnitudes;
                        }
                        else{
                            $response["status"]="noexito";
                            $response["msg"]="No ha sido posible asociar la magnitud";
                        }
                    }
                }
            }
            echo CJSON::encode($response);
        }
        else{
            echo CActiveForm::validate($modelMagnitude);
        }
    }
    /**
    * Devuelve el listado de servicios según el la entidad.
    *
    * @param type string $idSEntity captura el id de la entidad
    *
    * @return $devices json del listado de dispositivos
    */
    public function actionSearchService(){
        $idEntity=Yii::app()->request->getPost("idEntity");
        $modeloEntity= Entity::model();
        $services=$modeloEntity->searchService($idEntity);
        echo CJSON::encode($services);
    }
    /**
    * Devuelve el listado de dispositivos según el servicio.
    *
    * @param type string $idService captura el id del servicio
    *
    * @return $devices json del listado de dispositivos
    */
    public function actionSearchDevice(){
        $idService=Yii::app()->request->getPost("idService");
        $modeloDevice= Device::model();
        $devices=$modeloDevice->searchDevice($idService,"OPERATIVO","2");
        echo CJSON::encode($devices);
    }
    
    /**
    * Devuelve el listado de objetos creados hasta el momento.
    *
    * @param type $string captura el string digitado para realizar filtro por objetos
    *
    * @return $display_json Listado de objetos en formato json
    */
    public function actionSearchEntity(){
        $json_arr=[];
        $display_json=[];
        $json_arr=[];
        $modelEntityDevice= EntityDevice::model();
        $string=Yii::app()->request->getPost("stringobject");
        $objects=$modelEntityDevice->searchObject($string);
        if(!empty($objects)){
            foreach($objects as $object){
                $json_arr["id"] = $entity["id_entity"];
                $json_arr["value"] = $entity["entity_name"];
                $json_arr["label"] = $entity["entity_name"];
                array_push($display_json, $json_arr);
            }
        }
        else{
            $json_arr["id"] = "#";
            $json_arr["value"] = "No hay resultados";
            $json_arr["label"] = "No hay resultados";
            array_push($display_json, $json_arr);
        }
        echo CJSON::encode($display_json);
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