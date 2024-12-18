<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <title>Subnautica</title>
</head>
    <body class="home">
        <video class="background-video" autoplay loop muted>
        <source src="Lost_River_Garg.mp4" type="video/mp4">
        </video>


        <nav>
        <div class="heading">
            <h4 style="float:left">Subnautica</h4>
        </div>

    <ul class="nav-links">
        <li><a class="active" href="Subnautica.php">Home</a></li>
        <li><a href="Carnivores.php">Carnivores</a></li>
        <li><a href="Herbivores.php">Herbivores</a></li>
        <li><a href="Flora.php">Flora</a></li>
        <li><a href="Equipment.php">Equipment</a></li>
        <li><a href="Fragments.php">Fragments</a></li>
        <li><a href="Vehicles.php">Vehicles</a></li>
        <li><a href="Biomes.php">Biomes</a></li>
    </ul>
    </nav>
</html>
 <?php

$user = ['slangvip' => '919792'];

$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

if (! is_null($login) && in_array($login, $user) && $password === $user[$login]) {
    $verified = True;
    echo("NICE");
}
?>

