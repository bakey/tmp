<?php

class VideoWidget extends CWidget {

    private $_error = array();
    // 定义视频服务地址
    public $videoServiceDomain = '192.168.1.101';
    public $swfPlayerServiceDomain;
    public $options = array();
    // 定义播放器内部参数
    private $videoOptions = array(
        // 定义视图div的id值
        'id' => '',
        // 定义 obj 宽高
        'width' => '320',
        'height' => '280',
        // 定义视频获取的质量
        'quality' => 'high',
        // 定义播放器默认背景颜色
        'bgcolor' => '#ffffff',
        // 允许全屏？
        'allowfullscreen' => 'true',
        // swfobject 相对外层 div 位置
        'align' => 'left',
        // 定义需要获取的 swf 类型：播放端(play)，采集端(record)，文档播放器(reader)
        'method' => '',
        // 播放端/录制段参数：视频流名称
        'name' => '',
        // 文档播放器参数：swf文档路径
        'richMediaURL' => '',
    );
    // 运行变量
    private $runOptions = array();
    private $_assetsUrl;

    public function init() {
        $this->_assetsUrl = Yii::app()->
                getAssetManager()->
                publish(Yii::getPathOfAlias('application.modules.teach.components.assets.video'));

        $this->swfPlayerServiceDomain = $_SERVER['SERVER_NAME'];

        $this->videoOptions = array_merge($this->videoOptions, $this->options);

        // 获取 swf 根地址
        $swfBaseUrl = $this->_assetsUrl . '/';
        // 获取视频流根地址
        $mediaBaseUrl = 'rtmp://' . $this->videoServiceDomain . '/app/';

        $this->runOptions = $this->videoOptions;

        $this->runOptions['id'] = $this->videoOptions['id'] ? $this->videoOptions['id'] : rand(1, 500);

        // 播放端参数设定
        if ($this->videoOptions['method'] == 'play') {

            $this->runOptions['swfName'] = 'PlayerClient';

            // 获取播放端 swf 地址
            $this->runOptions['swfUrl'] = $swfBaseUrl . $this->runOptions['swfName'] . '.swf';

            // 获取视频流地址
            if (!isset($this->videoOptions['name'])) {
                $this->_error['play'] = Yum::t('Video name is not defined in video options.');
            }

            $this->runOptions['streamName'] = $this->videoOptions['name'];
            $this->runOptions['streamURL'] = $mediaBaseUrl;
        }

        // 录制段参数设定
        else if ($this->videoOptions['method'] == 'record') {

            $this->runOptions['swfName'] = 'RecordClient';

            // 获取录制端 swf 地址
            $this->runOptions['swfUrl'] = $this->_assetsUrl . '/' . $this->runOptions['swfName'] . '.swf';

            // 定义视频名称
            if (!isset($this->videoOptions['name'])) {
                $this->videoOptions['name'] = md5((Yii::app()->user->isGuest ? rand(1, 1000) : Yii::app()->user->name));
            }

            // 获取视频流地址
            $this->runOptions['streamName'] = $this->videoOptions['name'];
            $this->runOptions['streamURL'] = $mediaBaseUrl;
        }

        // 文档播放器参数设定
        else if ($this->videoOptions['method'] == 'reader') {

            $this->runOptions['swfName'] = 'RichMediaReader';

            // 获取文档播放器 swf 地址
            $this->runOptions['swfUrl'] = $swfBaseUrl . $this->runOptions['swfName'] . '.swf';

            // 获取文档地址
            if (!isset($this->videoOptions['richMediaURL']))
                $this->_error['reader'] = ('Faild to run rich media player : the media url is NOT set!');
            $this->runOptions['richMediaURL'] = $this->videoOptions['richMediaURL'];
        }

        // 返回错误
        else {
            $this->_error['method'] = 'Method is not right. The Method must be "play" "record" or "reader"';
            return false;
        }
    }

    public function run() {
        $this->registerJs();
        $this->render('videoWidget', array(
            'runOptions' => $this->runOptions,
            'error' => $this->_error,
        ));
    }

    public function registerJs() {
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
        $cs->registerScriptFile($cs->getCoreScriptUrl() . '/jui/js/jquery-ui.min.js');
        $cs->registerScriptFile($this->_assetsUrl . '/swfobject.js');
    }

}

?>
