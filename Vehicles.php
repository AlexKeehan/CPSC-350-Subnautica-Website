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
    <body class="vehicles">
    <video class="background-video" autoplay loop muted>
    <source src="Lost_River_Garg.mp4" type="video/mp4">
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
        <li><a href="Equipment.php">Equipment</a></li>
        <li><a href="Fragments.php">Fragments</a></li>
        <li><a class="active" href="Vehicles.php">Vehicles</a></li>
        <li><a href="Biomes.php">Biomes</a></li>
        <li><a href="Login.php">Login</a></li>
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

<form action="Vehicles.php" method="post">
    <div>Search Type: <input type="text" name="type" placeholder="Ex: Name, Id, etc ..."></div>
    <div>Search: <input type="text" name="search" placeholder="Ex: Seamoth, 2, etc ..."></div>
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
            echo "<div>Add Biome: <input type='text' name='add_biome' placeholder='New Biome, ex 1,2,3.'></div>";
            echo "<div>Add Difficulty To Get: <input type='text' name='add_diff_get' placeholder='New Difficulty.'></div>";
            echo "<div>Add Usefulness: <input type='text' name='add_use' placeholder='New Usefulness.'></div>";
            echo "<div>Add Max Depth: <input type='text' name='add_depth' placeholder='New Max Depth.'></div>";
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
            $add_biome = $_POST['add_biome'];
            $add_diff = $_POST['add_diff_get'];
            $add_use = $_POST['add_use'];
            $add_depth = $_POST['add_depth'];
            $add_bio = $_POST['add_bio'];
            $delete = $_POST['delete'];
        }

        if (!empty($type)) {
            if ($type == "Id") {
                $type = "Vehicle_id";
            }else if ($type == "Name") {
                $type = "Vehicle_Name";
            }else if ($type == "Biome") {
                $type = "Biome";
            }else if ($type == "Type") {
                $type = "Type_id";
            }else if ($type == "Difficulty") {
                $type = "Vehicle_Diff_Get";
            }else if ($type == "Usefulness") {
                $type = "Vehicle_Usefulness";
            }else if ($type == "Max Depth") {
                $type = "Vehicle_Max_Depth";
            }else if ($type == "Bio") {
                $type = "Vehicle_Bio";
            }else {
                echo "Not an acceptable Type";
                header("Refresh:0");
            }
            if (!empty($search) || $search == 0) {
                if ($type == "Biome") {
                    $sql = "select Vehicle_id, Type_Name, Vehicle_Name, Biome_Name, Vehicle_Diff_Get, Vehicle_Usefulness, Vehicle_Max_Depth, Vehicle_Bio from Vehicles natural join Types natural join Biomes_Vehicles natural join Biomes where Type_id=8 and Biome_id='$search' order by Vehicle_id";
                }else if ($type == "Vehicle_id" || $type == "Type_id" || $type == "Vehicle_Diff_Get" || $type == "Vehicle_Usefulness" || $type == "Vehicle_Max_Depth") {
                    $sql = "Select Vehicle_id, Type_Name, Vehicle_Name, Biome_Name, Vehicle_Diff_Get, Vehicle_Usefulness, Vehicle_Max_Depth, Vehicle_Bio from Vehicles natural join Types natural join Biomes_Vehicles natural join Biomes where Type_id=8 and " . $type . " = $search order by Vehicle_id";
                }else if ($type == "Vehicle_Name" || $type ==  "Vehicle_Bio") {
                    $sql = "Select Vehicle_id, Type_Name, Vehicle_Name, Biome_Name, Vehicle_Diff_Get, Vehicle_Usefulness, Vehicle_Max_Depth, Vehicle_Bio from Vehicles natural join Types natural join Biomes_Vehicles natural join Biomes where Type_id=8 and " . $type . " like '%$search%' order by Vehicle_id";
                }else {
                    header("Refresh:1");
                }
                $result = $connection->query($sql);
                $num_results = mysqli_num_rows($result);

                if ($num_results == 0) {
                    header('Refresh:1;URL=Vehicles.php');
                }
            }
            else if (!empty($edit)) {
                if ($type == "Biome") {
                    $sql = "update Biomes_Vehicles set Biome_id = $edit where Vehicle_id =" . $edit_id;
                }
                else if ($type == "Vehicle_Name" || $type == "Vehicle_Bio") {
                    $sql = "update Vehicles set $type = '$edit' where Vehicle_id =" . $edit_id;
                }
                else if ($type == "Vehicle_id" || $type == "Type_id" || $type == "Vehicle_Diff_Get" || $type == "Vehicle_Usefulness" || $type == "Vehicle_Max_Depth") {
                    $sql = "update Vehicles set $type=" . $edit . " where Vehicle_id=" . $edit_id;
                }
                $result = $connection->query($sql);
                echo "Information Successfully Updated.";
                header('Refresh:1;URL=Vehicles.php');
            }
        }else if (!empty($delete)) {
                $del_junc = "delete from Biomes_Vehicles where Vehicle_id = '$delete'";
                $throwaway = $connection->query($del_junc);
                $sql = "delete from Vehicles where Vehicle_id ='$delete'";
                $result = $connection->query($sql);
                echo "Information successfully deleted.";
                header('Refresh:1;URL=Vehicles.php');
        }else if (!empty($add_name)) {
                $sql = "insert into Vehicles(Vehicle_Name, Type_id, Vehicle_Diff_Get, Vehicle_Usefulness, Vehicle_Max_Depth, Vehicle_Bio)values('$add_name', 8,$add_diff,$add_use,'$add_depth','$add_bio')";
                $result = $connection->query($sql);
                $last_id = mysqli_insert_id($connection);
                $sql2 = "insert into Biomes_Vehicles(Biome_id, Vehicle_id)values($add_biome, $last_id)";
                $throwaway = $connection->query($sql2);
                echo "Information Successfully Added";
                header('Refresh: 1; URL=Vehicles.php');
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
            $sql = "Select Vehicle_id, Type_Name, Vehicle_Name, Biome_Name, Vehicle_Diff_Get, Vehicle_Usefulness, Vehicle_Max_Depth, Vehicle_Bio from Vehicles natural join Biomes_Vehicles natural join Biomes natural join Types where Type_id=8 order by Vehicle_id";
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
            $biome_col = "Biome";
            $diff_col = "Difficulty To Get";
            $use_col = "Usefulness";
            $depth_col = "Max Depth";
            $bio_col = "Information";
            echo "<table><tr>";
            echo "<th><a" . $id_col . "'>" . $id_col . "</a></th>";
            echo "<th><a" . $type_col . "'>" . $type_col . "</a></th>";
            echo "<th><a" . $name_col . "'>" . $name_col . "</a></th>";
            echo "<th><a" . $biome_col . "'>" . $biome_col . "</a></th>";
            echo "<th><a" . $diff_col . "'>" . $diff_col . "</a></th>";
            echo "<th><a" . $use_col . "'>" . $use_col . "</a></th>";
            echo "<th><a" . $depth_col . "'>" . $depth_col . "</a></th>";
            echo "<th><a" . $bio_col . "'>" . $bio_col . "</a></th>";

            $fieldInfo = $result->fetch_fields();
            echo "<th><a href='?showall=1'a>Show All</a></th>";
            echo "</tr>";

            foreach($rows as $row) {
                echo "<tr>";
                $id = $row['Vehicle_id'];
                $type = $row['Type_Name'];
                $name = $row['Vehicle_Name'];
                $biome = $row['Biome_Name'];
                $diff = $row['Vehicle_Diff_Get'];
                $use = $row['Vehicle_Usefulness'];
                $depth = $row['Vehicle_Max_Depth'];
                $bio = $row['Vehicle_Bio'];
                echo "<td>" . $id . "</td>";
                echo "<td>" . $type . "</td>";
                echo "<td>" . $name . "</td>";
                echo "<td>" . $biome . "</td>";
                echo "<td>" . $diff . "</td>";
                echo "<td>" . $use . "</td>";
                echo "<td>" . $depth . "</td>";
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

