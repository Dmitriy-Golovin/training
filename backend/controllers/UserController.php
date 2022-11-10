<?php

namespace backend\controllers;

use common\models\User;
use backend\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'create' => ['get', 'post'],
                        'update' => ['get', 'post'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $userId
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($userId)
    {
        return $this->render('view', [
            'model' => $this->findModel($userId),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_ADMIN_CREATE;

        return $this->save('create', $model);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $userId
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($userId)
    {
        $model = $this->findModel($userId);
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;

        return $this->save('update', $model);
    }

    public function save($view, $model)
    {
        if ($this->request->isPost && $model->load($this->request->post())) {
            $auth = \Yii::$app->authManager;

            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }

            if ($model->scenario === User::SCENARIO_ADMIN_CREATE) {
                $model->generateAuthKey();
            }

            $model->status = User::STATUS_ACTIVE;
            
            if ($model->save()) {
                $auth->revokeAll($model->userId);
                $role = $auth->getRole($model->role);
                $auth->assign($role, $model->userId);

                return $this->render('view', [
                    'userId' => $model->userId,
                    'model' => $model,
                ]);
            }
        }

        return $this->render($view, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $userId
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($userId)
    {
        $this->findModel($userId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $userId
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($userId)
    {
        if (($model = User::findOne(['userId' => $userId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
