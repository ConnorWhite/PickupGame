<?php
  include 'DatabaseFacade.php';
  session_start();
?>
<html>
  <body>
    <form method="post" action="">
      Court Name<br>
      <input type="text" name="txt"/><br>
      Date<br>
      <input type="date" name="date"/><br>
      <input type="submit" name="submit" value="Submit"/>
    </form>
  </body>
</html>
<?php
  function display() {
    addGame($_POST["txt"], $_POST["date"], $_SESSION["CourtID"]);
    echo "Added Game <br>";
  }
  if(isset($_POST['submit'])) {
    display();
    header('Location: court.php');
  }
  include 'footer.php';
?>
