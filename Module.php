<?php

/**
 * @author globeFrEak
 */

namespace humhub\modules\game_server_query;

use Yii;
use yii\helpers\Url;

/**
 * BirthdayModule is responsible for the the birthday functions.
 * 
 * @author Sebastian Stumpf Changes by Philipp Horna
 */
class Module extends \humhub\components\Module
{
    /**
     * On build of the dashboard sidebar widget, add the birthday widget if module is enabled.
     *
     * @param type $event
     */
    public static function onSidebarInit($event)
    {   
    	if (Yii::$app->hasModule('game_server_query')) {
            $event->sender->addWidget(widgets\ServerPanel::className(), array(), array(
                'sortOrder' => 1
            ));
        }
    }

      /**
     * Enables this module
     */
    public function enable()
    {        
        parent::enable();
    }
}
?>