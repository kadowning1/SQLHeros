<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "heroes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createHero()
{
    $wrong_values = '';
    if (!isset($_POST["name"])) {
        $wrong_values .= 'name';
    }

    if (!isset($_POST["about_me"])) {
        $wrong_values .= 'about_me';
    }

    if (!isset($_POST["biography"])) {
        $wrong_values .= 'biography';
    }
    if (strlen($wrong_values) > 0) {
        echo "422 error, $wrong_values is not set";
        return;
    }
    $name = $_POST["name"];
    $about_me = $_POST["about_me"];
    $biography = $_POST["biography"];

    $sql = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$about_me', '$biography')";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function addAbility()
{
    $wrong_values = '';
    if (!isset($_POST["ability"])) {
        $wrong_values .= 'ability';
    }

    if (strlen($wrong_values) > 0) {
        echo "422 error, $wrong_values is not set";
        return;
    }

    $ability = $_POST["ability"];

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

function updateHero()
{
    $wrong_values = '';

    if (!isset($_POST["id"])) {
        $wrong_values .= 'id';
    }

    if (!isset($_POST["name"])) {
        $wrong_values .= 'name';
    }

    if (!isset($_POST["about_me"])) {
        $wrong_values .= 'about_me';
    }

    if (!isset($_POST["biography"])) {
        $wrong_values .= 'biography';
    }
    if (strlen($wrong_values) > 0) {
        echo "422 error, $wrong_values  is not set";
        return;
    }

    $id = $_POST["id"];
    $name = $_POST["name"];
    $about_me = $_POST["about_me"];
    $biography = $_POST["biography"];

    $sql = "UPDATE heroes SET name='$name', about_me='$about_me', biography='$biography' WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function updateAbility()
{
    $wrong_values = '';

    if (!isset($_POST["id"])) {
        $wrong_values .= 'id';
    }

    if (!isset($_POST["ability"])) {
        $wrong_values .= 'ability';
    }

    if (strlen($wrong_values) > 0) {
        echo "422 error, $wrong_values is not set";
        return;
    }

    $id = $_POST["id"];
    $ability = $_POST["ability"];

    $sql = "UPDATE ability_type SET ability='$ability' WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function deleteHero()
{
    $id = $_POST["id"];
    $sql = "DELETE FROM heroes WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function deleteAbility()
{
    $id = $_GET["id"];
    $sql = "DELETE FROM ability_type WHERE id='$id'";
    global $conn;
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function getAllAbilities()
{
    $id = $_GET["id"];
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
            createHero();
            break;
        case "getability":
            getAbility();
            break;
        case "addability":
            addAbility();
            break;
        case "updateAbility":
            updateAbility();
            break;
        case "deleteAbility":
            deleteAbility();
            break;
        case "allAbility":
            getAllAbilities();
            break;
        case "read":
            readAllHeroes();
            break;
        case "update":
            updateHero();
            break;
        case "delete":
            deleteHero();
            break;
        default:
            echo 'Error 404';
    }
}


$conn->close();