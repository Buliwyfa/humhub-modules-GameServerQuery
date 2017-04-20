<?php

/**
 * @author globeFrEak
 */
class Events {

    /**
     * TopMenu
     *
     * @param CEvent $event
     */
    public static function onTopMenuInit($event) {
        $event->sender->addItem(array(
            'label' => Yii::t('Module.base', 'Steam Group'),
            'url' => 'http://steamcommunity.com/groups/CW-CLAN',
            'icon' => '<i class="fa fa-steam-square"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'game_server_query'),
        ));
    }

    /**
     * Sidebar
     * 
     * @param CEvent $event
     */
    public static function onDashboardSidebarInit($event) {
        $event->sender->addWidget('application.modules.game_server_query.widgets.ServerPanel', array(), array('sortOrder' => 1));
    }

}
