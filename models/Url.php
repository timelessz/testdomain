<?php
/**
 * Created by PhpStorm.
 * User: timeless
 * Date: 17-1-13
 * Time: 上午11:53
 */

namespace app\models;

use yii\db\ActiveRecord;

class Url extends ActiveRecord
{

//    public $id;
//    public $url;
//    public $mail;
//    public $detail;
//    public $created;
//    public $updated;

    /**
     * @inheritdoc
     * 定义表名称
     */
    public static function tableName()
    {
        return '{{%url}}';
    }

    /**
     * @inheritdoc
     * 验证规则
     */
    public function rules()
    {
        return [
            [['url', 'mail', 'detail'], 'required', 'on' => ['create'], 'message' => '{attribute}必须填写'],
            ['url', 'url', 'defaultScheme' => 'http'],
            [['detail'], 'string', 'max' => 32, 'on' => ['create', 'update'], 'message' => '用户名最大32个字符'],
            [['mail'], 'checkMail', 'on' => ['create', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'url' => '检测url',
            'mail' => '邮箱地址',
            'detail' => '描述',
            'created' => '创建时间',
            'updated' => '更新时间',
        ];
    }

    /**
     * 更新或者添加数据之前
     * @param bool $insert 表示是不是插入的
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->scenario == 'create') {
                $this->created = time();
                $this->updated = time();
            } elseif ($this->scenario == 'update') {
                $this->updated = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检测邮箱地址是不是正确
     * @param $attribute
     * @param $params
     */
    public function checkMail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (($attribute == 'mail') && $this->$attribute != '') {
                $mail_arr = explode(';', $this->$attribute);
                foreach ($mail_arr as $k => $v) {
                    if (!$this->checkMailAddress($v)) {
                        $this->addError($attribute, $this->getAttributeLabel($attribute) . "{$v} 邮件地址不正确。");
                    }
                }

            }
        }
    }

    /**
     * 验证邮箱地址
     * @access private
     * @param $mailaddress
     * @return bool
     */
    private function checkMailAddress($mailaddress)
    {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if (preg_match($pattern, $mailaddress)) {
            return true;
        }
        return false;
    }


}