<?php
class SiteController extends Controller
{
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
        else{
            if(!isset($_POST)){
                Yii::app()->user->returnUrl = array("site/index");          
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
                'enforcelogin -login -index -logout -contact -registerPlatform -searchservices -searchMunicipio -searchEmpresa -searchMedidor',                      
        );
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
            if(Yii::app()->user->isGuest){
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            }
            else{
                if(Yii::app()->user->getState('nombreRole')!="CLIENTEDEMO"){
                    $user=Yii::app()->user->name;
                    $service=  Service::model()->searchServiceByUsername($user);
    //                $modelEntity=  Entity::model();
    //                $modelEntityPerson=  EntityPerson::model();
                    $this->render('index',array("services"=>$service));
                }
                else{
                    $conndbi = Yii::app()->dbi;
                    $sqlDepto="select dp.id_departamento,dp.nombre_departamento "
                            . "from (select * from empresa group by id_municipio,id_empresa) as emp "
                            . "left join municipio as mn on mn.id_municipio=emp.id_municipio "
                            . "left join departamento dp on dp.id_departamento=mn.id_departamento "
                            . "group by dp.id_departamento,dp.nombre_departamento order by nombre_departamento asc";
                    $query=$conndbi->createCommand($sqlDepto);
                    $read=$query->query();
                    $resDepto=$read->readAll();
                    $read->close();
                    $modelDepartamento= Departamento::model();
                    $departamentos=$modelDepartamento->findAllBySql($sqlDepto);
                    $modelMunicipio= Municipio::model();
                    $modelEmpresa= Empresa::model();
                    $this->render('index_demo',array(
                        "modelDepartamento"=>$modelDepartamento,
                        "modelMunicipio"=>$modelMunicipio,
                        "modelEmpresa"=>$modelEmpresa,
                        "departamentos"=>$departamentos
                        )
                    );
                }
            }
	}
        //buscaMunicipio
        public function actionSearchMunicipio(){
            $idDepto=Yii::app()->request->getPost("idDepto");
            $modelMunicipio= Municipio::model();
            $sqlMunicipio="select mn.id_municipio,mn.nombre_municipio from "
                    . "(select * from empresa group by id_municipio,id_empresa) as emp "
                    . "left join municipio as mn on mn.id_municipio=emp.id_municipio "
                    . "where mn.id_departamento=:depto "
                    . "order by nombre_municipio asc";
            $c=new CDbCriteria();
            $c->condition=":depto=".$idDepto;
            $municipios=$modelMunicipio->findAllBySql($sqlMunicipio,array(":depto"=>$idDepto));
            echo CJSON::encode($municipios);
        }
         public function actionSearchEmpresa(){
            $idMunicipio=Yii::app()->request->getPost("idMunicipio");
            $modelEmpresa= Empresa::model();
            $sqlEmpresa="select id_empresa,nombre_empresa from empresa where id_municipio=:idmun order by nombre_empresa asc";
            $empresas=$modelEmpresa->findAllBySql($sqlEmpresa,array(":idmun"=>$idMunicipio));
            echo CJSON::encode($empresas);
        }
        public function actionSearchMedidor(){
            $idEmpresa=Yii::app()->request->getPost("idEmpresa");
            $connDbi=Yii::app()->dbi;
            $sql="select codigo_medidor as \"Medidor\",direccion_medidor as \"Ubicación\", interno_medidor as \"Interno\", ruta_medidor as \"Ruta\", ciclo_medidor as \"Ciclo\" from medidor as med "
                    . "left join medidor_suscriptor as ms on med.id_medidor=ms.id_medidor "
                    . "where id_empresa=:idEmpresa;";
            $query=$connDbi->createCommand($sql);
            $query->bindParam(":idEmpresa",$idEmpresa);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            $columns= array_keys($res[0]);
            $result["columns"]=$columns;
            $result["data"]=$res;
            echo CJSON::encode($result);
        }
        public function actionSearchHistFechaMedidor(){
            $idMedidor=Yii::app()->request->getPost("idMedidor");
            $connDbi=Yii::app()->dbi;
            $sql="select fecha_aforo as \"Fecha_aforo\" from medidor as m left "
                    . "join lectura_actual as la on la.id_medidor=m.id_medidor "
                    . "where codigo_medidor=:codmed order by fecha_aforo asc";
            $query=$connDbi->createCommand($sql);
            $query->bindParam(":codmed",$idMedidor);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            $columns= array_keys($res[0]);
            $result["fecha"]=$res;
            echo CJSON::encode($result);
        }
        public function actionShowDataHistAforo(){
            $fecha=Yii::app()->request->getPost("fecha");
            $idMedidor=Yii::app()->request->getPost("idMedidor");
            $connDbi=Yii::app()->dbi;
            $sqlAforo="select  
                id_lecturaactual as \"Consecutivo\",
                nombre_critica as \"Crítica\",
                lectura_actual as \"Lectura_actual\",
                lectura_aforo as \"Aforo\",
                fecha_aforo as \"Fecha_aforo\",
                consumo_aforo as \"Consumo_aforo\",
                lectura_promedio as \"Lectura_promedio\",
                lectura_manual as \"Lectura_manual\",
                lectura_micromedicion as \"Lectura_micromedición\",
                metros_desviacion as \"Metros_desviación\",
                problema_lectura as \"Problema\",
                observacion_lectura as \"Observación\",
                lectura_consumo as \"Lectura_consumo\"
                from medidor as m 
                left join lectura_actual as la on la.id_medidor=m.id_medidor 
                left join critica as cr on cr.id_critica=la.id_critica 
                where codigo_medidor=:codmed and fecha_aforo=:fecha";
            $query=$connDbi->createCommand($sqlAforo);
            $query->bindParam(":codmed",$idMedidor);
            $query->bindParam(":fecha",$fecha);
            $read=$query->query();
            $resAforo=$read->read();
            $read->close();
            $columnsAforo= array_keys($resAforo);
            $result["colsaforo"]=$columnsAforo;
            $result["dataaforo"]=$resAforo;
            //consulta los históricos a partir del aforo
            $sqlHistLect="select "
                    . "orden_histlectura as \"orden_lectura\",fecha_historicolect as \"fecha_lectura\", historico_lectura as \"lectura\" 
                    from historico_lecturas 
                    where id_lecturaactual=:idLect order by orden_histlectura asc";
            $query=$connDbi->createCommand($sqlHistLect);
            $query->bindParam(":idLect",$resAforo["Consecutivo"]);
            $read=$query->query();
            $resHistLect=$read->readAll();
            $read->close();
            $columnsHlect= array_keys($resHistLect[0]);
            $result["colshlect"]=$columnsHlect;
            $result["datahlect"]=$resHistLect;
            $sqlHistCons="select orden_histconsumo as \"orden_consumo\", historico_consumo as \"consumo\" "
                    . "from historico_consumo "
                    . "where id_lecturaactual=:idLect order by orden_histconsumo asc  ";
            $query=$connDbi->createCommand($sqlHistCons);
            $query->bindParam(":idLect",$resAforo["Consecutivo"]);
            $read=$query->query();
            $resHistCons=$read->readAll();
            $read->close();
            $columnsHCons= array_keys($resHistCons[0]);
            $result["colshcons"]=$columnsHCons;
            $result["datahcons"]=$resHistCons;
            echo CJSON::encode($result);
        }
        public function actionSearchservices(){
//            $headers=getallheaders();
//            print_r($headers["oauthtoken"]);
            $user=Yii::app()->user->name;
            $services=  Service::model()->searchServiceByUsername($user);
            if(!empty($services)){
                foreach($services as $pk=>$service){
                    $objectAnchoraged=  EntityDevice::model()->searchObjectAnchorage($service["id_service"]);
                    if(empty($objectAnchoraged)){
                        $services[$pk]["anchorage"]=2;
                    }
                    else{
                        $services[$pk]["anchorage"]=1;
                        foreach($objectAnchoraged as $pkobj=>$object){
                            $services[$pk]["objects"][$pkobj]=$object;
                            if(empty($object["data"])){
                                $services[$pk]["objects"][$pkobj]["data"]="null";
                            }
                        }
                    }
                }
            }
            echo CJSON::encode($services);
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            if(Yii::app()->user->isGuest){
                $model=new LoginForm;

                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }

                // collect user input data
                if(isset($_POST['LoginForm']))
                {
                        $model->attributes=$_POST['LoginForm'];
                        // validate user input and redirect to the previous page if valid
                        if($model->validate() && $model->login())
                            Yii::app()->user->returnUrl = array("site/index");                                                          
                            $this->redirect(Yii::app()->user->returnUrl);
                }
                // display the login form
//                Yii::app()->user->setFlash('success', "Data1 saved!");
                $this->render('login',array("model"=>$model));
            }
            else{
                 $this->redirect(Yii::app()->user->returnUrl);
            }
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout(){
            Yii::app()->user->logout();
            Yii::app()->user->returnUrl = array("site/login");                                                          
            $this->redirect(Yii::app()->user->returnUrl);
	}
        public function actionRegisterPlatform(){
            if(empty($_POST)){
                $cdrs=$_GET["cdrs"];
                $modelCodeRegister=  CodeRegister::model()->findByAttributes(array('code_register'=>$cdrs));
                $personRegister=false;
                $modelUser=  User::model();
                if(!empty($modelCodeRegister)){
                    $personRegister=true;
                }
                $this->render('_registerplatform',array(
                    "cdrs"=>$cdrs,
                    'model'=>$modelUser,
                    'modelCodeRegister'=>$modelCodeRegister,
                    'personRegister'=>$personRegister
                ));
            }
            else{
                $personRegister=true;
                $modelUser=User::model();
                $modelUser->attributes=Yii::app()->request->getPost("User");
                $cdrs=$_GET["cdrs"];
                $modelCodeRegister=  CodeRegister::model()->findByAttributes(array('code_register'=>$cdrs));
                if(!empty($modelCodeRegister)){
                    $modelUserReg=  User::model()->findByPk($modelCodeRegister->id_user);
                }
                $modelUser->id_user=$modelUserReg->id_user;
                $modelUser->id_person=$modelUserReg->id_person;
                $modelUser->id_role=$modelUserReg->id_role;
                $modelUser->user_active=1;
                 // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
                {
                        echo CActiveForm::validate($modelUser);
                        Yii::app()->end();
                }
                
                if($modelUser->validate()){
                    $modelUser->password=$this->cryptPassword($modelUser->password);
                    if($modelUser->updateByPk($modelUser->id_user,array("password"=>$modelUser->password,"username"=>$modelUser->username,"user_active"=>$modelUser->user_active))){
                        $modelCodeRegister->deleteByPk($modelCodeRegister->id_coderegister);
                        Yii::app()->user->setFlash('success', "Su usuario ha sido activado");
                    }
                }
                
                $this->render('_registerplatform',array(
                    "cdrs"=>$cdrs,
                    'model'=>$modelUser,
                    'modelCodeRegister'=>$modelCodeRegister,
                    'personRegister'=>$personRegister
                ));
            }
        }
        private function cryptPassword($prePassword){
            $opciones = [
                'cost' => 9
            ];
            $password=password_hash($prePassword, PASSWORD_BCRYPT, $opciones);
            return $password;
        }
}