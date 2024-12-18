<?php
session_start();
?>
<html lang = "en">
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
        <li><a href="Subnautica.php">Home</a></li>
        <li><a href="Carnivores.php">Carnivores</a></li>
        <li><a href="Herbivores.php">Herbivores</a></li>
        <li><a href="Flora.php">Flora</a></li>
        <li><a href="Equipment.php">Equipment</a></li>
        <li><a href="Fragments.php">Fragments</a></li>
        <li><a href="Vehicles.php">Vehicles</a></li>
        <li><a href="Biomes.php">Biomes</a></li>
        <li><a class="active" href="Login.php">Login</a></li>
    </ul>
    </nav>
    <div class="container form-signin">

    <?php
        $msg = '
';

        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            if ($_POST['username'] == 'slangvip' && $_POST['password'] == '9999') {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = 'slangvip';
                echo 'You Have Successfully Logged in';
                header('Refresh:1;URL=Subnautica.php');
            }else {
                $msg = 'Wrong username or password';
            }
        }
    ?>
    </div>
    <div class="container">
    <form class="form-signin" role="form"
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <h4 class="form-signin-heading"><?php echo $msg;?></h4>
    <input type="text" class="form-control" name="username" placeholder="Enter Username" required></br>
    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
    </form>

    Logout<a href="Logout.php" tite="Logout">Logout.

    </div>

</body>
</html>

