<?php
	session_start();
	include 'DatabaseFacade.php';

	$gameID = $_GET['gameID'];
	$game = getGameById($gameID);
	$players = getPlayers($gameID);

	$title = $game["Name"];
	include 'header.php';
	?>

	<!--Display the Game's court and date, then all the players in that game -->
	<div id="content">
		<div class="wrap">
				<?php $court = getCourtByID($game["CourtID"]);?>
				<h2 class="court">Court: <a href="court.php?courtID=<?php echo $court["ID"]; ?>"><?php echo $court["Name"]; ?></a>
				<h2 class="date">Time: <i><?php echo $game["Date"];?></i></h2>
				<h2 class="players">Current Players:</h2>
					<p>
						<?php foreach($players as $player){
							echo $player["Name"];
							if($player !== end($players))
								echo ", ";
						} ?>
					</p>
				<?php if (!in_array(getPlayerById($_SESSION['playerID']), getPlayers($game['ID']))) { ?>
					<form id="join" method="post" action="joingame.php?gameID=<?php echo $gameID; ?>">
	          <input type="hidden" name="gameID" value="gameID" />
	          <input type="submit" name="joingame" value="Join Game"/>
					</form>
	      <?php } else {
					include 'chat.php';
				} ?>
		</div>
	</div>

	<?php
		include 'footer.php';
