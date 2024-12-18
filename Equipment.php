<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="Style.css">
    <title>Subnautica</title>
</head>
    <body class="equipment">
    <video class="background-video" autoplay loop muted>
    <source src="Blood_Kelp.mp4" type="video/mp4">
    </video>
    <nav>
        <div class="heading">
            <h4>Subnautica</h4>
        </div>

    <ul class="nav-links">
        <li><a href="Subnautica.php">Home</a></li>
        <li><a href="Carnivores.php">Carnivores</a></li>
        <li><a href="Herbivores.php">Herbivores</a></li>
        <li><a href="Flora.php">Flora</a></li>
        <li><a class="active" href="Equipment.php">Equipment</a></li>
        <li><a href="Fragments.php">Fragments</a></li>
        <li><a href="Vehicles.php">Vehicles</a></li>
        <li><a href="Biomes.php">Biomes</a></li>
        <li><a href="Login.php">Login</a><li>
    </ul>
    </nav>

<style>
form {
    padding-top:100px;
    border-collapse:collapse;
    }
    div {
        padding-top:10px;
        color:#00FF97;
        text-align: center;
    }
    .submit {
        position:absolute;
        left:50%;
        background-color:darkblue;
        -ms-transform:translateY(-50%,-50%);
        transform:translateY(-50%,-50%);
        color:#00FF97;

    }
</style>

<form action="Equipment.php" method="post">
    <div>Search Type: <input type="text" name="type" placeholder="Ex: Name, Id, etc ..."></div>
    <div>Search: <input type="text" name="search" placeholder="Ex: Rebreather, 2, etc ..."></div>
    <?php
         if ($_SESSION['valid'] == true) {
            echo "<div>Edit: </div>";
            echo "<div>Use Search Type to choose column to change and Edit to input new data. </div>";
            echo "<div>Use Edit Id to choose which row to change.</div>";
            echo "<div>Edit Id: <input type='text' name='edit_id' placeholder='1,2,3,etc...'></div>";
            echo "<div>Edit: <input type='text' name='edit' placeholder='Replacement Data.'></div>";
            echo "<div>Delete:</div>";
            echo "<div>Use Id as an identifier for which row to delete </div>";
            echo "<div>Delete: <input type='text' name='delete' placeholder='1,2,3, etc ...'></div>";
            echo "<div>Add:</div>";
            echo "<div>Use Add boxes to input new data to be added. </div>";
            echo "<div>Add Name: <input type='text' name='add_name' placeholder='New Name.'></div>";
            echo "<div>Add Dangerous: <input type='text' name='add_dangerous' placeholder='New Dangerous Designation.'></div>";
            echo "<div>Add Danger Level: <input type='text' name='add_dang_lvl' placeholder='New Danger Level.'></div>";
            echo "<div>Add Bio: <input type='text' name='add_bio' placeholder='New Bio.'></div>";
        }
    ?>
    <input class="submit" type="submit">
</form>
<?php
    include "pwd.php";
    $servername = "localhost";
    $db_name = "akeehan";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p> Failed. </p>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $type = $_POST['type'];
        $search = $_POST['search'];
        if ($_SESSION['valid'] == true) {
            $edit_id = $_POST['edit_id'];
            $edit = $_POST['edit'];
            $add_name = $_POST['add_name'];
            $add_dangerous = $_POST['add_dangerous'];
            $add_dang_lvl = $_POST['add_dang_lvl'];
            $add_bio = $_POST['add_bio'];
            $delete = $_POST['delete'];
        }

        if (!empty($type)) {
            if ($type == "Id") {
                $type = "Equipment_id";
            }else if ($type == "Name") {
                $type = "Equipment_Name";
            }else if ($type == "Type") {
                $type = "Type_id";
            }else if ($type == "Dangerous") {
                $type = "Equipment_Dangerous";
            }else if ($type == "Danger Level") {
                $type = "Equipment_Dang_Lvl";
            }else if ($type == "Bio") {
                $type = "Equipment_Bio";
            }else {
                echo "Not an acceptable Type";
                header("Refresh:0");
            }
            if (!empty($search) || $search == 0) {
                if ($type == "Equipment_id" || $type == "Type_id" || $type == "Equipment_Dangerous" || $type == "Equipment_Dang_Lvl") {
                    $sql = "Select Equipment_id, Type_Name, Equipment_Name, Equipment_Dangerous, Equipment_Dang_Lvl, Equipment_Bio from Equipment natural join Types where Type_id=6 and " . $type . " = $search order by Equipment_id";
                }else if ($type == "Equipment_Name" || $type ==  "Equipment_Bio") {
                    $sql = "Select Equipment_id, Type_Name, Equipment_Name, Equipment_Dangerous, Equipment_Dang_Lvl, Equipment_Bio from Equipment natural join Types where Type_id=6 and " . $type . " like '%$search%' order by Equipment_id";
                }else {
                    header("Refresh:1");
                }
                $result = $connection->query($sql);
                $num_results = mysqli_num_rows($result);

                if ($num_results == 0) {
                    header('Refresh:1;URL=Equipment.php');
                }
            }
            else if (!empty($edit)) {
                if ($type == "Equipment_Name" || $type == "Equipment_Bio") {
                    $sql = "update Equipment set $type = '$edit' where Equipment_id =" . $edit_id;
                }
                else if ($type == "Equipment_id" || $type == "Type_id" || $type == "Equipment_Dangerous" || $type == "Equipment_Dang_Lvl") {
                    $sql = "update Equipment set $type=" . $edit . " where Equipment_id=" . $edit_id;
                }
                $result = $connection->query($sql);
                echo "Information Successfully Updated.";
                header('Refresh:1;URL=Equipment.php');
            }
        }else if (!empty($delete)) {
                $sql = "delete from Equipment where Equipment_id ='$delete'";
                $result = $connection->query($sql);
                echo "Information successfully deleted.";
                header('Refresh:1;URL=Equipment.php');
        }else if (!empty($add_name)) {
                $sql = "insert into Equipment(Equipment_Name, Type_id, Equipment_Dangerous, Equipment_Dang_Lvl, Equipment_Bio)values('$add_name', 6,$add_dangerous,$add_dang_lvl,'$add_bio')";
                $result = $connection->query($sql);
                echo "Information Successfully Added";
                header('Refresh: 1; URL=Equipment.php');
        }
}
?>

<! Table >
<style>
table {
    width: 100%;
    border-collapse: collapse;
    }
    td {
        padding: 10px;
        color:#00FF97;
        text-align: left;
    }
    th {
        padding-top:100px;
        font-weight: bold;
        text-align: center;
        color:#00FF97;
    }
</style>
<?php
        $showAll = isset($_GET['showall']) && $_GET['showall'] == 1;

        if (empty($type) && empty($search) && empty($edit) && empty($add_name) && empty($delete)) {
            $sql = "Select Equipment_id, Type_Name, Equipment_Name, Equipment_Dangerous, Equipment_Dang_Lvl, Equipment_Bio from Equipment natural join Types where Type_id=6 order by Equipment_id";
            $result = $connection->query($sql);
        }

        if ($result->num_rows > 0){
            $rows = [];
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $id_col = "Id";
            $type_col = "Type";
            $name_col = "Name";
            $dang_col = "Dangerous";
            $dang_lvl_col = "Danger Level";
            $bio_col = "Information";
            echo "<table><tr>";
            echo "<th><a" . $id_col . "'>" . $id_col . "</a></th>";
            echo "<th><a" . $type_col . "'>" . $type_col . "</a></th>";
            echo "<th><a" . $name_col . "'>" . $name_col . "</a></th>";
            echo "<th><a" . $dang_col . "'>" . $dang_col . "</a></th>";
            echo "<th><a" . $dang_lvl_col . "'>" . $dang_lvl_col . "</a></th>";
            echo "<th><a" . $bio_col . "'>" . $bio_col . "</a></th>";

            $fieldInfo = $result->fetch_fields();
            echo "<th><a href='?showall=1'a>Show All</a></th>";
            echo "</tr>";

            foreach($rows as $row) {
                echo "<tr>";
                $id = $row['Equipment_id'];
                $type = $row['Type_Name'];
                $name = $row['Equipment_Name'];
                $dangerous = $row['Equipment_Dangerous'];
                $dang_lvl = $row['Equipment_Dang_Lvl'];
                $bio = $row['Equipment_Bio'];
                echo "<td>" . $id . "</td>";
                echo "<td>" . $type . "</td>";
                echo "<td>" . $name . "</td>";
                if ($dangerous == 1) {
                    echo "<td> Dangerous </td>";
                }
                else {
                    echo "<td> Not Dangerous </td>";
                }
                echo "<td>" . $dang_lvl . "</td>";
                echo "<td>" . $bio . "</td>";
                echo "</tr>";
            }
            echo "</tr>";

            echo "</table>";
        } else {
            echo "<br>0 Results Found";
        }
        $connection->close();
?>

