<?php
	include 'pattern/Observer.php';
	class Player implements Observer {
		private $id = -1; // same as player id
		private $name;
		private $games = array();
		private $chats = array();
		private $notifications = array();

		// constructor
		public function __construct($_name, $_playerID){
			$name = $_name;
			$id = $_playerID;
		}	

		public function update($subject, $notification){
			$notifications[] = 
			array('subject' => $subject, 'notification' => $notification);
		}

	}

?>

<link rel="stylesheet" href="chat/style.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript" src="js/chatfront.js"></script>
<body onload="setInterval('chat.update()', 1000)">
    <div id="chat">
        <h2><?php echo $title; ?></h2>
        <p id="name-area"></p>
        <div id="chat-wrap"><div id="chat-area"></div></div>
        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>
    </div>
</body>

