<?php
class SiteController extends Controller
{
    /**
    * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
    * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
    */
    public function filterEnforcelogin($filterChain){
        if(Yii::app()->user->isGuest){
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            
        }
        else{
            Yii::app()->user->returnUrl = array("site/index");          
            $this->redirect(Yii::app()->user->returnUrl);
        }
        $filterChain->run();
    }
    /**
     * @return array action filters
     */
    public function filters(){
        return array(
                'enforcelogin -login -index -logout -contact -registerPlatform',                      
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
                $modelEntity=  Entity::model();
                $modelEntityPerson=  EntityPerson::model();
                $this->render('index');
            }
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
                'cost' => 9,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $password=password_hash($prePassword, PASSWORD_BCRYPT, $opciones);
            return $password;
        }
}