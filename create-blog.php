<?php
require("connect-db.php");
require("dillons-db.php");  

if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['blogTitle']) > 0 && strlen($_POST['blogDescription']) > 0)
{
    $blogTitle = trim($_POST['blogTitle']);
    $blogDescription = trim($_POST['blogDescription']);
    create_blog($blogTitle, $blogDescription);
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
    <h1>Create A New Blog</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Title: <input type="text" name="blogTitle" class="form-control" autofocus required /> <br/>
      Description: <input type="test" name="blogDescription" class="form-control" required /> <br/>
      <input type="submit" value="Create!" class="btn btn-light"  />   
    </form>
  </div>

<?php

?>


</body>
</html>


