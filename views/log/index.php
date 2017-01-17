<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理用户';
?>
<div class="user-index">
    <p>
        <a href="http://tool.oschina.net/commons?type=5" target="_blank">http状态码详解？请点击。</a>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "{begin}-{end}，共{totalCount}条数据，共{pageCount}页",
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'label' => '链接',
                'format' => 'html',
                'value' => function ($data) {
                    return "<a href='{$data->url}' target='_blank'>{$data->url}</a>";
                },
            ],
            ['label' => 'http状态码', 'value' => 'httpcode'],
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'label' => '添加时间',
                'value' => function ($data) {
                    switch ($data->mailstatus) {
                        case '10':
                            $val = '提醒成功';
                            break;
                        case '20':
                            $val = '提醒失败';
                            break;
                        default:
                            $val = '无需提醒';
                            break;
                    }
                    return $val;
                },
            ],
            ['class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'label' => '添加时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s', $data->created);
                }],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>
</div>

