<?php
  include 'DatabaseFacade.php';
  session_start();
  function display() {
    addGame($_POST["name"], $_POST["datetime"], $_SESSION["CourtID"]);
    echo "Added Game <br>";
  }
  if(isset($_POST['submit'])) {
    display();
    header('Location: court.php?courtID='.$_SESSION["CourtID"]);
  }

  $title = 'Add Court';
  include 'header.php'
?>
<div class="content">
  <div class="wrap">
    <form id="addGameForm" method="post" action="">
      <p>Court Name</p>
      <input type="text" name="name"/><br>
      <p>Date</p>
      <input type="datetime" name="datetime"/><br>
      <input type="submit" name="submit" value="Submit"/>
    </form>
  </div>
</div>
<?php
  include 'footer.php';
