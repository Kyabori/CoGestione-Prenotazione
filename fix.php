<?php 
require_once 'func.php';

$res = $db_a->query("SELECT id_corso as id, nome_corso as nc FROM au_corsi");
while ($row = $res->fetch_assoc()){
    $id = $row['id'];
    $nc = $row['nc'];
    $postieffettivi = $db_a->query("SELECT COUNT(*) as n FROM `au_prenotazioni` WHERE `prenotazione_g01_t01` = $id OR `prenotazione_g01_t02` = $id OR `prenotazione_g01_t03` = $id OR `prenotazione_g01_t04` = $id OR `prenotazione_g02_t01` = $id OR `prenotazione_g02_t02` = $id OR `prenotazione_g02_t03` = $id OR `prenotazione_g02_t04` = $id;")->fetch_assoc()['n'];
    echo "$id $nc $postieffettivi <br>";
    $db_a->query("UPDATE au_corsi SET n_pren = '$postieffettivi' WHERE id_corso = $id");
}