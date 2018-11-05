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
                'enforcelogin -recordDataMace',                      
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
        $modelObject=  ObjectOb::model();
        $modelMagnitudeEntDev=  MagnitudeEntdev::model();
        $modelDevice=  Device::model();
        $modelDataFrame=  Dataframe::model();
        $modelService=  Service::model();
        $service=$modelService->findByAttributes(array("service_code"=>"AVL"));
        $modelUser=  User::model()->findByAttributes(array("username"=>Yii::app()->user->name));
        $modelEntityPerson=  EntityPerson::model()->findByAttributes(array("id_person"=>$modelUser->id_person));
        $devices=$modelEntityDevice->findAllByAttributes(array("id_service"=>$service->id_service,"id_entity"=>$modelEntityPerson->id_entity));
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
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[-1+$position["position_dataframe"]];
                    }
                }
            }
            $object=  ObjectOb::model()->findByPk($modelEntdev->serialid_object);
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
                        $dataObjects[$pk]["data"][$pki]=$dataFramesArr[-1+$position["position_dataframe"]];
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
        $modelObject=  ObjectOb::model();
        $modelMagnitudeEntDev=  MagnitudeEntdev::model();
        $modelDevice=  Device::model();
        $modelDataFrame=  Dataframe::model();
        $modelService=  Service::model();
        $service=$modelService->findByAttributes(array("service_code"=>"TELEMEDICION"));
        $modelUser=  User::model()->findByAttributes(array("username"=>Yii::app()->user->name));
        $modelEntityPerson=  EntityPerson::model()->findByAttributes(array("id_person"=>$modelUser->id_person));
        $devices=$modelEntityDevice->findAllByAttributes(array("id_service"=>$service->id_service,"id_entity"=>$modelEntityPerson->id_entity));
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
            $modelMagnitudeEntDev=  MagnitudeEntdev::model();
            $modelEntdev=  EntityDevice::model()->findByPk($params);
            $positionsDF=$modelMagnitudeEntDev->searchPositionMagnitude($params);
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_entdev=:identdev';
            $criteria->order='dataframe_date DESC';
            $criteria->limit = 1;
            $criteria->params = array(':identdev' => $params);
            $dataFrame=$modelDataFrame->find($criteria);
            $dataObjects=array();
            $time=null;
            if(!empty($dataFrame)){
                $time=$dataFrame->dataframe_date;
    //            foreach($dataFrames as $pk=>$dataFrame){
                    $dataFramesArr= explode(",", $dataFrame->dataframe);
                    $dataObjects["time"]=$dataFrame->dataframe_date;
                    foreach($positionsDF as $pki=>$position){
                        if(is_array($position)){
                            $dataObjects["data"][$pki]=$dataFramesArr[$position["position_dataframe"]-1];
                        }
                    }
    //            }
            }
            $object=  ObjectOb::model()->findByPk($modelEntdev->serialid_object);
            $this->render("_showobjectelemed",array(
                "object"=>$object,
                "dataFrames"=>$dataFrame,
                "positionsDF"=>$positionsDF,
                "dataObjects"=>$dataObjects,
                "identdev"=>$params,
                "time"=>$time
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
            $criteria->limit = 1;
            $criteria->params = array(':identdev' => $params);
            $modelDataFrame=  Dataframe::model();
            $dataFrame=$modelDataFrame->find($criteria);
            $dataObjects=array();
//            foreach($dataFrames as $pk=>$dataFrame){
                $dataFramesArr= explode(",", $dataFrame->dataframe);
                $dataObjects["time"]=$dataFrame->dataframe_date;
                foreach($positionsDF as $pki=>$position){
                    if(is_array($position)){
                        $dataObjects["data"][$pki]=$dataFramesArr[-1+$position["position_dataframe"]];
                    }
                }
//            }
            $response["status"]="exito";
            $response["data"]=$dataObjects;
            echo CJSON::encode($response);
        }
    }
    
    public function actionTelecontrol(){
        $this->render("_loadtelecontrol");
    }
    public function actionMuestrahistorico(){
        $post=Yii::app()->request->getPost("ConsHist");
        $modelDataFrame=  Dataframe::model();
        $dataFrame=$modelDataFrame->searcHistoricData($post["id_entdev"],$post["fecha_inicial"],$post["fecha_final"]);
        usort($dataFrame,array($this, "ordenaFechaAsc"));
        foreach($dataFrame as $pk=>$datosFecha){
            $magnitudeBr=  explode(",", $datosFecha["dataframe"]);
            $magnitude=$magnitudeBr[$post["variablesSelect"]-1];
//            print_r($magnitude);exit();
            $time=strtotime( $datosFecha["dataframe_date"] )*1000;                             
            $data[$pk]=array("magnitud"=>(double)$magnitude,"time"=>$time,"tempbd"=>$datosFecha["dataframe_date"]);
        }
        echo CJSON::encode(array("datos"=>$data));
    }
    public function actionMuestrahistoricotl(){
        $post=Yii::app()->request->getPost("Hist");
        $modelDataFrame=  Dataframe::model();
//        print_r($post);exit();
        $dataFrame=$modelDataFrame->searcHistoricData($post["identdev"],$post["fechaIni"],$post["fechaFin"]);
        usort($dataFrame,array($this, "ordenaFechaAsc"));
        foreach($dataFrame as $pk=>$datosFecha){
            $magnitudeBr=  explode(",", $datosFecha["dataframe"]);
            $magnitude=$magnitudeBr[$post["posdf"]-1];
//            print_r($magnitude);exit();
            $time=strtotime( $datosFecha["dataframe_date"] )*1000;                             
            $data[$pk]=array("magnitud"=>(double)$magnitude,"time"=>$time,"tempbd"=>$datosFecha["dataframe_date"]);
        }
        echo CJSON::encode(array("datos"=>$data));
    }
     private function ordenaFechaAsc($date1,$date2){
        $date1 = strtotime($date1["dataframe_date"]);
        $date2 = strtotime($date2["dataframe_date"]);
        if($date1 == $date2) {
            return 0;
        }
        return $date1 < $date2 ? -1 : 1 ;
    }
    /*
     *  cambio de estado entdev_anchorage, para anclar al inicio y mostrar el objeto cuando se inicia sesión
     */
    public function actionObjectAnchor(){
        $post=Yii::app()->request->getPost("Anchorage");
        $modelEntdev=  EntityDevice::model();
        if($modelEntdev->updateByPk($post["identdev"], array('entdev_anchorage'=>$post["anchor"]))){
            $response["status"]="exito";
        }
        else{
            $response["status"]="noexito";
        }
        echo CJSON::encode($response);
        
    }
    public function actionRecordDataMace(){
        $post=array();
        if(!empty($_GET)){
           $post=$_GET;
        }
        elseif(!empty($_POST)){
            $post=$_POST;
        }
        elseif(!empty($_REQUEST)){
            $post=$_REQUEST;
        }
        print_r($_GET);
        $dataReq = file_get_contents("php://input");
        print_r($dataReq);
        $headers = $this->apache_request_headers();
        print_r($headers);
        $conn=Yii::app()->db;
//        $username=Yii::app()->user->name;
//        $sql="select ep.id_entity from public.user as usr left join entity_person as ep on ep.id_person=usr.id_person where username=:username ;";
//        $query=$conn->createCommand($sql);
//        $query->bindParam(":username", $username);
//        $res=$query->query();
//        $read=$res->read();
//        $res->close();
//        if(!empty($read)){
            $sqli="insert into data_mace (datamace) values (:datamace)";
            $query=$conn->createCommand($sqli);
            $data=json_encode($post);
            $data.=$dataReq;
//            $query->bindParam(":identity", $read["id_entity"]);
            $query->bindParam(":datamace", $data);
            $query->execute();
//        }
    }
    function apache_request_headers() {
        $arh = array();
        $rx_http = '/\AHTTP_/';
        foreach($_SERVER as $key => $val) {
            if( preg_match($rx_http, $key) ) {
              $arh_key = preg_replace($rx_http, '', $key);
              $rx_matches = array();
              // do some nasty string manipulations to restore the original letter case
              // this should work in most cases
              $rx_matches = explode('_', $arh_key);
              if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                $arh_key = implode('-', $rx_matches);
              }
              $arh[$arh_key] = $val;
            }
        }
        return( $arh );
        }
    public function actionShowDataMace(){
        $conn=Yii::app()->db;
        $sql="select * from data_mace";
        $query=$conn->createCommand($sql);
        $res=$query->query();
        $read=$res->readAll();
        $res->close();
        $this->render("_showdatamace",array("datamace"=>$read));
    }
    public function actionShowReportObjectTelemed(){
        header("Content-type: application/vnd.ms-excel; name='excel'");  
        header("Content-Disposition: filename=repAsist-.xls");  
        header("Pragma: no-cache");  
        header("Expires: 0"); 
        $idEntDev=Yii::app()->request->getPost('ConsRep');
        $modelEntityDevice=  EntityDevice::model()->findByPk($idEntDev["id_entdev"]);
        $modelObject=  ObjectOb::model()->findByPk($modelEntityDevice->serialid_object);
        $modelDevice=  Device::model()->findByPk($modelEntityDevice->id_device);
        $criteria=new CDbCriteria();
        $criteria->order="position_dataframe ASC";
        $modelMagnitudeEntDev=  MagnitudeEntdev::model()->findAllByAttributes(array("id_entdev"=>$idEntDev["id_entdev"]),$criteria);
        $tabla="<table style='border:1px solid #000'>";
        $numrows=count($modelMagnitudeEntDev)+1;//".$numrows."-".$idEntDev["id_entdev"]."-".$idEntDev["fecha_inicial"]."-".$idEntDev["fecha_final"]."------
        $tabla="<table><tr><td style='border:1px solid #000' colspan='".$numrows."'>Reporte de mediciones de objeto: ".$modelObject->object_name."</td></tr>";
        $tabla.="<tr><td style='border:1px solid #000' colspan='".$numrows."'>Fecha inicial: ".$idEntDev["fecha_inicial"]." - Fecha final: ".$idEntDev["fecha_final"]."</td></tr>";
        
        $tablaNmag="<td style='border:1px solid #000' rowspan='2'>Fecha de lectura</td>";
        $tablaMScale="";
        foreach($modelMagnitudeEntDev as $magnitude){
            $modelMagnitude=  Magnitude::model()->findByPk($magnitude->id_magnitude);
            $modelMeasurementScale=  MeasurementScale::model()->findByPk($magnitude->id_measscale);
            $tablaNmag.="<td style='border:1px solid #000'>".$modelMagnitude->magnitude_name."</td>";
            $tablaMScale.="<td style='border:1px solid #000'>".$modelMeasurementScale->measscale_name." - ".$modelMeasurementScale->measscale_unity."</td>";
        }
        $tabla.="<tr>".$tablaNmag;
        $tabla.="</tr>"; 
        $tabla.="<tr>".$tablaMScale;
        $tabla.="</tr>";
        $criteriai=new CDbCriteria();
        $criteriai->order="dataframe_date DESC";
        $criteriai->addBetweenCondition("dataframe_date", $idEntDev["fecha_inicial"], $idEntDev["fecha_final"]);
        $modelDataframe=  Dataframe::model()->findAllByAttributes(array("id_entdev"=>$idEntDev["id_entdev"]),$criteriai);
        $tddataframe="";
        if(!empty($modelDataframe)){
            foreach($modelDataframe as $dataframe){
                $dataFrameAux=explode(",",$dataframe->dataframe);
                $tddataframe="<td style='border:1px solid #000'>".$dataframe->dataframe_date."</td>";
                foreach($dataFrameAux as $pk=>$dataframeExp){
                    $tddataframe.="<td  style='border:1px solid #000'>".$dataframeExp."</td>";
                }
                $tabla.="<tr>".$tddataframe."</tr>";
            }
        }
        else{
           $tddataframe="<tr><td style='border:1px solid #000' colspan='".$numrows."'>No hay lecturas en este rango de fecha</td></tr>";
        }
        $tabla.="</table>";
        echo utf8_decode($tabla);
    }
    /*
     * Mostrar formulario para consultar históricos de mediciones de telemedición
     */
    public function actionShowFormHistoricTelemed(){
        $identdev=Yii::app()->request->getPost("identdev");
        $modelEntityDevice=  EntityDevice::model()->findByPk($identdev);
        $modelObject=  ObjectOb::model()->findByPk($modelEntityDevice->serialid_object);
        $modelDevice=  Device::model()->findByPk($modelEntityDevice->id_device);
        $criteria=new CDbCriteria();
        $criteria->order="position_dataframe ASC";
        $modelMagnitudeEntDev=  MagnitudeEntdev::model()->findAllByAttributes(array("id_entdev"=>$identdev),$criteria);
        $this->render("_showhistorictelemed",array("identdev"=>$identdev,"modelMagnitudeEntDev"=>$modelMagnitudeEntDev));
    }
    public function actionShowHistoricTelemed(){
        $idEntDev=Yii::app()->request->getPost("ConsRep");
        $criteriai=new CDbCriteria();
        $criteriai->order="dataframe_date DESC";
        $criteriai->addBetweenCondition("dataframe_date", $idEntDev["fecha_inicial"], $idEntDev["fecha_final"]);
        $modelDataframe=  Dataframe::model()->findAllByAttributes(array("id_entdev"=>$idEntDev["id_entdev"]),$criteriai);
        if(!empty($modelDataframe)){
            foreach($modelDataframe as $pkdf=>$dataframe){
                $dataFrameAux=explode(",",$dataframe->dataframe);
                $response["data"][$pkdf][0]=$dataframe->dataframe_date;
                foreach($dataFrameAux as $pk=>$dataframeExp){
                    $response["data"][$pkdf][$pk+1]=$dataframeExp;
                }
            }
        }
        else{
           $tddataframe="nodata";
        }
        
        $response["status"]="exito";
        echo CJSON::encode($response);
    }
    public function actionShowHistoricTelemedPart(){
        $identdev=Yii::app()->request->getPost("params");
        $params = Yii::app()->request->getRestParams();
        $data=  Service::model()->searchHistoricDataTl($params,$identdev);
        $resultsNC=Service::model()->searchHistoricDataTlCount($params,$identdev);
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $resultsNC ),  
            "recordsFiltered" => intval($resultsNC),
            "data"            => $data   // total data array
        );
        echo CJSON::encode($json_data);
    }
}
