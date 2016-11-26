<?php //Assumes that $game has been defined
$court = getCourtByID($game["CourtID"]); ?>
<a class="game" href="game.php?gameID=<?php echo $game['ID']; ?>">
  <div>
    <h2 class="game-title">
      <?php echo $game['Name']; ?>
    </h2>
    <h3 class="game-title">
      <?php echo $court["Name"]; ?>, <i><?php echo $game['Date']; ?></i>
    </h3>
  </div>
</a>
