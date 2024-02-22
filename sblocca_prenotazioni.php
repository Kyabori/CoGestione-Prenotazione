<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
echo "<h1>Blocca prenotazioni</h1>";
echo "<form action='sblocca_prenotazioni.php' method='POST'>";
echo "<input type='submit' class='btn btn-success sblocca' name='sblocca' style='margin-bottom: 8px; width: 100%;' value='SBLOCCA PRENOTAZIONI'>";
echo "</form>";
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");
coda();
if(isset($_POST['sblocca'])) {
    $bloccapren = $db_a->query("SELECT bloccapren FROM au_info")->fetch_assoc()['bloccapren'];
    if($bloccapren == 1) {
        $db_a->query("UPDATE au_info SET bloccapren = 0");
    }
    echo "<div class='alert alert-success' role='alert'>Prenotazioni sbloccate con successo!</div>";
}
?>