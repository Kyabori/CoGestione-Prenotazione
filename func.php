<?php
$servername = "nome_server"
$username = "nome_utente";
$password = "password";

// Create connection
$db_a = new mysqli($servername, $username, $password, "autogestione");
$db_b = new mysqli($servername, $username, $password, "db_registro");
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, "autogestione");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

function capa() { ?>
    <!DOCTYPE html>
<html lang="it">

<head>
    <link rel="icon" href="../favicon.png" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alternative Week</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <style>
        @media (min-width: 450px) {
            body {
                background-image: url("sfondone.jpg") !important;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        }

        .bgg {
            background-color: rgb(255, 255, 255, 1) !important;
            max-width: 1000px;
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 20px 20px 20px 20px;
            -webkit-box-shadow: 0px 0px 17px 10px rgba(0, 0, 0, 0.1);
            box-shadow: 0px 0px 17px 10px rgba(0, 0, 0, 0.1);
        }

        .fine {
            font-size: 10px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container bgg">
        <div class="w-100 row">
            <div class="col">
                <center>
                <img src="src/img/logo.png" width="300" height="125" />
                </center>
            </div>
        </div>
        <hr />
<?php }

function coda() { ?>
       
       </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"
        type="4152dede892009efcdd55d89-text/javascript"></script>
</body>

</html>
<?php }

function hasToBeLoggedIn($b) {
    if ($_SESSION['loggedin'] == true && $b == false) {
        header("Location: ./menu.php");
        die();
    }

    if ($_SESSION['loggedin'] == false && $b == true) {
        header("Location: ./");
        die();
    }
}

function minRole($r) {
    global $db_a;
    $cf = $_SESSION['alunno']['codfiscale'];
    $role = $db_a->query("SELECT ruolo FROM `au_ruolispec` WHERE codfisc = '$cf'")->fetch_array()[0];
    if($role == null) {
        $role = 0;
    }

    if ($role < $r) {
        header("Location: ./");
        die();
    }

    return $role;
}

function pulsanteMenu($testo, $link, $colore = "primary") {
    ?>
        <button type="button" onclick="window.location.href = '<?php echo $link ?>'" class="btn btn-<?php echo $colore ?>" style="margin-bottom: 8px; width: 100%;">
        <?php echo strtoupper($testo) ?></button><br>
    <?php
}

function separatore() {
    echo "<hr />";
}
