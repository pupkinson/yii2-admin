<?php

use mdm\admin\components\UserStatus;
use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;
use yii\helpers\Url;;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'persistResize' => 'true',
        'pjax'=>true,
        'pjaxSettings'=>
        [
            'neverTimeout'=>true,
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'value' => function($model) {
                    return Html::a($model->username, Url::to(['view', 'id' => $model->id]), ['title' => Yii::t('app', 'view')]);
                },
                'format' => 'raw',
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == UserStatus::ACTIVE ? 'Active' : 'Inactive';
                },
                'filter' => [
                    UserStatus::INACTIVE => 'Inactive',
                    UserStatus::ACTIVE => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['deactivate', 'activate', 'update', 'delete']),
                'buttons' => [
                    'activate' => function($url, $model) {
                        if ($model->status == UserStatus::ACTIVE) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fas fa-check-square"></span>', $url, $options);
                    },
                    'deactivate' => function($url, $model) {
                        if ($model->status != UserStatus::ACTIVE || ($model->getId() == Yii::$app->user->identity->getId())) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Dectivate'),
                            'aria-label' => Yii::t('rbac-admin', 'Dectivate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to deactivate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fas fa-times"></span>', $url, $options);
                    },
                    'update' =>  function($url,$model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'update'),
                            'data-pjax' => '0'
                        ]);
                    },
                    'view' =>  function($url,$model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'view'),
                            'data-pjax' => '0'
                        ]);
                    },
                    'delete' => function($url,$model) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'delete'),
                            'data-pjax' => '0'
                        ]);
                    }
                    ]
                ],
            ],
        ]);
        ?>
</div>
