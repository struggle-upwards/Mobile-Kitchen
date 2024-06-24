<?php

class Address extends BaseModel {
	
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{address}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		);
    }

    public function rules() {

      return $this->attributeRule();
    }
    public function validateIsDefault($attribute,$params)
    {
        if ($this->isdefault == 1) {
            $query = self::find()
                ->where([
                    'gf_account' => $this->gf_account,
                    'isdefault' => 1,
                ]);

            // 如果是更新操作，需要排除当前记录
            if (!$this->isNewRecord) {
                $query->andWhere(['not', ['id' =>$this->id]]);
            }

            if ($query->exists()) {
                $this->addError($attribute, '每个用户只能设置一个默认项。');
            }
        }
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
	    'id' =>'ID',
        'gf_account' => '用户账号:k',
        'name' => '联系人',
        'phone' => '收货手机',
        'ads_detail' => '详细地址',
        'province' => '省',
        'city' => '城市',
        'district' => '区',
        'isDefault' => '默认地址',
        'fullAddress' => '完整地址',
        'add_time' => '添加时间',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->add_time = date('Y-m-d H:i:s');
        }
        return true;
    }

}