<?php

use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'subject')->textInput() ?>
<?= $form->field($model, 'body')->textarea() ?>
<?= $form->field($model, 'emailsFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>