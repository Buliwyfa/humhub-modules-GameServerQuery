<?php

/**
 * Description of humhub\modules\reputation\controllers\WallController
 * * The SpaceController for content reputation
 * * Show different sorting options to get a better overview over popular posts
 *
 * @author Anton Kurnitzky (v0.11) & Philipp Horna (v0.20+) */

namespace humhub\modules\game_server_query\controllers;

use humhub\modules\content\components\ContentContainerController;

class ServerController extends ContentContainerController {

    public $hideSidebar = false;

    /**
     * Shows the reputation_content space
     */
    public function actionIndex() {

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
        return $this->render('index', array(
                    'server' => $server
        ));
    }

}
