<?php
	include 'pattern/Observer.php';

	class Chat implements Subject {
		private $id = -1; // same as court id
		private $name;
		private $players = array();

		// constructor
		public function __construct($_name, $_courtID){
			$name = $_name;
			$id = $_courtID;
		}		

		public function register(Observer $player) {
			$players[$player->id] = $player;
		}

		public function unregister(Observer $player) {
			unset($players[$player->id]);
		}

		public function notify(){
			foreach($players as $player){
				$player->update();
			}
		}
	}

	include 'head.php';
?>

<div id="page-wrap">
	<h1>Chat</h1>
	<p id="name-area"></p>
	<div id="chat-wrap"><div id="chat-area"></div></div>
	<form id="message-area">
		<p>Your Message: </p>
		<textarea id="message" maxlength="100"></textarea>
	</form>
</div>



