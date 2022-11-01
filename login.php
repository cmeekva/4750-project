<?php
require("connect-db.php"); 
require("dillons-db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0)
{
   $username = trim($_POST['username']);
   if (isset($_POST['pwd']))
   {
      $pwd = trim($_POST['pwd']);
      if (login($username, $pwd)){
        echo "you got it";
        setcookie('user', $username, time()+3600);
        header('Location: home.php');
      }else{
        echo "incorrect password";
      }
    }else{
        echo "you did not enter a password";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  
  <title>PHP State Maintenance (Cookies)</title>      
</head>
<body>
  
  <div class="container">
    <h1>Welcome to CS4640 Survey</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Name: <input type="text" name="username" class="form-control" autofocus required /> <br/>
      Password: <input type="text" name="pwd" class="form-control" required /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light"  />   
      <a href="signup.php">sign up</a>
    </form>
  </div>

<?php
// if ($_SERVER['REQUEST_METHOD'] == "POST")
// {	   
//    if (strlen($_POST['username']) > 0)
//    {
//       header('Location: survey-instruction.php');
//    }
// }
?>


</body>
</html>
