<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

$nuclearizza = "
TRUNCATE TABLE au_firstlogin;
TRUNCATE TABLE au_prenotazioni;
UPDATE `au_corsi` SET `n_pren` = 0 WHERE 1;
";

if($_POST['porcodio'] == "sono consapevole di ciò che faccio") {
    mysqli_multi_query($db_a, $nuclearizza);
    session_destroy();
    header("Location: index.php");
}

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

?>
<center>
    <h2 style="color: red;">!! ATTENZIONE !!</h2>
    Stai per eliminare tutto!!!! <br>
    Questo resettera tutti i contatori e cancellerà ogni singola prenotazione. <br>
    Scrivi nel form qua sotto <code>sono consapevole di ciò che faccio</code> per continuare. <br> <br>
    <form action="" method="post" style="border: 3px solid red; padding: 10px 10px 10px 10px;">
        <input type="text" name="porcodio" id="">
        <button type="submit" class="btn btn-danger">Distruggi tutto</button> <br>
    </form>
    <br>
    <?php pulsanteMenu("Ci ho ripensato", "gestisci_prenotazioni.php"); ?>
</center>
<?php

coda();