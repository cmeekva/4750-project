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
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Post"){
        make_comment($_COOKIE['user'],$_POST['comment'], $_GET['PostId']);
    }
}

//   if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['PostTitle']) > 0 && strlen($_POST['PostTextContent']) > 0)
// {
//     $PostTitle = trim($_POST['PostTitle']);
//     $PostTextContent = trim($_POST['PostTextContent']);
//     create_blog_post($PostTitle, $PostTextContent, $_COOKIE['user'], $_GET['BlogID']);
//     header('Location: home.php');
// }

$post = get_single_post($_GET['PostId']);

$picture = get_post_picture($_GET['PostId']);
//$picture = $picture[0];

## I added this line
$comment_list = get_comments($_GET['PostId']);

// <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($picture['image']).'"/>'; 


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
  <h1><?php echo $post[2] ?></h1>
  <?php echo '<div class="caption"><h3><img src="data:image/jpeg;base64,'.base64_encode($picture).'"/>'; ?>
  <?php echo $post[5] ?>

  
  <br>
    Upvotes: <?php echo $post[4] ?>
  <br>
  <form name="mainForm" action="post.php?PostId=<?php echo $post[0] ?>" method="post"> 
  <input type = "text" name="comment" placeholder="Type your comment here!" class="col-sm-11">
    <input type="submit" value="Post" name="btnAction" class="btn btn-dark" />
</form> 
  </div>


<div class="container">

<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
<thead>
    <tr style="background-color:#B0B0B0">
        <th width="40%">Comments</th>        
    </tr>
  </thead>
  <?php foreach ($comment_list as $var): ?>
       <tr>
       <td><?php echo $var['CommentTextContent']; ?></td>                             
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
?? 2022 Copyright: Colin Meek, Dillon Nelson, Brendan Bennet, and Liam Tracey
</div>

</footer>
</html>