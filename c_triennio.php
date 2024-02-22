<?php 
require_once 'func.php';

hasToBeLoggedIn(false);
capa();
    pulsanteMenu("08 Febbraio", "src/giorno1-triennio.pdf");
    pulsanteMenu("09 Febbraio", "src/giorno2-triennio.pdf");
    pulsanteMenu("Torna Indietro", "index.php");
coda();
?>