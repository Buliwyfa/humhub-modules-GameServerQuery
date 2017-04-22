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

    public static function onSpaceSidebarInit($event) {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $space = $event->sender->space;
        if ($space->isModuleEnabled('game_server_query') && !Yii::$app->controller->module->id == 'game_server_query') {
            $event->sender->addWidget(widgets\ServerPanel::className(), array(), array('sortOrder' => 1));
        }
    }

    /*
     * Show reputation menu in space menu
     * 
     * @param type $event
     */

    public static function onSpaceMenuInit($event) {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('game_server_query')) {
            $event->sender->addItem(array(
                'label' => Yii::t('GameServerQueryModule.base', 'Server'),
                'url' => $event->sender->space->createUrl('/game_server_query/server'),
                'icon' => '<i class="fa fa-server"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'game_server_query'),
                'group' => 'modules',
                'sortOrder' => 1000,
            ));
        }
    }

}
