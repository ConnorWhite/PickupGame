<?php
  session_start();

  include "DatabaseAdapter.php";
  $games = getGamesByPlayerID($_SESSION['playerID']);

  $title = "My Games";
  include 'header.php';
?>
<div class="wrap">
  <div class="games"> <!-- TODO: make game title a link to game.php. Pass game ID as a session variable. -->
    <?php foreach($games as $game){ ?>
      <h2 class="game-title"><a><?php echo $game["Name"]; ?></a></h2><br />
      <?php $court = getCourtByID($game["CourtID"]); ?>
      <h3 class="date"><a><?php echo $court["Name"] ?></a>, <?php $game["Date"]; ?></h3><br /><!-- TODO: make court a link to court.php. Pass court ID as a session variable. -->
    <?php } ?>
  </div>
</div>
