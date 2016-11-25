<?php
  session_start();
  include 'DatabaseFacade.php';
  $loginErr = "";

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $pass = test_input($_POST["pass"]);

    if(empty($name) && empty($pass)){
      $loginErr = "Username and Password Requried";
    } else if(empty($name)){
      $loginErr = "Username Required";
    } else if(empty($pass)){
      $loginErr = "Password Requried";
    } else {
      $loginErr = "";
    }

    if(empty($loginErr)){//No errors
      $player = getPlayerByName($name);

      if(empty($player)){//If username is not taken
        $playerID = addPlayer($name, $pass);
        login($playerID);
      } else if($player['Password'] == $pass){//correct password
        $playerID = $player['ID'];
        login($playerID);
      } else { //incorrect password OR username taken
        $loginErr = "Incorrect Password";
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function login($playerID){
    $_SESSION['playerID'] = $playerID;
    header('Location: map.php');
  }

  $title = "Login";
  include 'head.php';
?>
    <div id="background"></div>
    <div id="login">
      <h1>Pickup Game</h1>
      <form method="post" action="" accept-charset="UTF-8">
        <input type="text" name="name" placeholder="Username" /><br />
        <input type="password" name="pass" placeholder="Password" /><br />
        <input type="submit" value="Login" />
      </form>
      <div class="error">
        <?php if(!empty($loginErr)){ ?>
          <p>
            <?php echo $loginErr ?>
          </p>
        <?php } ?>
      </div>
    </div>
