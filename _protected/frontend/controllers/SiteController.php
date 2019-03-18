<?php
namespace frontend\controllers;

use backend\models\Gallary;
use backend\models\ProductSearch;
use common\models\User;
use common\models\LoginForm;
use frontend\models\AccountActivation;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use backend\models\Product;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;
use yz\shoppingcart\ShoppingCart;
use backend\models\Checkout;
/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSingle($id)
    {
        $model = Product::find()->where(['id' => $id])->one();
        $model1 = Gallary::find()->where(['product_id' => $id])->all();
        return $this->render('single', [
            'model' => $model,
            'model1' => $model1,
        ]);
    }

    public function actionSearch()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $var = Yii::$app->request->queryParams;
        foreach ($var as $var1) {
            foreach ($var1 as $var2) {
                $model_data = $var2;
            }
        }
        // die('test');
        $myModels = $dataProvider->getModels();
        // print_r($myModels); die('test');
        return $this->render('search', [
            'model' => $myModels,
            'model_data' => $model_data,
        ]);

    }

    public function actionAddToCart($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model_cart = new Checkout;
        $model_cart1 = Checkout::find()->where(['product_id' => $id])->all();
        $model1 = Product::find()->where(['id' => $id])->one();

        if (empty($model_cart1)) {
            // $model_cart->product_name = $model1->name;
            $model_cart->quantity = 1;
            $model_cart->product_id = $model1->id;
            $model_cart->user_id = Yii::$app->user->identity->id;
            $model_cart->price = $model1->offer_price;
           // $model_cart->image = $model1->image;
            $model_cart->save();
            return $this->redirect(['cart-view']);
        } else {
            foreach($model_cart1 as $model_part) {
                // $model_part->product_name = $model1->name;
                $model_part->quantity = $model_part->quantity + 1;
               // $model_part->product_id = $model1->id;
               // $model_part->user_id = Yii::$app->user->identity->id;
                $model_part->price = $model_part->quantity * $model1->offer_price;
               // $model_part->image = $model1->image;
            }
            $model_part->save();
            return $this->redirect(['cart-view']);
        }
    // die('test');
    /* $cart = new ShoppingCart();
  //  $cart = Yii::$app->cart;

    $model = Product::findOne($id);

    if ($model) {
        $total = \Yii::$app->cart->getCost();
        $itemsCount = \Yii::$app->cart->getCount();
         // print_r($itemsCount); die('test');
        $cart->put($model, 1);
         $data = $cart->getPositions();

        return $this->render('cart_view',[
            'data'=>$data,
            'total'=>$total,
            'count'=>$itemsCount,
        ]);
    }
    throw new NotFoundHttpException();*/
}

    public function actionAjaxQuantity()
    {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $id = Yii::$app->request->post('id');
            $new_price = Yii::$app->request->post('new_price');
            $new_quantity = Yii::$app->request->post('new_quantity');
            $model = Checkout::find()->where(['product_id' => $id])->one();
            if(!empty($new_quantity)){
            $model->price = $new_price;
            $model->quantity = $new_quantity;
            $model->save();
            }
            else
            {
                $model->delete();
            }
            // return $this->redirect(['cart-view']);
        }
    }

   /* public function actionMinusQuantity($id)
    {
        $model = Checkout::find()->where(['product_id'=>$id])->one();
        $model1 = $model->price / $model->quantity;
        $model->quantity = $model->quantity - 1;
        if(empty($model->quantity))
        {
           $model->delete();
        }
        else {
            $model->price = $model->quantity * $model1;
            $model->save();
            }
        return $this->redirect(['cart-view']);

    }*/

    public function actionDeleteItem($id)
    {
        $model = Checkout::findOne($id);
        $model->delete();
        $this->redirect(['cart-view']);
        /*$cart = new ShoppingCart();
        $cart->removeById($id);
        return $this->redirect(['index']);*/
    }

    public function actionCartView()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $model = Checkout::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
        $model_price = Product::find()->all();

        foreach($model_price as $model1)
        {
            $product_price[$model1->id] = $model1->price;
             $product_image[$model1->id] = $model1->image;
            $product_name[$model1->id] = $model1->name;
            $product_stock[$model1->id] = $model1->stock;
        }
        $count = Checkout::find()->count();
        return $this->render('cart_view',[
            'model'=>$model,
            'count'=>$count,
            'product_price'=>$product_price,
            'product_image'=>$product_image,
            'product_name'=>$product_name,
            'product_stock'=>$product_stock,
        ]);
    }

    public function actionCheckout()
    {
        return $this->render('checkout');
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->contact(Yii::$app->params['adminEmail'])) 
            {
                Yii::$app->session->setFlash('success', 
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } 
        
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            return $this->goBack();
        }
        // user couldn't be logged in, because he has not activated his account
        elseif($model->notActivated())
        {
            // if his account is not activated, he will have to activate it first
            Yii::$app->session->setFlash('error', 
                'You have to activate your account first. Please check your email.');

            return $this->refresh();
        }    
        // account is activated, but some other errors have happened
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->sendEmail()) 
            {
                Yii::$app->session->setFlash('success', 
                    'Check your email for further instructions.');

                return $this->goHome();
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 
                    'Sorry, we are unable to reset password for email provided.');
            }
        }
        else
        {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try 
        {
            $model = new ResetPasswordForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) 
            && $model->validate() && $model->resetPassword()) 
        {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }
        else
        {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }       
    }    

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email
     * ( with link containing account activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            // try to save user data in database
            if ($user = $model->signup()) 
            {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === User::STATUS_ACTIVE)
                {
                    if (Yii::$app->getUser()->login($user)) 
                    {
                        return $this->goHome();
                    }
                }
                // activation is needed, use signupWithActivation()
                else 
                {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }            
            }
            // user could not be saved in database
            else
            {
                // display error message to user
                Yii::$app->session->setFlash('error', 
                    "We couldn't sign you up, please contact us.");

                // log this error, so we can debug possible problem easier.
                Yii::error('Signup failed! 
                    User '.Html::encode($user->username).' could not sign up.
                    Possible causes: something strange happened while saving user in database.');

                return $this->refresh();
            }
        }
                
        return $this->render('signup', [
            'model' => $model,
        ]);     
    }

    /**
     * Sign up user with activation.
     * User will have to activate his account using activation link that we will
     * send him via email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send account activation email
        if ($model->sendAccountActivationEmail($user)) 
        {
            Yii::$app->session->setFlash('success', 
                'Hello '.Html::encode($user->username).'. 
                To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.');
        }
        // email could not be sent
        else 
        {
            // display error message to user
            Yii::$app->session->setFlash('error', 
                "We couldn't send you account activation email, please contact us.");

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! 
                User '.Html::encode($user->username).' could not sign up.
                Possible causes: verification email could not be sent.');
        }
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try 
        {
            $user = new AccountActivation($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($user->activateAccount()) 
        {
            Yii::$app->session->setFlash('success', 
                'Success! You can now log in. 
                Thank you '.Html::encode($user->username).' for joining us!');
        }
        else
        {
            Yii::$app->session->setFlash('error', 
                ''.Html::encode($user->username).' your account could not be activated, 
                please contact us!');
        }

        return $this->redirect('login');
    }
}
