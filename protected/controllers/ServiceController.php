<?php

class ServiceController extends Controller{
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
    
    public function actionRegisterEntityService(){
        $modelEntityService=new EntityService();
        if(empty($_POST)){
            $modelEntity=  Entity::model();
            $modelService=  Service::model()->findAll();
            $this->render("_registerservice",array(
                "modelEntityService"=>$modelEntityService,
                "modelService"=>$modelService,
                "modelEntity"=>$modelEntity,
            ));
        }
        else{
            $modelEntityService->attributes=Yii::app()->request->getPost("EntityService");
            $modelEntityService->service_access=true;
            $nameForm="entityservice-form";
            $this->performAjaxValidation($modelEntityService,$nameForm);
            if($modelEntityService->validate()){
                $checkExistService=  EntityService::model()->findByAttributes(array("id_service"=>$modelEntityService->id_service,"id_entity"=>$modelEntityService->id_entity));
                if(empty($checkExistService)){   
                    if($modelEntityService->save()){
                        $response["status"]="exito";
                        $response["msg"]="Servicio asociado satisfactoriamente";
                    }
                    else{
                        $response["status"]="noexito";
                        $response["msg"]="Error al crear el servicio";
                    }
                    echo CJSON::encode($response);
                }
                else{
                    $response["status"]="noexito";
                    $response["msg"]="Servicio ya registrado para esta empresa";
                    echo CJSON::encode($response);
                }
            }
            else{
                echo CActiveForm::validate($modelEntityService);
            }
           
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
        if(isset($_POST['ajax']) && $_POST['ajax']===$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
    public function actionAvl(){
        $modelEntityDevice=  EntityDevice::model();
        $modelObject=  Object::model();
        $modelMagnitudeEntDev=  MagnitudeEntdev::model();
        $modelDevice=  Device::model();
        $modelDataFrame=  Dataframe::model();
        $modelService=  Service::model();
        $service=$modelService->findByAttributes(array("service_code"=>"AVL"));
        $devices=$modelEntityDevice->findAllByAttributes(array("id_service"=>$service->id_service));
        $this->render("_loadavl",array(
            'modelEntityDevice'=>$modelEntityDevice,
            'modelObject'=>$modelObject,
            'modelMagnitudeEntDev'=>$modelMagnitudeEntDev,
            'modelDevice'=>$modelDevice,
            'modelDataFrame'=>$modelDataFrame,
            'modelService'=>$modelService,
            'modelDataFrame'=>$modelDataFrame,
            'devices'=>$devices
        ));
    }
    public function actionShowDataObjectAvl(){
        if(isset($_POST)&&!empty($_POST)){
            $params=Yii::app()->request->getPost("id_entdev");
            $modelDataFrame=  Dataframe::model();
            $modelMagnitudeEntDev=  MagnitudeEntdev::model();
            $modelEntdev=  EntityDevice::model()->findByPk($params);
            $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($params);
            $latitude=$modelDataFrame->searchGeoposition($positionsDF,"LAT",$params);
            $longitude=$modelDataFrame->searchGeoposition($positionsDF,"LONG",$params);
//            echo $modelDataFrame->time;exit();
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_entdev=:identdev';
            $criteria->order='dataframe_date DESC';
            $criteria->limit = 20;
            $criteria->params = array(':identdev' => $params);
            $dataFrames=$modelDataFrame->findAll($criteria);
            $dataObjects=array();
            foreach($dataFrames as $pk=>$dataFrame){
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $dataObjects[$pk]["time"]=$dataFrame->dataframe_date;
                foreach($positionsDF as $pki=>$position){
                    if(is_array($position)){
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[3+$position["position_dataframe"]];
                    }
                }
            }
            $object=  Object::model()->findByPk($modelEntdev->serialid_object);
            $this->render("_showobjectavl",array(
                "object"=>$object,
                "dataFrames"=>$dataFrames,
                "positionsDF"=>$positionsDF,
                "dataObjects"=>$dataObjects,
                "identdev"=>$params,
                "latitude"=>$latitude,
                "longitude"=>$longitude,
                "time"=>$modelDataFrame->time
            ));
        }
        else{
            $this->actionAvl();
        }
    }
    public function actionShowPoint(){
        $idEntDev=Yii::app()->request->getPost("idEntDev");
        $modelDataFrame=  Dataframe::model();
        $modelMagnitudeEntDev=  MagnitudeEntdev::model();
        $modelEntdev=  EntityDevice::model()->findByPk($idEntDev);
        $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($idEntDev);
        $response["latitude"]=$modelDataFrame->searchGeoposition($positionsDF,"LAT",$idEntDev);
        $response["longitude"]=$modelDataFrame->searchGeoposition($positionsDF,"LONG",$idEntDev);
        $response["time"]=$modelDataFrame->time;
        $response["status"]="exito";
        echo CJSON::encode($response);
        
    }
    public function actionSearchDataAvl(){
        if(isset($_POST)&&!empty($_POST)){
            $params=Yii::app()->request->getPost("identdev");
            $modelMagnitudeEntDev=  MagnitudeEntdev::model();
            $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($params);
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_entdev=:identdev';
            $criteria->order='dataframe_date DESC';
            $criteria->limit = 20;
            $criteria->params = array(':identdev' => $params);
            $modelDataFrame=  Dataframe::model();
            $dataFrames=$modelDataFrame->findAll($criteria);
            $dataObjects=array();
            foreach($dataFrames as $pk=>$dataFrame){
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $dataObjects[$pk]["time"]=$dataFrame->dataframe_date;
                foreach($positionsDF as $pki=>$position){
                    if(is_array($position)){
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[3+$position["position_dataframe"]];
                    }
                }
            }
            $response["status"]="exito";
            $response["data"]=$dataObjects;
            echo CJSON::encode($response);
        }
    }
    public function actionTelemedicion(){
        $modelEntityDevice=  EntityDevice::model();
        $modelObject=  Object::model();
        $modelMagnitudeEntDev=  MagnitudeEntdev::model();
        $modelDevice=  Device::model();
        $modelDataFrame=  Dataframe::model();
        $modelService=  Service::model();
        $service=$modelService->findByAttributes(array("service_code"=>"TELEMEDICION"));
        $devices=$modelEntityDevice->findAllByAttributes(array("id_service"=>$service->id_service));
        $this->render("_loadtelemed",array(
            'modelEntityDevice'=>$modelEntityDevice,
            'modelObject'=>$modelObject,
            'modelMagnitudeEntDev'=>$modelMagnitudeEntDev,
            'modelDevice'=>$modelDevice,
            'modelDataFrame'=>$modelDataFrame,
            'modelService'=>$modelService,
            'modelDataFrame'=>$modelDataFrame,
            'devices'=>$devices
        ));
    }
    public function actionShowDataObjectTelemed(){
        if(isset($_POST)&&!empty($_POST)){
            $params=Yii::app()->request->getPost("id_entdev");
            $modelDataFrame=  Dataframe::model();
            $modelDataFrame->dataframe_date;
            $modelMagnitudeEntDev=  MagnitudeEntdev::model();
            $modelEntdev=  EntityDevice::model()->findByPk($params);
            $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($params);
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_entdev=:identdev';
            $criteria->order='dataframe_date DESC';
            $criteria->limit = 20;
            $criteria->params = array(':identdev' => $params);
            $dataFrames=$modelDataFrame->findAll($criteria);
            $dataObjects=array();
            foreach($dataFrames as $pk=>$dataFrame){
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $dataObjects[$pk]["time"]=$dataFrame->dataframe_date;
                foreach($positionsDF as $pki=>$position){
                    if(is_array($position)){
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[3+$position["position_dataframe"]];
                    }
                }
            }
            $object=  Object::model()->findByPk($modelEntdev->serialid_object);
            $this->render("_showobjectelemed",array(
                "object"=>$object,
                "dataFrames"=>$dataFrames,
                "positionsDF"=>$positionsDF,
                "dataObjects"=>$dataObjects,
                "identdev"=>$params
            ));
        }
        else{
            $this->actionTelemedicion();
        }
    }
    
    
    public function actionSearchDataTelemed(){
        if(isset($_POST)&&!empty($_POST)){
            $params=Yii::app()->request->getPost("identdev");
            $modelMagnitudeEntDev=  MagnitudeEntdev::model();
            $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($params);
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_entdev=:identdev';
            $criteria->order='dataframe_date DESC';
            $criteria->limit = 20;
            $criteria->params = array(':identdev' => $params);
            $modelDataFrame=  Dataframe::model();
            $dataFrames=$modelDataFrame->findAll($criteria);
            $dataObjects=array();
            foreach($dataFrames as $pk=>$dataFrame){
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $dataObjects[$pk]["time"]=$dataFrame->dataframe_date;
                foreach($positionsDF as $pki=>$position){
                    if(is_array($position)){
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[3+$position["position_dataframe"]];
                    }
                }
            }
            $response["status"]="exito";
            $response["data"]=$dataObjects;
            echo CJSON::encode($response);
        }
    }
    
    public function actionTelecontrol(){
        $this->render("_loadtelecontrol");
    }
}