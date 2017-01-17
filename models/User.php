<?php
namespace app\models;

use yii\base\NotSupportedException;

/**
 * @property mixed uid
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }


    /**
     * @inheritdoc
     * 验证规则
     */
    public function rules()
    {
        return [
            [['name', 'password'], 'required', 'on' => ['create'], 'message' => '{attribute}不能为空'],
            [['password'], 'string', 'max' => 16, 'min' => 6],
            [['name'], 'string', 'max' => 32, 'on' => ['create'], 'message' => '用户名最大32个字符'],
            [['screenName'], 'string', 'max' => 32, 'message' => '昵称最大32个字符'],
            [['name'], 'checkName', 'on' => ['create']],
            [['screenName'], 'checkName', 'skipOnEmpty' => false],
            [['name'], 'unique', 'on' => ['create']],
            [['screenName'], 'unique', 'on' => ['create', 'update']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'name' => '用户名',
            'password' => '密码',
            'screenName' => '昵称',
            'created' => '创建时间',
            'activated' => '活跃时间',
            'logged' => '登录时间',
            'group' => '用户组',
            'authCode' => 'Auth Code',
        ];
    }


    /**
     * @inheritdoc
     * @access public 获取账号实体
     */
    public static function findIdentity($id)
    {
        return static::findOne(['uid' => $id,]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $info = static::findOne(['name' => $username]);
        return $info;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authCode;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authCode === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authCode = \Yii::$app->security->generateRandomString();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function generatePassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * 验证登陆信息
     * ＠access public
     */
    public function checkName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (($attribute == 'name') || ($attribute == 'screenName' && $this->$attribute != '')) {
                if (!self::checkCleanStr($this->$attribute)) {
                    $this->addError($attribute, $this->getAttributeLabel($attribute) . '只能为数字字母下划线横线');
                }
            }
        }
    }


    /**
     * 检测干净的字符串
     * @param $str
     * @return bool
     */
    public static function checkCleanStr($str)
    {
        //\w任何单词字符
        if (preg_match('/[^\w_-]/u', $str)) {
            return false;
        } else {
            return true;
        }
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
                $this->generatePassword($this->password);
            } elseif ($this->scenario == 'update' || $this->scenario = 'profile') {
                if (trim($this->password) == '') {
                    // 密码不填写  默认不修改
                    $this->password = $this->getOldAttribute('password');
                } else {
                    $this->generatePassword($this->password);
                }
                $this->activated = time();
            }
            if ($insert) {
                //还需要更新 id字段 该字段需要自增
                $this->created = time();
                $this->generateAuthKey();
            }
            if (trim($this->screenName) == '') {
                //没有填写 姓名的时候 更新
                $this->screenName = $this->name;
            }
            return true;
        } else {
            return false;
        }
    }


}
