<?php

namespace app\controllers;

use Yii;
use app\models\Promotion;
use app\models\PromotionSearch;
use app\models\ProductPromotion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\Product;

/**
 * PromotionController implements the CRUD actions for Promotion model.
 */
class PromotionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Promotion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromotionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Promotion model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Promotion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Promotion();
        $modelsProductPromotion = [new ProductPromotion];

        if ($model->load(Yii::$app->request->post())) {
            $modelsProductPromotion = Model::createMultiple(ProductPromotion::classname());
            Model::loadMultiple($modelsProductPromotion, Yii::$app->request->post());

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    $total = 0;
                    foreach ($modelsProductPromotion as $objProductPromotion) {
                        $product = Product::findOne($objProductPromotion->product_id);
                        $total += $product->price * $objProductPromotion->quantity;
                        $objProductPromotion->promotion_id = $model->id;
                        $objProductPromotion->price = $product->price;
                        if (! ($flag = $objProductPromotion->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $model->total = $total - ($total * $model->deduction / 100);
                    $model->save(false);
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }          
        }
        return $this->render('create', [
            'model' => $model,
            'modelsProductPromotion' => (empty($modelsProductPromotion)) ? [new ProductPromotion] : $modelsProductPromotion
        ]);
    }

    /**
     * Updates an existing Promotion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Promotion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Promotion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Promotion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Promotion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
