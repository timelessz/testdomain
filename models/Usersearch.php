<?php

/**
 * http://www.yiifans.com/yii2/guide/ref-gridview.html gridview 查询实现
 * User: timeless
 * Date: 17-1-12
 * Time: 下午4:55
 */

namespace app\models;


class Usersearch extends User
{

    public function rules()
    {
        // 只有在 rules() 的字段才能被搜索
        return [
            [['id'], 'integer'],
            [['title', 'creation_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass 父类实现的scenarios()
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Post::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // 加载搜索表单数据并验证
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // 通过添加过滤器来调整查询语句
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->name])
            ->andFilterWhere(['like', 'creation_date', $this->creation_date]);

        return $dataProvider;
    }
}