<?php
  include 'DatabaseFacade.php';
  session_start();
  if(isset($_POST['submit'])) {
    display();
    header('Location: court.php?courtID='.$_GET["courtID"]);
  }
  function display() {
    addGame($_POST["name"], $_POST["datetime"], $_GET["courtID"]);
    echo "Added Game <br>";
  }

  $title = 'Add Game';
  include 'header.php'
?>
<div class="content">
  <div class="wrap">
    <form id="addGameForm" method="post" action="">
      <p>Game Name</p>
      <input type="text" name="name"/><br>
      <p>Date</p>
      <input type="datetime-local" name="datetime"/><br>
      <input type="submit" name="submit" value="Submit"/>
    </form>
  </div>
</div>
<?php
  include 'footer.php';
