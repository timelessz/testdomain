<?php

namespace app\controllers;

use app\models\Shuaidan;
use Yii;

class Acceptshuaidan extends Controller
{

    /**
     * 接收甩单
     * ＠accept public
     */
    public function actionAcceptshuaidan()
    {
        header('Access-Control-Allow-Origin:*');
        $model = new Shuaidan();
        if (!Yii::$app->request->isPost) {
            exit('请求方式不正确。');
        }
        $model->name = Yii::$app->request->post('name');
        $model->phone = Yii::$app->request->post('phone');
        $model->email = Yii::$app->request->post('email');
        $model->company = Yii::$app->request->post('company');
        $model->ip = Yii::$app->request->post('ip');
        $model->pos = Yii::$app->request->post('pos');
        $model->page = $_SERVER['HTTP_REFERER'];
        $model->type = Yii::$app->request->post('shuaidan_type');
        if ($model->save()) {
            //添加成功
            exit(json_encode(array("status" => 'success', "msg" => '我们已经收到您的甩单，会在两个小时之内联系您，如有疑问请拨打 400660163 联系我公司')));
        }
        //添加失败
        exit(json_encode(array("status" => 'failed', "msg" => '提交试用信息失败，请拨打 4006360163 联系我们。')));
    }


}
