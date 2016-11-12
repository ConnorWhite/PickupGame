<?php
  include 'DatabaseFacade.php';
  session_start();
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
    <form method=\"post\" action=\"\">
    <!-- <input type=\"submit\" name=\"joingame\" value=\"Join Game\"/> -->
    </form>
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
  }
  include 'footer.php';
?>
