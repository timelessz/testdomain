<?php
/**
 * Created by PhpStorm.
 * User: timeless
 * Date: 17-1-13
 * Time: 上午11:53
 */

namespace app\models;

use yii\base\Model;

class Tools extends Model
{
    /**
     * 请求制定的网址
     * @access public
     * @param $url
     * @return
     */
    public static function get_url_httpcode($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
        #curl_setopt( $ch, CURLOPT_POSTFIELDS, "username=".$username."&password=".$password );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode;
    }

    /**
     * 发送邮件实例
     * @access public
     * @param $tomail 邮箱地址 array形式
     * @param $subject 主题
     * @param $html 　要发送的html信息
     * @return boolean
     */
    public static function sendMail($tomail, $subject, $html)
    {
        $mail = \Yii::$app->mailer->compose();
        $mail->setFrom('support@qiangbi.net')
            ->setTo($tomail)
            ->setSubject($subject)
            ->setHtmlBody($html);    //发布可以带html标签的文本
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

}