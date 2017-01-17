<?php
/**
 * Created by PhpStorm.
 * User: timeless
 * Date: 17-1-13
 * Time: 上午11:53
 */

namespace app\models;

use yii\db\ActiveRecord;

class Crontab extends ActiveRecord
{

    /**
     * @inheritdoc
     * 定义表名称
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * 更新或者添加数据之前
     * @param bool $insert 表示是不是插入的
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created = time();
            return true;
        } else {
            return false;
        }
    }


}