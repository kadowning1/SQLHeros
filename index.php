<?php

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


// create
function createHero($name, $about_me, $biography, $conn)
{
    $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// read
function readAllHeroes($conn)
{
    $sql = "SELECT * FROM heroes";
    $result = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

//update
function updateHero($id, $name, $about_me, $biography, $conn)
{
    $sql = "UPDATE heroes SET name='$name', about_me='$about_me', biography='$biography' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

//delete
function deleteHero($id, $conn)
{
    // sql to delete a record
    $sql = "DELETE FROM heroes WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function getAll($conn)
{

    $sql = "SELECT * FROM heroes"; //inner join

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$route = $_GET["route"];

if ($route != "") {
    switch ($route) {
        case "create":
            createHero($_POST["name"], $_POST["about_me"], $_POST["biography"], $conn);
            break;
        case "all":
            getAll($_GET["id"], $conn);
            break;
        case "read":
            // readAllHeroes($_GET["id"], $conn);
            break;
        case "update":
            updateHero($_GET["id"], $_GET["name"], $_GET["about_me"], $_GET["biography"], $conn);
            break;
        case "delete":
            deleteHero($_GET["id"], $conn);
            break;
        default:
            echo 'Error 404';
    }
    // readAllHeroes($conn);
}

$conn->close();
