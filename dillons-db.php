<?php
function enter_user($username, $password, $email){
    global $db;
    $query = "INSERT INTO Users (Username,hashedPassword) VALUES (:username, :pword)";//THis replaced user input with templates. It compiles code first then fills in the strings
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    try{
    $statement = $db->prepare($query);
    $statement->bindValue(":username",$username);
    $statement->bindValue(":pword",$hashed_password);
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