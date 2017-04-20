<?php

/**
 * 
 * @author globeFrEak
 */
namespace humhub\modules\game_server_query\widgets;

use Yii;
use humhub\modules\dashboard\widgets\Sidebar;

class ServerPanel extends \humhub\components\Widget {   

    public function run() {
        require(__DIR__ . '/../assets/GameQ/Autoloader.php');
        $gq = new \GameQ\GameQ();
        $gq->addServer([
            'type' => 'mumble',
            'host' => 'mumble.cwclan.de:64738',
            'options' => [
                'query_port' => 27800,
            ],
        ]);                
        $server = $gq->process();
        return $this->render('serverPanel', array(
            'server' => $server
        ));
    }

}

?>