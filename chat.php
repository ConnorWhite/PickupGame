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


?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript" src="js/chatfront.js"></script>
<body onload="setInterval('chat.update()', 1000)">
    <div id="chat">
        <h2>Chat</h2>
        <p id="name-area"></p>
        <div id="chat-wrap"><div id="chat-area"></div></div>
        <form id="send-message-area">
						<input type="submit" value="Send"/>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>
    </div>
</body>
