<?php
  session_start();

  include "DatabaseFacade.php";
  $playerID = $_SESSION['playerID'];
  $games = getGamesByPlayerID($playerID);

  $title = "My Games";
  include 'header.php';
?>
  <div class="content">
    <div class="wrap">
      <div class="games">
        <?php foreach($games as $game){
          $court_of_game = getCourtByID($game["CourtID"]); ?>
          <a class="game" href="game.php?gameID=<?php echo $game['ID']; ?>">
            <div>
              <h2 class="game-title">
                <?php echo $game['Name']; ?>
              </h2>
              <h3 class="game-title">
                <?php echo $court_of_game["Name"]; ?>, <i><?php echo $game['Date']; ?></i>
              </h3>
            </div>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

<?php
  include 'footer.php';
