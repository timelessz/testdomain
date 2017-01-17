<?php
/**
 * Created by PhpStorm.
 * User: timeless
 * Date: 17-1-13
 * Time: 上午11:53
 */

namespace app\models;

use yii\db\ActiveRecord;

class Shuaidan extends ActiveRecord
{


    /**
     * @inheritdoc
     * 定义表名称
     */
    public static function tableName()
    {
        return '{{%shuaidan}}';
    }


    /**
     * 更新或者添加数据之前
     * @param bool $insert 表示是不是插入的
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $ip = $this->ip;
            if ($ip) {
                $ipinfo = $this->get_ip_info($ip);
                $this->country = $ipinfo["data"]["country"];
                $this->area = $ipinfo["data"]["area"];
                $this->region = $ipinfo["data"]["region"];
                $this->city = $ipinfo["data"]["city"];
                $this->county = $ipinfo["data"]["county"];
                $this->isp = $ipinfo["data"]["isp"];
            }
            switch ($this->type) {
                case"1":
                    $this->type_name = '邮箱';
                    break;
                case "2":
                    $this->type_name = '有道';
                    break;
                case "3":
                    $this->type_name = '七鱼';
                    break;
            }
            $this->addtime = time();
            return true;
        } else {
            return false;
        }
    }


    /**
     * 获取ip 接口
     * @param $ip
     * @return
     */
    public function get_ip_info($ip)
    {
        $curl = curl_init(); //这是curl的handle
        //下面是设置curl参数
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=$ip";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_HEADER, 0); //don't show header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //相当关键，这句话是让curl_exec($ch)返回的结果可以进行赋值给其他的变量进行，json的数据操作，如果没有这句话，则curl返回的数据不可以进行人为的去操作（如json_decode等格式操作）
        curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        //这个就是超时时间了
        $data = curl_exec($curl);
        return json_decode($data, true);
    }


}