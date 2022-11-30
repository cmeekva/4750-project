<?php
require("connect-db.php");
require("dillons-db.php");  

if (isset($_COOKIE['user']))
{

if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['PostTitle']) > 0 && strlen($_POST['PostTextContent']) > 0)
{
    $PostTitle = trim($_POST['PostTitle']);
    $PostTextContent = trim($_POST['PostTextContent']);
    create_blog_post($PostTitle, $PostTextContent, $_COOKIE['user'], $_GET['BlogID']);
    header('Location: home.php');
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
    <h1>Create A New Post</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Title: <input type="text" name="PostTitle" class="form-control" autofocus required /> <br/>
      Post Body: <input type="test" name="PostTextContent" class="form-control" required /> <br/>      
      <input type="submit" value="Create!" class="btn btn-light"  />   
    </form>
  </div>

<?php

}
else 
   header('Location: login.php');   // force login
?>

<footer class="text-center text-lg-start bg-light text-muted">

<div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
© 2022 Copyright: Colin Meek, Dillon Nelson, Brendan Bennet, and Liam Tracey
</div>
</footer>

</body>
</html>