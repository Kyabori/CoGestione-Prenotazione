<?php 
require_once 'func.php';

hasToBeLoggedIn(false);
capa();
    pulsanteMenu("08 Febbraio", "src/giorno1-biennio.pdf");
    pulsanteMenu("09 Febbraio", "src/giorno2-biennio.pdf");
    pulsanteMenu("Torna Indietro", "index.php");
coda();
?>