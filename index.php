<?php
session_start();

$route = $_GET["route"];

if($route != ""){
    switch ($route) {
        case "create":
            createHero($_GET["name"], $_GET["tagline"]);
            break;
        case "read":
            readAllHeroes($_GET["id"]);
            break;
        case "update":
            updateHero($_GET["id"], $_GET["name"], $_GET["tagline"]);
            break;
        case "delete":
            deleteHero($_GET["id"]);
            break;
        default:
            
        }
    
}
// readAllHeroes();

// create
function createHero ($name, $tagline){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "heroes_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO heroes (nickname, tagline)
    VALUES ('$name', '$tagline')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// read
function readAllHeroes (){
    // output heroes from the array
   

}

function updateHero($id, $name, $tagline){
    //
    //array_splice($_SESSION["heroes"],$index,1,[[$name, $tagline]]);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "heroes_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE heroes SET tagline='$tagline', nickname='$name' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . $conn->error;
    }
    $conn->close();

}

function deleteHero($id){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "heroes_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // sql to delete a record
    $sql = "DELETE FROM heroes WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    } else {
    echo "Error deleting record: " . $conn->error;
    }
}
    function getAllHeroes(){    

}

?>