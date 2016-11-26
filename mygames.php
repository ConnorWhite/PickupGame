<?php
  session_start();

  include "DatabaseFacade.php";
  $playerID = $_SESSION['playerID'];
  $games = getGamesByPlayerID($playerID);

  $title = "My Games";
  include 'header.php';
?>
  <div id="content">
    <div class="wrap">
      <div class="games">
        <?php foreach($games as $game){
          include 'gameButton.php';
        } ?>
      </div>
    </div>
  </div>

<?php
  include 'footer.php';
