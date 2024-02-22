<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

pulsanteMenu("Elimina prenotazione", "elimina_prenotazione.php", "danger");
pulsanteMenu("Elimina singola prenotazione", "elimina_singola_prenotazione.php", "danger");
pulsanteMenu("Mostra prenotazione disponibile", "mostra_prenotazione_disponibile.php", "primary");
pulsanteMenu("Prenota per alunno", "prenota_per_alunno.php", "success");
pulsanteMenu("Ricerca studente", "ricerca_studente.php", "danger");
pulsanteMenu("Ricerca studente per ID", "ricerca_studente_id.php", "danger");
separatore();
pulsanteMenu("Iscrizioni", "iscrizioni.php", "primary");
if($role == 2){
    pulsanteMenu("!! RIPULISCI DATABASE !!", "rdb.php", "danger");
}
separatore();
pulsanteMenu("Home", "menu.php", "primary");
coda();