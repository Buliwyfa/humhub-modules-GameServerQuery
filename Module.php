<?php

/**
 * @author Philipp Horna <globefreak at web.de> 
 */

namespace humhub\modules\game_server_query;

use Yii;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerActiveRecord;

class Module extends \humhub\modules\content\components\ContentContainerModule {

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function enable() {
        parent::enable();
    }

    /**
     * @inheritdoc
     */
    public function disable() {
        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes() {
        return [
            Space::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerName(ContentContainerActiveRecord $container) {
        return Yii::t('GameServerQueryModule.base', 'Game Server Query');
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerDescription(ContentContainerActiveRecord $container) {
        if ($container instanceof Space) {
            return Yii::t('GameServerQueryModule.base', 'Query a lot different servers based on GameQ.');
        }
    }

    /**
     * @inheritdoc
     */
    public function disableContentContainer(ContentContainerActiveRecord $container) {
        parent::disableContentContainer($container);
    }

}

?>