<?php

/**
 * @author Philipp Horna <globefreak at web.de>
 */
namespace humhub\modules\game_server_query;

use Yii;

class Events {  

    public static function onDashboardSidebarInit($event) {
        if (Yii::$app->hasModule('game_server_query')) {
            $event->sender->addWidget(widgets\ServerPanel::className(), array(), array('sortOrder' => 1));
        }
    }    

    public static function onSpaceSidebarInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

         $space = $event->sender->space;
        if ($space->isModuleEnabled('game_server_query')) {
            $event->sender->addWidget(widgets\ServerPanel::className(), array(), array('sortOrder' => 1));
        }
    }

}
