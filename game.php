<?php


	session_start();
	//include 'pattern/Observer.php';
	include 'DatabaseAdapter.php';

	// Set in gameID
	//$gameID = $_SESSION['gameID'];
	$gameviewID = 2;
	$gameview = getGameById($gameviewID);
	$courtLabel = "Court  | ";
	$dateLabel  = "Date   | ";
	$playerLabel = "Current Player List:";
	$players = getPlayers($gameviewID);
	?>

	<!--Display the Game's court and date, then all the players in that game -->
	<div class="displayGame">
		  <h1 class="game-title"><a><?php echo $gameview["Name"]; ?></a></h2><br />
			<?php $court = getCourtByID($gameview["CourtID"]); ?>
			<h2 class="court"><a><?php echo$courtLabel;echo$court["Name"];?></a>
			<h2 class="date"><a><?php echo$dateLabel;echo$gameview["Date"];?></a>
			<h2 class="players"><a><?php echo$playerLabel;?></a>
				<?php foreach($players as $player){ ?>
					<h3 class="player"><a><?php echo $player["Name"];?></a>
				<?php } ?>
			</h2><br />			</h2><br />

	</div>

	<?php include 'chat.php'

/*
	class Game implements Subject {
		private $id = -1; // uninitialized
		private $name;

		private $court;
		private $time;
		private $players = array();

		// constructor
		public function __construct($_name, $_court, $_time){
			$name = $_name;
			$court = $_court;
			$time = $_time;
		}
		public function register(Observer player) {
			$players[$player->id] = $player;
		}

		public function unregister(Observer player) {
			unset($players[$player->id];
		}

		public function notify(){
			foreach($players as $player){
				$player->update();
			}
		}

	} */ ?>
