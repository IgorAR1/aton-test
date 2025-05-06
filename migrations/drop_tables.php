<?php
try{
    $pdo = new PDO("mysql:host=mysql-aton;port=3306;dbname=aton", "root", "admin");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Attempt create table query execution
try{
    $sql = "DROP TABLE IF EXISTS `users`,`countries`,`cities`";

    $pdo->exec($sql);
    echo "Table droped successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

unset($pdo);
?>