<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "heroes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createHero($name, $about_me, $biography)
{
    $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function addAbility($ability)
{
    $sql = "INSERT INTO ability_type (ability) VALUES ('$ability')";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function readAllHeroes()
{
    $sql = "SELECT * FROM heroes";
    global $conn;
    $result = $conn->query($sql);
    global $conn;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<br> id: " . $row["id"] . " - Hero: " . $row["name"] . " - About Me: " . $row["about_me"] . " - Biography: " . $row["biography"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}

function getAbility()
{
    $sql = "SELECT ability FROM ability_type";
    global $conn;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
    } else {
        echo $conn->errors;
    }
}

function updateHero($id, $name, $about_me, $biography)
{
    $sql = "UPDATE heroes SET name='$name', about_me='$about_me', biography='$biography' WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function updateAbility($ability, $id)
{
    $sql = "UPDATE ability_type SET ability='$ability' WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function deleteHero($id)
{
    $sql = "DELETE FROM heroes WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function deleteAbility($id)
{
    $sql = "DELETE FROM ability_type WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function getAll()
{
    $sql = "SELECT 
    heroes.name, 
    heroes.about_me, 
    GROUP_CONCAT(ability_type.ability separator ', ') ability_type
    FROM ((heroes
    INNER JOIN abilities on heroes.id = abilities.hero_id)
    INNER JOIN ability_type ON abilities.ability_id = ability_type.id)
    GROUP BY heroes.name, heroes.about_me";
    global $conn;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
    } else {
        echo $conn->errors;
    }
}

$route = $_GET["route"];

if ($route != "") {
    switch ($route) {
        case "create":
            createHero($_POST["name"], $_POST["about_me"], $_POST["biography"], $conn);
            break;
        case "getability":
            getAbility($conn);
            break;
        case "addability":
            addAbility($_POST["ability"], $conn);
            break;
        case "updateAbility":
            updateAbility($_POST["ability"], $_POST['id'], $conn);
            break;
        case "deleteAbility":
            deleteAbility($_GET['id'], $conn);
            break;
        case "all":
            getAll($_GET["id"], $conn);
            break;
        case "read":
            readAllHeroes($conn);
            break;
        case "update":
            updateHero($_POST["id"], $_POST["name"], $_POST["about_me"], $_POST["biography"], $conn);
            break;
        case "delete":
            deleteHero($_GET["id"], $conn);
            break;
        default:
            echo 'Error 404';
    }
}

$conn->close();
