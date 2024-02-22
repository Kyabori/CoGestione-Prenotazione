<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
pulsanteMenu("Blocca prenotazioni", "blocca_prenotazioni.php", "danger");
pulsanteMenu("Sblocca prenotazioni", "sblocca_prenotazioni.php", "success");
separatore();
pulsanteMenu("Indietro", "gestisci_prenotazioni.php", "primary");
coda();
?>