<?php

include 'DatabaseFacade.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $function = $_POST['function'];
	$id = $_POST['id'];
    $log = array();

    switch($function) {

		case('addCourt'):

    $name = $_POST['name'];
    $userlat = $_POST['lat'];
    $userlong = $_POST['long'];
    $courtID = addCourt($name,$userlat,$userlong);



    echo $courtID;
    break;




		case('getChatState'):
			$chatlog = "chat/logs/$id.txt";
			if(file_exists($chatlog)){
				$lines = file($chatlog);
			}
			$log['state'] = count($lines);
			break;

		case('updateChat'):
			$chatlog = "chat/logs/$id.txt";
			$state = $_POST['state'];
			if(file_exists("$chatlog")){
				$lines = file("$chatlog");
			}

			$count =  count($lines);
			if($state == $count){
		 		$log['state'] = $state;
		 		$log['text'] = false;
			}
			else{
				$text= array();
				$log['state'] = $state + count($lines) - $state;
				foreach ($lines as $line_num => $line){
		  			if($line_num >= $state){
						$text[] =  $line = str_replace("\n", "", $line);
		  			}
				}
				$log['text'] = $text;
			}
			break;

		case('sendChat'):
			$chatlog = "chat/logs/$id.txt";
			$nickname = htmlentities(strip_tags($_POST['nickname']));
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			$message = htmlentities(strip_tags($_POST['message']));
			if(($message) != "\n"){
				if(preg_match($reg_exUrl, $message, $url)) {
					$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				}
				fwrite(fopen("$chatlog", 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n");
			}
			break;
	}
	echo json_encode($log);
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $function = $_GET['function'];
   	$id = $_GET['id'];
    $log = array();
    $chatlog = "chat/logs/$id.txt";

      switch($function) {
        case('getCourt'):
        $chatlog = "chat/logs/$id.txt";

          $userlat = $_GET['lat'];
          $userlong = $_GET['long'];
          $range1 = $_GET['rangeLat'];
          $range2 = $_GET['rangeLong'];
          $courts = getCourtsInRange( $userlat,$userlong,array($range2,$range1));
          $courts_array = array();
          foreach($courts as $court)
          {
            array_push($courts_array, $court);
          }
          #fwrite(fopen("$chatlog", 'a'), $userlat);
          #fwrite(fopen("$chatlog", 'a'), $userlong);
          header('Content-type: application/json');
          echo json_encode($courts_array);
          break;

        case('getCourtGames'):
          $courtID = $_GET['courtID'];
          $games = getGamesByCourtID($courtID);
          $games_array = array();
          foreach($games as $game)
          {

            array_push($games_array, $game);
          }

          header('Content-type: application/json');
          echo json_encode($games_array);
          break;

        case('getPlayersByGameID'):
          $gameID = $_GET['gameID'];
          $players = getPlayers($gameID);

          $players_array = array();
          foreach($players as $player)
          {

            array_push($players_array, $player);
          }
          header('Content-type: application/json');
          echo json_encode($players);
          break;

      }
  }

?>
