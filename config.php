<?php

/**
 * @author Philipp Horna <globefreak at web.de> 
 */
use humhub\widgets\BaseMenu;

return [
    'id' => 'game_server_query',
    'class' => 'humhub\modules\game_server_query\Module',
    'namespace' => 'humhub\modules\game_server_query',
    /* 'modules' => [
      'gsq_dashboard' => [
      'class' => 'humhub\modules\custom_pages\modules\gsq_dashboard\Module'
      ],
      ], */
    'events' => [
        ['class' => 'humhub\modules\dashboard\widgets\Sidebar', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\game_server_query\Events', 'onDashboardSidebarInit']],
        ['class' => 'humhub\modules\space\widgets\Sidebar', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\game_server_query\Events', 'onSpaceSidebarInit']],
        ['class' => 'humhub\modules\space\widgets\Menu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\game_server_query\Events', 'onSpaceMenuInit']], 
    ],
];
?>