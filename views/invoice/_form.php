<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Invoice;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */

$url = $model->isNewRecord ? '/invoice/create' : '/invoice/update?id='.$model->id;

$js = <<<JS
    $('.save').on('click', function () {
        $.ajax({
            type: "post",
            url: "$url",
            data: $('#invoice-form').serialize()
        }).done(function(res) {
            var response = JSON.parse(res);
            if(response.success){
                $('#modal').modal('hide');
                $.pjax({container: '#pjax-grid-view'})
            }
        });
    })
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'invoice-form'
        ]
    ]); ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'where')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Invoice::statuses(), ['prompt' => 'Выбрать']) ?>

    <div class="form-group">
        <?= Html::button('Сохранить', ['class' => 'btn btn-success pull-left save']) ?>
        <?php if(!$model->isNewRecord) : ?>
            <?= Html::a('удалить', Url::to(['invoice/delete', 'id' => $model->id]), ['class' => 'btn btn-danger pull-right']); ?>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>

    <?php ActiveForm::end(); ?>

</div>
