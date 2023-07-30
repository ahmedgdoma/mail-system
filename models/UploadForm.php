<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $emailsFile;
    public $subject;
    public $body;

    public function rules(): array
    {
        return [
            [['emailsFile', 'subject', 'body'], 'required'],
            [['emailsFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['xlsx', 'xls']],
        ];
    }

    public function upload(): bool|string
    {
        if ($this->validate()) {
            $fileName = Yii::getAlias('@webroot/uploads'). DIRECTORY_SEPARATOR . $this->emailsFile->baseName . '_'. time() . '.' . $this->emailsFile->extension;
            $this->emailsFile->saveAs($fileName);
            return $fileName;
        } else {
            return false;
        }
    }
}