<?php

namespace app\controllers;

use Yii;
use app\models\Estimate;
use app\models\EstimateSearch;
use app\models\ProductEstimate;
use app\models\PromotionEstimate;
use app\models\Product;
use app\models\Promotion;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstimateController implements the CRUD actions for Estimate model.
 */
class EstimateController extends Controller
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
     * Lists all Estimate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstimateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estimate model.
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
     * Creates a new Estimate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Estimate();
        $modelsProductEstimate = [new ProductEstimate];
        $modelsPromotionEstimate = [new PromotionEstimate];

        if ($model->load(Yii::$app->request->post())) {
            $modelsProductEstimate = Model::createMultiple(ProductEstimate::classname());
            Model::loadMultiple($modelsProductEstimate, Yii::$app->request->post());

            $modelsPromotionEstimate = Model::createMultiple(PromotionEstimate::classname());
            Model::loadMultiple($modelsPromotionEstimate, Yii::$app->request->post());
            
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    $totalProduct = 0;
                    foreach ($modelsProductEstimate as $objProductEstimate) {
                        $product = Product::findOne($objProductEstimate->product_id);
                        $totalProduct += $product->price * $objProductEstimate->quantity;
                        $objProductEstimate->estimate_id = $model->id;
                        $objProductEstimate->price = $product->price;
                        if (! ($flag = $objProductEstimate->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    $totalPromotion = 0;
                    foreach ($modelsPromotionEstimate as $objPromotionEstimate) {
                        $promotion = Promotion::findOne($objPromotionEstimate->promotion_id);
                        $totalPromotion += $promotion->total;
                        $objPromotionEstimate->estimate_id = $model->id;
                        $objPromotionEstimate->price = $promotion->total;
                        if (! ($flag = $objPromotionEstimate->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $total = $totalProduct + $totalPromotion;
                    $model->total = $total + ($total * $model->tax / 100);
                    $model->code = "COD" . $model->id;
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
            'modelsProductEstimate' => (empty($modelsProductEstimate)) ? [new ProductEstimate] : $modelsProductEstimate,
            'modelsPromotionEstimate' => (empty($modelsPromotionEstimate)) ? [new PromotionEstimate] : $modelsPromotionEstimate
        ]);
    }

    /**
     * Updates an existing Estimate model.
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
     * Deletes an existing Estimate model.
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
     * Finds the Estimate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Estimate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estimate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
