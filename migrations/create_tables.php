<?php
try{
    $pdo = new PDO("mysql:host=mysql-aton;port=3306;dbname=aton", "root", "admin");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

try{
    $sql = "
        CREATE TABLE countries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            country VARCHAR(100) NOT NULL
        );
        CREATE TABLE cities (
            id INT AUTO_INCREMENT PRIMARY KEY,
            city VARCHAR(100) NOT NULL,
            country_id INT NOT NULL,
            FOREIGN KEY (country_id) REFERENCES countries(id)
        );
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            city_id INT NOT NULL,
            FOREIGN KEY (city_id) REFERENCES cities(id)
        );
";

    $pdo->exec($sql);
    echo "Table created successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

unset($pdo);
?>