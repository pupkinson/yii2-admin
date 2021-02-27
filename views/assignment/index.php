<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'buttons' => [
        'update' =>  function($url,$model) {
            return Html::a('<i class="fas fa-edit"></i>', $url, [
                'title' => Yii::t('app', 'update')
            ]);
        },
        'view' =>  function($url,$model) {
            return Html::a('<i class="fas fa-eye"></i>', $url, [
                'title' => Yii::t('app', 'view')
            ]);
        },
        'delete' => function($url,$model) {
            return Html::a('<i class="fas fa-trash"></i>', $url, [
                'title' => Yii::t('app', 'delete')
            ]);
        }
    ],
    'template' => '{view}'
];
?>
<div class="assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
