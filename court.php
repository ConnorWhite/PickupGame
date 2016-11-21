<?php
  include 'DatabaseFacade.php';
  session_start();
  //$_SESSION['playerID'] = 2; // set in login.php
  $court = null;
  if(isset($_GET["courtID"]))
  {
      $court = getCourtByID($_GET["courtID"]); // http set in mygames.php
  }
  else
  {
    $court = getCourtByID($_SESSION["CourtID"]); // session set in map.js
  }

  $title =  $court['Name'] . " | Pickup Game";

  $games = getGamesByCourtID($court['ID']);

  //var_dump($games);
  include 'header.php';
  ?>
    <div class="wrap">
  <?php

  foreach ($games as $game) {

    $numPlayers = count(getPlayers($game['ID']));
    echo "<div class= \"game\">
    <h3><a href=\"game.php?gameID=" . $game['ID']
    . "\">Game: " . $game['Name'] . "</a></h3>"
    . "<p>" . $game['Date'] . "</p>"
    . "<p>Players: " . $numPlayers . "</p>
    <form method=\"post\" action=\"\">";

    //check if the numPlayers is less than 10 and make sure currentPlayer is not in game before
    //letting player join

    if (!in_array(getPlayerById($_SESSION['playerID']), getPlayers($game['ID']))) {
        echo "<input type=\"hidden\" name=\"secret\" value=\"" .
            $game['ID'] . "\"/>";
        echo "<input type=\"submit\" name=\"joingame\" value=\"Join Game\"/>";
    }
    echo "</form>
    </div>";
  }
?>
  <form method="post" action="">
      <input type="submit" name="addgame" value="Add New Game"/>
  </form>
</div>
<?php
  if(isset($_POST['addgame'])) {
    header('Location: addcourt.php');
  }
  if(isset($_POST['joingame'])) {
    joinGame($_SESSION['playerID'], $_POST["secret"]);
    header('Location: court.php');
  }
  include 'footer.php';
?>
