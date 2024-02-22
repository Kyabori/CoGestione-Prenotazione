<?php 
require_once 'func.php';

hasToBeLoggedIn(false);
capa();
    pulsanteMenu("Calendari Triennio", "c_triennio.php");
    pulsanteMenu("Calendari Biennio", "c_biennio.php");
    pulsanteMenu("Login", "login.php");
coda();
?>