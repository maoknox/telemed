<?php

class PersonController extends Controller{
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
    * Carga modelos y llama a vista _registerperson para crear persona, si recive parámetros registra persona en base de datos
    *
    * @param type $modelPerson 
    * @param type $modelUser 
    * @param type $modelEntityPerson
    * @param type $modelPerson  
    *
    *
    */  
    public function actionRegisterPerson(){
        $modelPerson=new Person();
        $modelUser=new User();
        $modelEntityPerson= new EntityPerson();
        if(empty($_POST)){
            $dataRole=  Role::model()->findAll();
            $dataTypeDocument= TypeDocument::model()->findAll();
            $this->render("_registerperson",array(
                "modelPerson"=>$modelPerson,
                "modelUser"=>$modelUser,
                "modelEntityPerson"=>$modelEntityPerson,
                "dataRole"=>$dataRole,
                "dataTypeDocument"=>$dataTypeDocument
            ));
        }
        else{
            $modelPerson->attributes=Yii::app()->request->getPost("Person");
            $datePerson=$modelPerson->findByAttributes(array("person_numberid"=>$modelPerson->person_numberid));
            if(empty($datePerson)){
                $modelUser->attributes=Yii::app()->request->getPost("User");
                $modelUser->id_person=0;
                $modelUser->user_active=1;
                $modelUser->username="aux";
                $modelUser->password="aux";
                $dataRole=  Role::model()->findByPk($modelUser->id_role);
                $postEntity=Yii::app()->request->getPost("EntityPerson");
                $nameForm="person-form";
                $this->performAjaxValidation(array($modelPerson,$modelUser),$nameForm);
                if($modelPerson->validate()&&$modelUser->validate()){
                    if($dataRole->role_name!="SUPERADMIN"){
                        $modelEntityPerson->id_person=0;
                        $modelEntityPerson->id_entity=$postEntity["id_entity"];
//                        echo $modelEntityPerson->id_entity;
//                        $modelEntityPerson->id_entity=0;
                        if(!$modelEntityPerson->validate()){
                            echo CActiveForm::validate($modelEntityPerson);
                            exit();
                        }
                    }
                    $transaction=Yii::app()->db->beginTransaction();
                    try{
                        $modelPerson->save();
                        $modelUser->id_person=$modelPerson->id_person;
                        $modelUser->save();
                        if($dataRole->role_name!="SUPERADMIN"){
                                $modelEntityPerson->id_person=$modelPerson->id_person;
                                $modelEntityPerson->save();
                        }
                        $transaction->commit();
                        $response["status"]="exito";
                        $response["msg"]="Persona registrada satisfactoriamete";
                        echo CJSON::encode($response);
                    }
                    catch(ErrorException $e){
                        $transaction->rollback();
                        throw new CHttpException($e->get,$e->getMessage());
                    }
                }
                else{
                    echo CActiveForm::validate(array($modelPerson,$modelUser));
                }
            }
            else{
                $response["status"]="noexito";
                $response["msg"]="El número de documento ya ha sido registrado";
                echo CJSON::encode($response);
            }
        }
    }
    /**
    * Devuelve el listado de empresas creadas hasta el momento.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    public function actionSearchEntity(){
        $json_arr=[];
        $display_json=[];
        $json_arr=[];
        $modelEntity= Entity::model();
        $string=Yii::app()->request->getPost("stringentity");
        $entities=$modelEntity->searchEntity($string);
        if(!empty($entities)){
            foreach($entities as $entity){
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
        if(isset($_POST['ajax']) && $_POST['ajax']===$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
}