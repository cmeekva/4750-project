<?php
require("connect-db.php"); 
require("dillons-db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Sign Up"){
    if(enter_user($_POST['username'],$_POST['password'],$_POST['email'],$_POST['fname'],$_POST['lname'])){
        setcookie('user', $_POST['username'], time()+3600);
        header('Location: home.php'); 
    }else{
        echo "Was unable to sign up";
    }
    
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  

  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>Sign Up</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  
  <!-- 
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
       
</head>

<body>
<div class="container">
  <h1>Sign Up</h1>  

<form name="mainForm" action="signup.php" method="post">   
  <div class="row mb-3 mx-3">
    Username:
    <input type="text" class="form-control" name="username" required />            
  </div>  
  <div class="row mb-3 mx-3">
    Password:
    <input type="text" class="form-control" name="password" required />            
  </div> 
  <div class="row mb-3 mx-3">
    Email:
    <input type="text" class="form-control" name="email" required />            
  </div>  
  <div class="row mb-3 mx-3">
    First Name:
    <input type="text" class="form-control" name="fname" required />            
  </div>  
  <div class="row mb-3 mx-3">
    Last Name:
    <input type="text" class="form-control" name="lname" required />            
  </div>   
  <div class="row mb-3 mx-3">    
    <input type="submit" value="Sign Up" name="btnAction" class="btn btn-dark" /> 
    <a href="login.php" class="btn btn-light">Log In</a>         
  </div> 

</form> 

</table>
</div>  
  
</div>    
</body>
</html>