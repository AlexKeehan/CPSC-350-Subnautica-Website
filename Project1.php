<?php
    include "pwd.php";
    $servername = "localhost";
    $db_name = "akeehan";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p> Failed. </p>";
        exit();
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Project 1</title>
    <link rel="stylesheet" href="Project1Style.css">

    <?php
    $color = isset($_GET['color']) ? $_GET['color'] : '';
    echo '<style>table { background-color: ' . $color . '; }</style>';

    ?>
  </head>
<body class="home">
    <video class="background-video" autoplay loop muted>
    <source src="Blood_Kelp.mp4" type="video/mp4">
    </video>

    <h1>Subnautica</h1>
    <p class="body">
    <! Get the time >
    <?php
        date_default_timezone_set('America/New_York');
        $time = date('h:i:sa');
        echo $time;
    ?>
    </p>
    <br>
    <br>
    <br>
    <br>
    <p class="body">Subnautica is a first person survival game that has the player crash land on an alien world that is almost completely underwater.
                    The player must find out what caused their ship to crash and why are things hunting the survivors.
                    As can be seen, the graphics and immersion for the player is part of what makes Subnautica so engaging and fun to play.
                    Even though the game was made in 2014, the graphics still stand up to current games graphics.
                    Another thing that is a big part of Subnautica's immersion is the diversity of biomes that can be found in the world.
                    Just to list a few of them: </p>
        <br>
    <h2> Biomes </h2>
       <p class="nested">
       <! Array of list data>
       <?php
            $biomes = array("Blood Kelp Zone", "Bulb Zone", "Crash Zone", "Grand Reef", "Kelp Forest", "Mushroom Treader's Path", "Underwater Islands", "Bone Fields Caves", "Inactive Lava Zone", "Jellyshroom Cave", "Lava Lakes", "Lost River", "Void");
        printBiomes($biomes);

        // Function to print list
        function printBiomes($biomes) {
            $length = count($biomes);
            foreach ($biomes as $key) {
                echo "$key <br>";
            }
        }
       ?>
        </p>
        <br>
        <br>
        <br>
        <br>
     <p class="body"> I did want to showcase one of my favorite biomes in the game, which I think really highlights what makes this game so fun to play.
     </p>
        <img src="LostRiver.jpg"
             alt="Dino"/>
     <p class="body"> As well as the numerous biomes,
                      there is also numerous fauna and flora that make the player feel like they are a part of a bigger ecosystem,
                      which only increases the immersion for the player.
                      To name a few interesting creatures in the game.</p>
      <h3> Fauna </h3>
      <! Table >
      <style>
           table {
                width: 100%;
                border-collapse: collapse;
           }
           td {
                border: 1px solid black;
                padding: 10px;
                color: #00BFFF;;
                text-align: left;
           }
           th {
                font-weight: bold;
                text-align: center;
                color: darkblue;
                cursor: pointer;
           }
     </style>

        <! Sort table>
        <?php
        $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : '';

        $showAll = isset($_GET['showall']) && $_GET['showall'] == 1;

        $sql = "Select * from Fauna";
        $result = $connection->query($sql);


        if ($result->num_rows > 0){
            $rows = [];
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            echo "<table><tr>";

            $fieldInfo = $result->fetch_fields();
            foreach ($fieldInfo as $field) {
                echo "<th><a href='?sort=" . $field->name . "&color=" . $color . "'>" . $field->name . "</a></th>";
            }
            echo "<th><a href='?showall=1&color=" . $color . "'>Show All</a></th>";
            echo "</tr>";

            foreach ($rows as $row) {
                if ($showAll || $sortColumn === '') {
                    echo "<tr>";
                    foreach ($fieldInfo as $field) {
                        echo "<td>" . $row[$field->name] . "</td>";
                    }
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    foreach ($fieldInfo as $field) {
                        if ($field->name === $sortColumn) {
                            echo "<td>" . $row[$field->name] . "</td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "0 Results Found";
        }

        $connection->close();
        ?>

     <p class="body"> Another thing that Subnautica does so well is gently guiding the player down the storyline.
                      Exploration is encouraged if not required for progression and the pace of the story encourages
                      the player to go out of their way to explore new biomes or creatures they discover.
                      All of the facets of the game encourage the player to explore deeper into the alien world they find themselves on and discover all the mysteries hiding within.
                      I have only briefly covered Subnautica and more detailed information can be found here
                      <a href="https://subnautica.fandom.com/wiki/Subnautica_Wiki">Subnautica website</a>. </p>
</body>
</html>

