<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Invoice;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Invoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Накладные';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.apply').on('click', function () {
        var ids = $('.grid-view').yiiGridView('getSelectedRows');
        $.ajax({
            type: "post",
            url: "/invoice/delete-all",
            data: {ids: ids}
        }).done(function() {
            $.pjax({container: '#pjax-grid-view'})
        });
    })
JS;

?>
<div class="invoice-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin(['id' => 'pjax-grid-view']); ?>

    <?php $this->registerJs($js, \yii\web\View::POS_READY); ?>

    <p>
        <?= Html::a('Создать накладную', '#', ['value' => Url::to(['invoice/create']), 'class' => 'showModalButton btn btn-success']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=> '',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                }
            ],
            'from',
            'where',
            'recipient',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return Invoice::statuses()[$model->status];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} | {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('изменить', '#', ['value' => Url::to(['invoice/update', 'id' => $model->id]), 'class' => 'showModalButton']);
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('удалить', Url::to(['invoice/delete', 'id' => $model->id]));
                    }
                ]
            ],
        ],
    ]); ?>

    <?php if($dataProvider->count > 0) : ?>

        <div>
            <div class="pull-left" style="margin-right: 15px">
                <?=Html::dropDownList('actions', [], ['Удалить'], ['class' => 'form-control'])?>
            </div>
            <div class="pull-left">
                <?=Html::button('Применить', ['class' => 'btn btn-success apply'])?>
            </div>
        </div>

    <?php endif; ?>

    <?php Pjax::end(); ?>
</div>

<?php Modal::begin([
    'id' => 'modal',
    'headerOptions' => [
        'id' => 'mHeader'
    ],
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]); ?>
<div id="mContent"></div>
<?php Modal::end(); ?>
