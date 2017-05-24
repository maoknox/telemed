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
}