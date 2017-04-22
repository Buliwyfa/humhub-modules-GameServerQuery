<?php
/**
 * @author Philipp Horna <globefreak at web.de>
 */
$assets = \humhub\modules\game_server_query\Assets::register($this);

foreach ($server as $id => $data) {

    if (!$data['gq_online']) {
        ?>  
        <div class = "panel panel-default panel-serverquery media" id = "game_server_query">    
            <div class = "panel-heading"><?php echo $data['gq_hostname'] ?></div> 
            <div class = "panel-body content">   
                <p>Server nicht erreicht!</p>   
            </div>
        </div>
        <?php
    } else {

        $numplayers = (empty($data['gq_numplayers']) ? 0 : $data['gq_numplayers']);
        if ($data['gq_type'] != 'mumble') {
            ?>
            <div class = "panel panel-default panel-serverquery media" id = "game_server_query">    
                <div class = "panel-heading"><?php echo $data['gq_name'] ?></div> 
                <div class = "panel-body content">   
                    <p>
                        <?php
                        // Game Server Ausgabe
                        $join = ($data['gq_joinlink'] ? " <a href='" . $data['gq_joinlink'] . "' alt='Verbinden mit: " . $data['gq_hostname'] . "' title='Verbinden mit: " . $data['gq_hostname'] . "'><strong>" . $data['gq_hostname'] . "</strong> <i class='fa fa-sign-in' aria-hidden='true'></i></a>" : "");
                        $password = ($data['gq_password'] == 1 ? "<i class='fa fa-lock' aria-hidden='true' title='Passwort erforderlich!'></i> " : "");
                        ?>               
                        <?php echo $password; ?>
                        <?php echo $join; ?>
                        <span style='float:right'><?php echo $data['gq_numplayers'] . "/" . $data['gq_maxplayers']; ?><i class='fa fa-group' aria-hidden="true"></i></span> 

                    <ul class='gsq_serverlist'>
                        <li>
                            <img src='<?php echo $assets->baseUrl ?>/images/games/<?php echo $data['gq_type'] ?>.jpg' height='16' width='16'/> <?php echo $data['gq_name'] ?>
                        </li>
                        <li>
                            <span><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $data['gq_mapname']; ?></span>
                        </li>
                    </ul>
                    </p>                    
                </div>
            </div>
            <?php
        } else {

            //Mumble Server Ausgabe

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
            <div class = "panel panel-default panel-serverquery media" id = "game_server_query">    
                <div class = "panel-heading"><?php echo $data['gq_name'] ?></div> 
                <div class = "panel-body content">   
                    <p>
                        <a href="mumble://mumble.cwclan.de/?version=1.2.0" alt='Verbinden mit: <?php echo$data['gq_hostname'] ?>' title='Verbinden mit: <?php echo $data['gq_hostname'] ?>'>
                            <img src="<?php echo $assets->baseUrl ?>/images/mumble/mumble-icon.png" alt="Mumble" title="Mumble" height="16" width="16">
                            <strong><?php echo $data['gq_hostname']; ?></strong>  
                            <i class='fa fa-sign-in' aria-hidden='true'></i>
                        </a>
                        <span style='float:right'><?php echo $numplayers; ?>/<?php echo $data['gq_maxplayers']; ?><i class='fa fa-group' aria-hidden="true"></i></span> 
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
                                    echo "<h4><img src='" . $assets->baseUrl . "/images/mumble/list_channel.png' alt='channel'/>" . $channels[$key]['gq_name'] . " [" . count($value) . "]</h4>";
                                    //echo "<pre>" . $channels[$key]['description'] . "</pre>";
                                    echo "<ul class='gsq_mumblelist'>";
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
                    </p>
                    <?php //echo "<pre>".var_dump($data)."</pre>" ?>
                </div>
            </div>
            <?php
        }
    }
}
?>