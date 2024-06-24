<?php

class ClubNews extends BaseModel {

    public  $club_list='';
    public  $club_news_video='';
    public  $club_news_pic='';
	public  $recommend_club_id='';
	public  $project_id='';
	public $news_content_temp = '';
    public function tableName() {
        return '{{club_news}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('news_title', 'required', 'message' => '{attribute} 不能为空'),
			array('news_pic', 'required', 'message' => '{attribute} 不能为空'),
            array('order_num', 'numerical', 'integerOnly' => true),
            array('news_video,news_title,news_pic,news_content_temp,news_content,club_id,pic_sourcer,pic_editor,pic_create,
                pic_auditing,pic_editor_chief,
                news_type,news_introduction,news_date_start,news_date_end,state,state_time,reasons_for_failure,if_del,recommend_type,apply_time,top_time,top_num','safe'),
        );
    }
        
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'project_list' => array(self::BELONGS_TO, 'ClubNewsProject', 'project_id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'news_video'),
            'rec_club' => array(self::BELONGS_TO, 'ClubNewsRecommend', 'recommend_clubid'),


        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'no' => '序号',
            'news_code'=>'编号',
            'news_title'=>'标题',
			'news_pic'=>'缩略图',
            'club_news_pic'=>'子图',
			'news_video'=>'视频',
            'news_type'=>'类型',
            'news_type_name'=>'类型',
            'news_introduction'=>'信息简介',
            'news_content'=>'图文内容',
            'club_id'=>'发布单位',
            'news_clicked'=>'点击量',
            'collection_num'=>'收藏数',
            'version'=>'版本号',
            'order_num'=>'排序号',
            'news_date_start'=>'上线时间',
            'news_date_end'=>'下线时间',
            'uDate'=>'操作时间',
            'state'=>'状态',
            'reasons_for_failure'=>'操作备注',
            'state_qmddid'=>'审核员',
            'state_time'=>'审核时间',
            'if_del'=>'是否使用',
			'club_list'=>'推荐到单位',
			'project_id'=>'项目',
            'recommend_type' => '推荐至单位',
            'pic_sourcer'=>'图片来源',
            'pic_editor' => '编辑',
            'pic_create' => '制作',
            'pic_auditing' => '图片审核',
            'pic_editor_chief' => '总编辑',
            'apply_time'=>'申请时间',
            'top_time'=>'置顶时间',

        );
    }

    //关联数据自动处理
    public function getrelations() {
      $s1='club_list,club_id:id,club_name';     
     // $s1.='goodsreport,f_rid:id,f_timeid:timeid&f_timetype:timetype';
      return $s1;
    }
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();

        if ($this->id != null) {
            $project = ClubNewsProject::model()->findAll('club_news_id=' . $this->id);
            $arr = array();
            foreach ($project as $v) {
                $arr[] = $v->project_id;
            }
            $this->project_list = implode(',', $arr);

            $club = ClubNewsRecommend::model()->findAll('news_id=' . $this->id);
            $arr = array();
            foreach ($club as $v) {
                $arr[] = $v->recommend_clubid;
            }
            $this->club_list = implode(',', $arr);
        }

        
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        // 图文描述处理
        $basepath = BasePath::model()->getPath(124);
        if (!empty($this->news_content_temp)) {
            // 判断是否存储过，没有存储过则保存新文件
            if (!empty($this->news_content)) {
                set_html($this->news_content, $this->news_content_temp, $basepath);
            } else {
                $rs = set_html('', $this->news_content_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->news_content = $rs['filename'];
            }
        } else {
            $this->news_content = '';
        }
        if($this->state==2){
            $this->state_time = date('Y-m-d H:i:s');
        }else if($this->state==373){
            $this->state_time = date('Y-m-d H:i:s');
        }else if ($this->state==371) {
            $this->apply_time = date('Y-m-d H:i:s');
        }
        $this->uDate = date('Y-m-d H:i:s');  
        return true;
    }



}
