<?php

namespace frontend\controllers;

use common\models\Audios;
use common\models\AudiosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * AudiosController implements the CRUD actions for Audios model.
 */
class AudiosController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Audios models.
     */
    public function actionIndex()
    {
        $searchModel = new AudiosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Audios model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Audios model with file upload.
     */
    public function actionCreate()
    {
        $model = new Audios();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // Faylni olish
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');

            if ($model->audioFile) {
                $fileName = time() . '.' . $model->audioFile->extension;
                $model->audioFile->saveAs(\Yii::getAlias('@frontend/web/uploads/audio/') . $fileName);
                $model->name = $fileName; // DB ga fayl nomini yozamiz
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Audios model with file upload.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // Faylni olish (yangi fayl yuklansa, eski nom o‘zgartiriladi)
            $audioFile = UploadedFile::getInstance($model, 'audioFile');

            if ($audioFile) {
                $fileName = time() . '.' . $audioFile->extension;
                $audioFile->saveAs(\Yii::getAlias('@frontend/web/uploads/audio/') . $fileName);
                $model->name = $fileName;
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Audios model.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Faylni ham o‘chirish
        $filePath = \Yii::getAlias('@frontend/web/uploads/audio/') . $model->name;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Audios model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Audios::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
