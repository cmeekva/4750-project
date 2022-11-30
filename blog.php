<?php
require("connect-db.php");
require("dillons-db.php");  
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
if (isset($_COOKIE['user']))
{ 
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['Like'])){
      like($_POST['postId']);
    }
  }

//   if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['PostTitle']) > 0 && strlen($_POST['PostTextContent']) > 0)
// {
//     $PostTitle = trim($_POST['PostTitle']);
//     $PostTextContent = trim($_POST['PostTextContent']);
//     create_blog_post($PostTitle, $PostTextContent, $_COOKIE['user'], $_GET['BlogID']);
//     header('Location: home.php');
// }

$post_list = get_posts($_GET['BlogID']);

?>  
<html>
    <head>
        <title>"Blog Site"</title>
    </head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a href="home.php" class="navbar-brand">UVA Blog Website</a>
          </div>
          <div style="float:right">    
      <form action="logout.php" method="get">
        <input type="submit" value="Log out" class="btn btn-dark" />
      </form>
    </div>
    </nav>

  
  <div class="container">
  <h1>Posts for <?php echo $_GET['BlogTitle'] ?></h1>
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
    <tr style="background-color:#B0B0B0">
        <th width="30%">Post Title</th>        
        <th width="30%">Caption</th>
        <th width="30%">Time Posted</th>
        <th width="30%">Upvotes</th> 
        <th width="30%">Upvote</th>   

    </tr>
    </thead>
    <?php foreach ($post_list as $var): ?>
       
     <tr>
     
     <td><a href="post.php?PostId=<?php echo $var['PostID']?>"><?php echo $var['PostTitle']; ?></a></td>
     <td><?php echo $var['PostTextContent']; ?></td> 
     <td><?php echo $var['PostTimePosted']; ?></td>
     <td><?php echo $var['PostViews']; ?></td> 
     <td><form action="blog.php?BlogID=<?php echo $_GET['BlogID'] ?>&BlogTitle=<?php echo $_GET['BlogTitle'] ?>" method="post">
        <input type="submit" name="Like" value="Upvote" class="btn btn-dark" />
        <input type="hidden" name="postId" value="<?php echo $var['PostID']?>" />
      </form></td>                                     
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