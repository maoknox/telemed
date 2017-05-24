<?php

class EntityController extends Controller
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
    * Devuelve el listado departamentos o estados.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    public function actionSearchState(){
        $idCountry=Yii::app()->request->getPost("idCountry");
        $modeloEntity= Entity::model();
        $states=$modeloEntity->searchState($idCountry);
        echo CJSON::encode($states);
    }
    public function actionSearchCity(){
        $idState=Yii::app()->request->getPost("idState");
        $modeloEntity= Entity::model();
        $cityes=$modeloEntity->searchCity($idState);
        echo CJSON::encode($cityes);
    }
    
    /**
    * Devuelve el listado de títulos de grado que halla según lo digitado en el campo.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    public function actionRegisterCityEntity(){
        $modelCityEntity= new CityEntity();
        $nameForm="cityEntity-form";
        $this->performAjaxValidation($modelCityEntity,$nameForm);
        $post=Yii::app()->request->getPost("CityEntity");
        $modelCityEntity->attributes=$post;
        $response["status"]="exito";
        $existCity=$modelCityEntity->findByPk(array("id_city"=>$modelCityEntity->id_city,"id_entity"=>$modelCityEntity->id_entity));
        if(empty($existCity)){
            try{
                if($modelCityEntity->validate()){
                    if($modelCityEntity->save()){
                        $response["msg"]="Ciudad registrada satisfactoriamente";
                    }
                    else{
                        $response["status"]="noexito";
                        $response["msg"]="Ciudad no registrada satisfactoriamente";
                    }
                    echo CJSON::encode($response);
                }
                else{
                    echo CActiveForm::validate($modelCityEntity);
                }
            }
            catch(ErrorException  $e){
                throw new Exception("Error al asociar la ciudad");
            }
        }
        else{
            $response["status"]="noexito";
            $response["msg"]="Esta ciudad ya ha sido registrada para ésta empresa";
            echo CJSON::encode($response);
        }
    }

    public function actionCreateEntity(){
        $modelEntity= new Entity();
        $modelPerson= new Person();
        $modelCityEntity= new CityEntity();
        if(empty($_POST)){
            $modelTypeEntity= TypeEntity::model()->findAll();
            $modelTypeDocument= TypeDocument::model()->findAll();
            $dataCountry= Country::model()->findAll();
            $modelCountry= Country::model();
            $dataState= State::model()->findAll();
            $modelState= State::model();
            $dataCity= City::model()->findAll();
            $this->render("_createEntity",array(
                "modelEntity"=>$modelEntity,
                "modelTypeEntity"=>$modelTypeEntity,
                "modelPerson"=>$modelPerson,
                "modelTypeDocument"=>$modelTypeDocument,
                "modelCityEntity"=>$modelCityEntity,
                "modelCountry"=>$modelCountry,
                "dataCountry"=>$dataCountry,
                "dataState"=>$dataState,
                "modelState"=>$modelState,
                "dataCity"=>$dataCity
            ));
        }
        else{
            try{
                $nameForm="entity-form";
                $this->performAjaxValidation($modelEntity,$nameForm);
                $post=Yii::app()->request->getPost("Entity");
                $modelEntity->attributes=$post;
                $response["status"]="exito";
                if($modelEntity->id_typeent==1){
                    $modelEntity->scenario="lastname";
                }
                else{
                    $modelEntity->entity_lastname=null;
                }
                if($modelEntity->validate()){
                    if($modelEntity->save()){
                        $response["idempresa"]=$modelEntity->id_entity;
                        $response["msg"]="Cliente registrado satisfactoriamente";
                    }
                    else{
                        $response["status"]="no exito";
                        $response["msg"]="Cliente no registrado satisfactoriamente";
                    }

                    echo CJSON::encode($response);
                }
                else{
                    echo CActiveForm::validate($modelEntity);
                }
            }
            catch(ErrorException  $e){
                throw new CHttpException($e->get,$e->getMessage());
            }
        }
    }
    protected function performAjaxValidation($model,$nameForm){
        if(isset($_POST['ajax']) && $_POST['ajax']===$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }   
}