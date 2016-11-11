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
    echo "<div class= \"game\">
    <h3>Game " . $game['ID'] . "</h3>"
    . "<p>" . $game['Date'] . "</p>
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
  include 'footer.php';
?>
