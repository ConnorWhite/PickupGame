<?php
  include 'DatabaseFacade.php';
  session_start();
  $_SESSION['playerID'] = 2;
  $_SESSION['CourtID'] = 1;
  $court = getCourtByID($_SESSION["CourtID"]);
  $title =  "Games for " . $court['Name'];
  
  $games = getGamesByCourtID($_SESSION["CourtID"]);
  
  //var_dump($games);
  include 'header.php';

  foreach ($games as $game) {

    $numPlayers = count(getPlayers($game['ID']));
    echo "<div class= \"game\">
    <h3><a href=\"game.php?id=" . $game['ID']
    . "\">Game " . $game['ID'] . "</a></h3>"
    . "<p>" . $game['Date'] . "</p>"
    . "<p>" . $numPlayers . " / 10 players</p>
    <form method=\"post\" action=\"\">";

    //check if the numPlayers is less than 10 and make sure currentPlayer is not in game before
    //letting player join

    if ($numPlayers < 10 and !in_array(getPlayerById($_SESSION['playerID']), getPlayers($game['ID']))) { 
        echo "<input type=\"hidden\" name=\"secret\" value=\"" .
            $game['ID'] . "\"/>";
        echo "<input type=\"submit\" name=\"joingame\" value=\"Join Game\"/>";
    }
    echo "</form>
    </div>";
  }
?>
<html>
<body>
<form method="post" action="">
    <input type="submit" name="addgame" value="Add Game"/>
</form>
</body>
</html>
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
