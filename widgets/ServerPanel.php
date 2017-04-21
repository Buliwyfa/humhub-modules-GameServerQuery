<?php

/**
 * @author Philipp Horna <globefreak at web.de>
 */

namespace humhub\modules\game_server_query\widgets;

class ServerPanel extends \humhub\components\Widget {

    public function run() {

        // servers to query
        $servers = [
            [
                'type' => 'mumble',
                'host' => 'mumble.cwclan.de:64738',
                'options' => [
                    'query_port' => 27800,
                ]
            ],
            [
                'type' => 'css',
                'host' => 'cwclan.de:27015',
                'options' => [
                    'query_port' => 27015,
                ]
            ],
        ];

        require(__DIR__ . '/../assets/GameQ/Autoloader.php');
        $gq = new \GameQ\GameQ();
        $gq->addServers($servers);
        $server = $gq->process();
        return $this->render('serverPanel', array(
                    'server' => $server
        ));
    }

}

?>