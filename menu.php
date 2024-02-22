<?php 

require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(0);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

//vedi quante persone hanno prenotato vedendo se sono del biennio o triennio
$qp = "SELECT COUNT(*) AS n FROM `au_prenotazioni` WHERE (prenotazione_g01_t01 + prenotazione_g01_t02 + prenotazione_g01_t03 + prenotazione_g01_t04 + prenotazione_g02_t01 + prenotazione_g02_t02 + prenotazione_g02_t03 + prenotazione_g02_t04) > 0;";
$n_prenotazioni = $db_a->query($qp)->fetch_assoc()['n'];

$qs = $db_b->query("SELECT COUNT(*) AS n FROM it_tbl_alunni WHERE idclasse != 0;")->fetch_assoc()["n"];

if($role == 0) {
    $idalunno = $_SESSION['alunno']['idalunno'];
    echo "<h4 class='mb-3 text-center'>Benvenuto, {$_SESSION['alunno']['nome']} {$_SESSION['alunno']['cognome']}</h4>";
    $bloccapren = $db_a->query("SELECT bloccapren FROM au_info")->fetch_assoc()['bloccapren'];
    if($bloccapren == 1) {
        echo "<h4 class='mb-3 text-center'>Le prenotazioni sono bloccate</h4>";
    } else{
        pulsanteMenu("Prenota Corsi", "prenota.php");
    }
    pulsanteMenu("Corsi Prenotati", "prenotati.php", "primary");
} elseif ($role == 1) {
    pulsanteMenu("Gestisci Corsi", "gestisci_corsi.php");
    pulsanteMenu("Stampa report", "report.php");
    pulsanteMenu("Gestisci Prenotazioni", "gestisci_prenotazioni.php");
} elseif ($role == 2) {
    pulsanteMenu("Gestisci Corsi", "gestisci_corsi.php");
    pulsanteMenu("Gestisci Prenotazioni", "gestisci_prenotazioni.php");
    pulsanteMenu("Gestisci Utenti", "gestisci_utenze.php");
    pulsanteMenu("Stampa report", "stampa_report.php");
    echo "<center><p> Hanno prenotato $n_prenotazioni studenti sul totale di $qs<p></center>";
} elseif ($role == 3) {
    echo "<h4 class='mb-3 text-center'>Fai parte della sicurezza, non puoi prenotare.</h4>";
}
separatore();
pulsanteMenu("Esci", "logout.php", "danger");
coda();