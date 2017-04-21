<?php

/**
 * @author Philipp Horna <globefreak at web.de> 
 */

namespace humhub\modules\game_server_query;

use yii\web\AssetBundle;

class Assets extends AssetBundle {

    public $css = [
        'game_server_query.css'
    ];

    public function init() {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
