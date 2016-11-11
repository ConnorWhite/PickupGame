<html>
<body>
<form method="post" action="">
    Court Name <br>
    <input type="text" name="txt"/> <br>
    Date <br>
    <input type="date" name="date"/> <br>
    <input type="submit" name="select" value="select"/>
</form>
</body>
</html>
<?php
  include 'DatabaseFacade.php';
  session_start();
  $_SESSION['CourtID'] = 1;
  function display() {
    addGame($_POST["txt"], $_POST["date"], $_SESSION["CourtID"]);
    echo "Added Game <br>";
  }
  if(isset($_POST['select'])) {
    display();
    header('Location: court.php');
  } 
  include 'footer.php';
?>
