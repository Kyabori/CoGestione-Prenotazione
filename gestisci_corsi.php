<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

pulsanteMenu("Aggiungi Corso", "aggiungi_corso.php", "success");
pulsanteMenu("Aggiungi classe a corso", "aggiungi_classe_corso.php", "success");
pulsanteMenu("Lista Corsi", "lista_corsi.php", "primary");
separatore();
pulsanteMenu("Rimuovi Corso", "rimuovi_corso.php", "danger");
separatore();
pulsanteMenu("Home", "menu.php", "primary");
coda();