<?php
function enter_user($username, $password, $email){
    global $db;
    $query = "INSERT INTO Users (Username,hashedPassword) VALUES (:username, :pword)";//THis replaced user input with templates. It compiles code first then fills in the strings
    $query2 = "SELECT userID FROM Users WHERE Username=:username";
    $query3 = "INSERT INTO email (userID, email) VALUES (:id, :email)";
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
    return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        if($statement->rowCount() == 0)
            echo "Failed to add user to database <br/>";
        
    }
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
        return password_verify($password, $result[0]);
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

?>