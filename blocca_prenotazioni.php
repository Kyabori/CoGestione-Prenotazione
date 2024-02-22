<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
echo "<h1>Blocca prenotazioni</h1>";
echo "<form action='blocca_prenotazioni.php' method='POST'>";
echo "<input type='submit' class='btn btn-danger blocca' name='blocca' style='margin-bottom: 8px; width: 100%;' value='BLOCCA PRENOTAZIONI'>";
echo "</form>";
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");
coda();
if(isset($_POST['blocca'])) {
    //modifica il valore bloccapren a 1
    $bloccapren = $db_a->query("SELECT bloccapren FROM au_info")->fetch_assoc()['bloccapren'];
    if($bloccapren == 0) {
        $db_a->query("UPDATE au_info SET bloccapren = 1");
    }
    echo "<div class='alert alert-success' role='alert'>Prenotazioni bloccate con successo!</div>";
}
?>