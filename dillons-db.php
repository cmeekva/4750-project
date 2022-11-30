<?php
function enter_user($username, $password, $email, $fname, $lname){
    global $db;
    $query = "INSERT INTO Users (Username,hashedPassword) VALUES (:username, :pword)";//THis replaced user input with templates. It compiles code first then fills in the strings
    $query2 = "SELECT userID FROM Users WHERE Username=:username";
    $query3 = "INSERT INTO email (userID, email) VALUES (:id, :email)";
    $query4 = "INSERT INTO Names (userID, Fname, Lname) VALUES (:id, :fname, :lname)";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    try{
    ## inserting username and password into the Users table
    $statement = $db->prepare($query);
    $statement->bindValue(":username",$username);
    $statement->bindValue(":pword",$hashed_password);
    $statement->execute();
    $statement->closeCursor();
    
    ## getting the ID of the user we just inserted
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":username", $username);
    $statement2->execute();
    $result2 = $statement2->fetch();
    $userID = $result2[0];
    $statement2->closeCursor();


    ## Inserting that ID and the email into the email table
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":email",$email);
    $statement3->bindValue(":id",$userID);
    $statement3->execute();
    $statement3->closeCursor();

    ## Inserting names into the names table
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(":id",$userID);
    $statement4->bindValue(":fname",$fname);
    $statement4->bindValue(":lname",$lname);
    $statement4->execute();
    $statement4->closeCursor();
    return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
        
    }
}

function create_blog($blogTitle, $blogDescription, $username){
    global $db;
    $query = "INSERT INTO Blogs (blogTitle,blogDescription) VALUES (:blogTitle, :blogDescription)";
    $query2 = "SELECT BlogID FROM Blogs WHERE blogTitle=:blogTitle AND blogDescription=:blogDescription";
    $query3 = "SELECT userID FROM Users WHERE Username=:username";
    $query4 = "INSERT INTO makesBlog (UserID, BlogID) VALUES (:UserID, :BlogID)";
    try{
    $statement = $db->prepare($query);
    $statement->bindValue(":blogTitle",$blogTitle);
    $statement->bindValue(":blogDescription",$blogDescription);
    $statement->execute();
    $statement->closeCursor();

    ## Getting the BlogID of the blog we just created
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":blogTitle",$blogTitle);
    $statement2->bindValue(":blogDescription",$blogDescription);
    $statement2->execute();
    $result2 = $statement2->fetch();
    $BlogID = $result2[0];
    // return $BlogID;
    $statement2->closeCursor();

    ## getting the ID of the user
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":username", $username);
    $statement3->execute();
    $result3 = $statement3->fetch();
    $userID = $result3[0];
    // return $userID;
    $statement3->closeCursor();


    ## Inserting that ID and the BlogID into makesBlog
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(":BlogID",$BlogID);
    $statement4->bindValue(":UserID",$userID);
    $statement4->execute();
    $statement4->closeCursor();
    
    return true;

    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add blog to database <br/>";
        
    }
}

function create_blog_post($PostTitle, $PostTextContent, $username, $BlogID, $Picture){
    global $db;
    $query0 = "INSERT INTO `PostPicture` VALUES (DEFAULT, :Picture)";
    $query00 = "SELECT PostPictureID FROM PostPicture WHERE Picture=:picture"; 
    $query = "INSERT INTO `Posts` (`BlogID`, `PostTitle`, `PostViews`, `PostTextContent`, `PostPictureID`) VALUES (:blogid, :title , 0, :content, :postpictureID);";
    ## Added for inserting into makesBlog
    $query2 = "SELECT PostID FROM Posts WHERE PostTitle=:title AND PostTextContent=:content";
    $query3 = "SELECT userID FROM Users WHERE Username=:username";
    $query4 = "INSERT INTO makesPost (PostID, UserID) VALUES (:PostID, :UserID)";
    

    try{
    $statement0 = $db->prepare($query0);
    $statement0->bindValue(":Picture",$Picture);
    $statement0->execute();
    $statement0->closeCursor();
    
    $statement00 = $db->prepare($query00);
    $statement00->bindValue(":picture",$Picture);
    $statement00->execute();
    $result00 = $statement00->fetch();
    $PostPictureID = $result00[0];
    $statement00->closeCursor();


    $statement = $db->prepare($query);
    $statement->bindValue(":title",$PostTitle);
    $statement->bindValue(":content",$PostTextContent);
    $statement->bindValue(":blogid",$BlogID);
    $statement->bindValue(":postpictureID",$PostPictureID);
    $statement->execute();
    $statement->closeCursor();

    ## Added this for inserting to makesPost table:
    ## Getting the PostID of the post we just created
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":title",$PostTitle);
    $statement2->bindValue(":content",$PostTextContent);
    $statement2->execute();
    $result2 = $statement2->fetch();
    $PostID = $result2[0];
    $statement2->closeCursor();
   
    ## getting the ID of the user
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":username", $username);
    $statement3->execute();
    $result3 = $statement3->fetch();
    $userID = $result3[0];
    $statement3->closeCursor();
   
    ## Inserting that ID and the PostID into makesPost
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(":PostID",$PostID);
    $statement4->bindValue(":UserID",$userID);
    $statement4->execute();
    $statement4->closeCursor();
    return true;
    }
    catch(PDOException $e){
        return $e->getMessage();
        if($statement->rowCount() == 0)
            return "Failed to add post to database <br/>";
        
    }
}

function get_post_picture($PostID){
    global $db;
    $query = "SELECT Picture FROM PostPicture NATURAL JOIN Posts WHERE PostID = :PostID";
    $statement = $db->prepare($query);
    $statement->bindValue(":PostID",$PostID);
    $statement->execute();
    $result = $statement->fetch();
    
    return $result[0];
}


function login($username, $password){
    global $db;
    $query = "SELECT hashedPassword FROM Users WHERE Username = :username";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        if (!empty($result)){
            return password_verify($password, $result[0]);
        }else{
            return false;
        }
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
            
    }
}

function get_blogs(){
    global $db;
    $query = "SELECT * FROM Blogs";
    try{
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
            
    }
}

function get_blogs_by_user($username){
    global $db;
    $query = "SELECT * FROM Blogs NATURAL JOIN makesBlog NATURAL JOIN Users WHERE Users.Username = :username";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to user specific blogs! <br/>";
    }
              
}

function get_posts($BlogID){
    global $db;
    $query = "SELECT PostID, PostTitle, PostTextContent, PostTimePosted, PostViews FROM `Posts` WHERE BlogID = :bid";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":bid", $BlogID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
            
    }
}

function get_comments($PostID){
    global $db;
    $query = "SELECT * FROM `makesComments` NATURAL JOIN `Comments` WHERE PostID = :pid;";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":pid", $PostID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to get comment from database <br/>";
            
    }
}

function get_single_post($PostID){
    global $db;
    $query = "SELECT * FROM `Posts` WHERE PostID = :pid";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":pid", $PostID);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
            
    }

}
function like($PostId){
    global $db;
    $query = "UPDATE `Posts` SET `PostViews` = `PostViews` + 1 WHERE `Posts`.`PostID` = :postId";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":postId", $PostId);
        $statement->execute();
        $statement->closeCursor();
        return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
            
    }
}

function delete_post($PostId){
    global $db;
    $query = "DELETE FROM Posts WHERE `Posts`.`PostID` = :postId";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(":postId", $PostId);
        $statement->execute();
        $statement->closeCursor();
        return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to delete post from db<br/>";
            
    }
}
function make_comment($username, $comment, $PostID){
    global $db;
    $query = "SELECT userID FROM Users WHERE Username=:username";
    $query2 = "INSERT INTO `Comments` (`UserID`,`CommentTextContent`) VALUES (:id, :comment)";
    # My code:
    $query3 = "SELECT CommentID FROM Comments WHERE CommentTextContent=:comment";
    $query4 = "INSERT INTO `makesComments` (`PostID`, `CommentID`) VALUES (:pid, :cid)";
    try{
        ## get userID
        $statement = $db->prepare($query);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        $userID = $result[0];

        ##insert into comments
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":id", $userID);
        $statement2->bindValue(":comment", $comment);
        $statement2->execute();
        $statement2->closeCursor();

        ## My code
        ## Select comment id
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":comment",$comment);
        $statement3->execute();
        $result3 = $statement3->fetch();
        $statement3->closeCursor();
        $CommentID = $result3[0];

        ## Insert post id
        $statement4 = $db->prepare($query4);
        $statement4->bindValue(":pid", $PostID);
        $statement4->bindValue(":cid", $CommentID);
        $statement4->execute();
        $statement4->closeCursor();

        return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to delete post from db<br/>";
            
    }
}


?>