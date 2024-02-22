<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

pulsanteMenu("Aggiungi Utente Speciale", "aggiungi_utenza_speciale.php", "success");
pulsanteMenu("Lista Utente Speciale", "lista_utenze_speciale.php", "primary");
pulsanteMenu("Rimuovi Utente Speciale", "rimuovi_utenza_speciale.php", "danger");
separatore();
pulsanteMenu("Home", "menu.php", "primary");
coda();