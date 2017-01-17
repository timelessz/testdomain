<?php

/**
 * @timelesszhuang<834916321@qq.com>
 */

namespace app\controllers;


use app\models\Crontab;
use app\models\Tools;
use app\models\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * 基类
 * @package backend\components
 */
class CrontabController extends Controller
{
    /**
     * 获取列表 然后判断访问状态
     * @access public
     */
    public function actionIndex()
    {
        $allUrl = Url::find(['id' > 0])->all();
        foreach ($allUrl as $k => $v) {
            $url = $v->url;
            $mail = explode(';', $v->mail);
            $httpCode = Tools::get_url_httpcode($url);
            //表示这个网址有问题 不能访问
            if ($httpCode != 200 && $httpCode != 302) {
                $model = new Crontab();
                $model->url = $url;
                $model->httpcode = $httpCode;
                $model->mailstatus = '30';
                $subject = '网站不能访问请抓紧联系技术人员';
                $html = "以下网址暂时不能访问{$url}，请联系技术人员查看。";
                if (Tools::sendMail($mail, $subject, $html)) {
                    //网址不能访问的情况发送邮件成功
                    $model->mailstatus = '10';
                } else {
                    //发送邮件失败
                    $model->mailstatus = '20';
                }
                $model->save();
            }
        }
    }


}
