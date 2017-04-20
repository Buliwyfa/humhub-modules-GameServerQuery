<?php

use yii\helpers\Html;

$assets = \humhub\modules\game_server_query\Assets::register($this);


foreach ($server as $id => $data) {
    if (!$data['gq_online']) {
        ?>
        <div class = "panel">
            <div class = "panel-heading">                    
                <strong>Server Panel</strong>
            </div>
            <div class = "panel-body">
                <p>Server nicht erreicht!</p>
            </div>
        </div>
        <?php
    } else {
        $numplayers = (empty($data['gq_numplayers']) ? 0 : $data['gq_numplayers']);

        function sortByChannel($a, $b) {
            return $a['channel'] - $b['channel'];
        }

        function mumbleOutputOS($os, $osversion) {
            switch ($os) {
                case "Win":
                    echo "<span class='fa fa-windows' title='" . $osversion . "'></span>";
                    break;
                case "WinX64":
                    echo "<span class='fa fa-windows' title='" . $osversion . "'></span>";
                    break;
                case "Osx":
                    echo "<span class='fa fa-apple' title='" . $osversion . "'></span>";
                    break;
                case "X11":
                    echo "<span class='fa fa-linux' title='" . $osversion . "'></span>";
                    break;
                case "Android":
                    echo "<span class='fa fa-android' title='" . $osversion . "'></span>";
                    break;
                default:
                    return false;
                    break;
            }
        }
        ?>
        <div class = "panel panel-default panel-serverquery media" id="game_server_query">

            <!-- Display panel menu widget -->
            <?php echo \humhub\widgets\PanelMenu::widget(array('id' => 'game_server_query')); ?>

            <div class = "panel-heading">Server <strong>Panel</strong></div>      

            <div class = "panel-body content">  
                <a href="mumble://mumble.cwclan.de/?version=1.2.0">
                    <img src="<?php echo $assets->baseUrl ?>/images/mumble/mumble-icon.png" alt="Mumble" title="Mumble" height="16" width="16">
                    <strong><?php echo $data['gq_hostname']; ?></strong>   
                </a>
                <span style='float:right'><?php echo $numplayers; ?>/<?php echo $data['gq_maxplayers']; ?><span class='fa fa-group'></span></span> 
                    <?php
                    if ($numplayers > 0) {
                        $players = $data['players'];
                        $channels = $data['teams'];

                        usort($players, 'sortByChannel');

                        // combine arrays (players with channels)
                        $player_channel = array();
                        foreach ($channels AS $ckey => $cvalue) {
                            foreach ($players AS $pkey => $pvalue) {
                                if ($cvalue['id'] == $pvalue['channel']) {
                                    $player_channel[$ckey][] = $pkey;
                                }
                            }
                        }
                        // output channel and players
                        foreach ($player_channel AS $key => $value) {
                            echo "<h6><img src='" . $assets->baseUrl . "/images/mumble/list_channel.png' alt='channel'/>" . $channels[$key]['gq_name'] . " [" . count($value) . "]</h6>";
                            echo "<ul class='gqpmumblelist'>";
                            foreach ($value AS $pkey => $pvalue) {
                                echo "<li>";
                                echo $players[$pvalue]['gq_name'];
                                echo ($players[$pvalue]['suppress'] == 1 ? "<img src='" . $assets->baseUrl . "/images/mumble/player_suppressed.png' alt='suppressed'/>" : "");
                                echo ($players[$pvalue]['selfMute'] == 1 ? "<img src='" . $assets->baseUrl . "/images/mumble/player_selfmute.png' alt='selfmute'/>" : "");
                                echo ($players[$pvalue]['selfDeaf'] == 1 ? "<img src='" . $assets->baseUrl . "/images/mumble/player_selfdeaf.png' alt='selfdeaf'/>" : "");
                                echo ($players[$pvalue]['userid'] != -1 ? "<img src='" . $assets->baseUrl . "/images/mumble/player_auth.png' alt='suppressed'/>" : "");
                                if (!Yii::$app->user->isGuest) {
                                    echo "<span class='fa fa-clock-o' title='Online seit:" . date("H:i:s", $players[$pvalue]['onlinesecs'] + strtotime("1970/1/1")) . ", davon AFK:" . date("H:i:s", $players[$pvalue]['idlesecs'] + strtotime("1970/1/1")) . "'></span>";
                                    echo "<img src='" . $assets->baseUrl . "/images/games/" . $data['gq_type'] . ".jpg' title='" . "Mumble Version " . $players[$pvalue]['release'] . "' height='16' width='16'/>";
                                    mumbleOutputOS($players[$pvalue]['os'], $players[$pvalue]['osversion']);
                                }
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                    }
                    ?>
            </div>
        </div>
        <?php
    }
}
?>






