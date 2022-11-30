<?php
require("connect-db.php");   
require("dillons-db.php");  
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
if (isset($_COOKIE['user']))
{ 
$blog_list = get_blogs();
?>  
<html>
    <head>
        <title>"Blog Site"</title>
    </head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a href="home.php" class="navbar-brand">UVA Blog Website</a>
          </div>

        <div class="float:center">
          <a href="user-blogs-list.php" class="btn">Your blogs!</a>
        </div>
        <div style="float:right">    
      <form action="logout.php" method="get">
        <input type="submit" value="Log out" class="btn btn-dark" />
      </form>
    </div>    
    
    </nav>
  <div class="container">
    
    <h1>Welcome <font color="green" style="font-style:italic"><?php echo $_COOKIE['user'] ?></font> </h1>
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
    <tr style="background-color:#B0B0B0">
        <th width="30%">Blog Title</th>        
        <th width="30%">Blog Description</th>       
    </tr>
    </thead>
    <?php foreach ($blog_list as $var): ?>

     <tr>
     <td><a href="blog.php?BlogID=<?php echo $var['BlogID'] ?>&BlogTitle=<?php echo $var['blogTitle'] ?>"><?php echo $var['blogTitle']; ?><a></td>
     <td><?php echo $var['blogDescription']; ?></td>                                     
    </tr>
    <?php endforeach; ?>
    </table>
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
</html>