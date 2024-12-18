<?php
session_start();
?>
<html>
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
</body>
</html>
<?php
$_SESSION['valid'] = false;
unset($_SESSION['username']);
unset($_SESSION['password']);

echo 'Logging out...';
header('Refresh: 1; URL=Subnautica.php');
?>

