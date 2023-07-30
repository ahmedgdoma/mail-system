<?php

namespace app\controllers;

use app\models\UploadForm;
use components\services\SheetService;
use Exception;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

class SheetController extends Controller
{


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUpload(): string
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post('UploadForm');
            $model->emailsFile = UploadedFile::getInstance($model, 'emailsFile');
            try {
                $fileName = $model->upload();
                if (!empty($fileName)) {
                    $producer = Yii::$app->rabbitmq->getProducer('sheet_process');
                    $msg = json_encode(['fileName' => $fileName, 'subject' => $model->subject, 'body' => $model->body]);
                    $producer->publish($msg, 'exchange', 'sheet_process');
                    Yii::$app->session->setFlash('success', 'file uploaded successfully');
                } else {
                    Yii::$app->session->setFlash('error', 'error uploading file');
                }

            } catch (Exception $exception) {
                Yii::$app->session->setFlash('error', 'error uploading file');
            }
        }

        return $this->render('UploadFile', ['model' => $model]);
    }

    public function actionList(): string{
        $files= FileHelper::findFiles(Yii::getAlias('@webroot/processedFiles'));
        return $this->render('List', ['files' => $files]);
    }

    public function actionView(){
        $request = Yii::$app->request;
        $fileName = Yii::getAlias('@webroot/processedFiles/').$request->get('file');
        $data = SheetService::read($fileName);
        return $this->render('View', ['data' => $data]);
    }

}
