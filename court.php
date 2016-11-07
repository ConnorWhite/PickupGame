<?php
  include 'DatabaseFacade.php';
  session_start();
  $_SESSION['CourtID'] = 1;
  $court = getCourtByID($_SESSION["CourtID"]);
  $title =  "Games for " . $court['Name'];
  
  $games = getGamesByCourtID($_SESSION["CourtID"]);
  
  var_dump($games);
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
<form method="post" action="court.php">
    Court Name <br>
    <input type="text" name="txt"/> <br>
    Date <br>
    <input type="date" name="date"/> <br>
    <input type="submit" name="select" value="select" onclick="select()" />
</form>
</body>
</html>
<?php
  function display() {
    addGame($_POST["txt"], $_POST["date"], $_SESSION["CourtID"]);
    echo "Added Game <br>";
  }
  if(isset($_POST['select'])) {
    display();
  } 
  include 'footer.php';
?>
