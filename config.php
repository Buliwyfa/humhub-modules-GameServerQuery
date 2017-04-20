<?php

use humhub\modules\dashboard\widgets\Sidebar;

return [
    'id' => 'game_server_query',
    'class' => 'humhub\modules\game_server_query\Module',
    'namespace' => 'humhub\modules\game_server_query',    
    'events' => [
        ['class' => Sidebar::className(), 'event' => Sidebar::EVENT_INIT, 'callback' => ['humhub\modules\game_server_query\Module', 'onSidebarInit']],
    ],
];
?>