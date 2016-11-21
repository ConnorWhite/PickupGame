<?php
  session_start();

  include "DatabaseFacade.php";
  $playerID = $_SESSION['playerID'];
  //$playerID = 1;
  $games = getGamesByPlayerID($playerID);

  $title = "My Games | Pickup Game";
  include 'header.php';
?>
  <div class="content">
    <div class="wrap">
      <div class="games">
        <?php foreach($games as $game){
          $court_of_game = getCourtByID($game["CourtID"]);
          echo "<div class= \"game\">
          <h2 class =\"game-title\"><a href=\"game.php?gameID=" . $game['ID']
          . "\">". $game['Name'] . "</a></h2>"
          . "<h3 class =\"game-title\"><a href=\"court.php?courtID=" . $court_of_game['ID']
          . "\">". $court_of_game["Name"] . ", " . $game['Date'] . "</a></h3>"
          . "<form method=\"post\" action=\"\"></div>";
         } ?>
      </div>
    </div>
  </div>

<?php
  include 'footer.php';
?>
