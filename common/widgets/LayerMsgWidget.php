<?php

namespace common\widgets;

use yii\base\Widget;

class LayerMsgWidget extends Widget
{
    public $message;
    public $type;
    public $options = [];
    public $timeout = 3000;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Default message';
        }
        if ($this->type === null) {
            $this->type = 'info';
        }
    }

    public function run()
    {
        $icon = $this->getLayerIcon($this->type);
        $options = json_encode($this->options);
        return "<script>layer.msg('" . addslashes($this->message) . "', {icon: " . $icon . ", time:" . $this->timeout . ", ...$options});</script>";
    }

    private function getLayerIcon($type)
    {
        $icons = [
            'success' => 1,
            'error' => 2,
            'warning' => 3,
            'info' => 4,
        ];
        return isset($icons[$type]) ? $icons[$type] : 0;
    }
}
