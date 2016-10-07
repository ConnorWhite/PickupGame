<?php
	include 'pattern/Observer.php';

	class Chat implements Subject {
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

	}
