<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

echo "<h1>Prenota per alunno</h1>";
echo "<form action='prenota_per_alunno.php' method='POST'>";
echo "<div class='mb-3'>";
echo "<label for='idalunno' class='form-label'>ID Alunno</label>";
echo "<input type='text' class='form-control' name='idalunno' id='idalunno' required>";
echo "</div>";
echo "<div class='mb-3'>";
echo "<label for='corso' class='form-label'>Corso</label>";
echo "<select class='form-select' id='corso' name='corso'>";
echo "<option value='0' selected>Seleziona un corso</option>";
$res = $db_a->query("SELECT id_corso as id, nome_corso as nc FROM au_corsi");
while ($row = $res->fetch_assoc()){
    $id = $row['id'];
    $nc = $row['nc'];
    $postirimanenti = $db_a->query("SELECT n_max, n_pren FROM au_corsi WHERE id_corso = '$id'")->fetch_assoc();
    $giorno = $db_a->query("SELECT giorno FROM au_corsi WHERE id_corso = '$id'")->fetch_assoc()['giorno'];
    $turno = $db_a->query("SELECT turno FROM au_corsi WHERE id_corso = '$id'")->fetch_assoc()['turno'];
    $biennio = $db_a->query("SELECT biennio FROM au_corsi WHERE id_corso = '$id'")->fetch_assoc()['biennio'];
    if($biennio == 1) {
        $biennio = "Biennio";
    } else {
        $biennio = "Triennio";
    }
    if ($giorno == 1) {
        continue;
    }
    $p_rimanenti = $postirimanenti['n_max'] - $postirimanenti['n_pren'];
    if($postirimanenti['n_max'] != $postirimanenti['n_pren'] || $p_rimanenti <= 0) {
        echo "<option value='$id'>$nc - $p_rimanenti posti rimanenti - Turno $turno / Giorno $giorno - $biennio</option>";
    }
}
echo "</select>";
echo "</div>";
echo "<input type='submit' class='btn btn-primary' name='prenota' style='margin-bottom: 8px; width: 100%;' value='Prenota'>";
echo "</form>";
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");
coda();

if(isset($_POST['prenota'])) {
    $idalunno = $_POST['idalunno'];
    $corso = $_POST['corso'];
    $res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'")->fetch_assoc();
    if($res == null) {
        $db_a->query("INSERT INTO au_prenotazioni (idalunno, prenotazione_g01_t01, prenotazione_g01_t02, prenotazione_g01_t03, prenotazione_g01_t04, prenotazione_g02_t01, prenotazione_g02_t02, prenotazione_g02_t03, prenotazione_g02_t04) VALUES ($idalunno, '0', '0', '0', '0', '0', '0', '0', '0')");
        $db_a->query("INSERT INTO au_firstlogin (idalunno, firstlogin) VALUES ('$idalunno', 1)");
        $giorno = $db_a->query("SELECT giorno FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['giorno'];
        $turno = $db_a->query("SELECT turno FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['turno'];
        $prenotazione = "prenotazione_g0" . $giorno . "_t0" . $turno;
        $postirimanenti = $db_a->query("SELECT n_max, n_pren FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc();
        if($postirimanenti['n_max'] == $postirimanenti['n_pren']) {
            echo "<div class='alert alert-danger' role='alert'>Il corso selezionato è pieno</div>";
        } else {
            if($res[$prenotazione] == 0) {
                $db_a->query("UPDATE au_prenotazioni SET $prenotazione = '$corso' WHERE idalunno = '$idalunno'");
                $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$corso'");
                echo "<div class='alert alert-success' role='alert'>Prenotazione effettuata con successo!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>L'alunno ha già prenotato un corso per quel giorno e quel turno</div>";
            }
        }
    } else {
        $giorno = $db_a->query("SELECT giorno FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['giorno'];
        $turno = $db_a->query("SELECT turno FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['turno'];
        $prenotazione = "prenotazione_g0" . $giorno . "_t0" . $turno;
        $postirimanenti = $db_a->query("SELECT n_max, n_pren FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc();
        if($postirimanenti['n_max'] == $postirimanenti['n_pren']) {
            echo "<div class='alert alert-danger' role='alert'>Il corso selezionato è pieno</div>";
        } else {
            if($res[$prenotazione] == 0) {
                $db_a->query("UPDATE au_prenotazioni SET $prenotazione = '$corso' WHERE idalunno = '$idalunno'");
                $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$corso'");
                echo "<div class='alert alert-success' role='alert'>Prenotazione effettuata con successo!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>L'alunno ha già prenotato un corso per quel giorno e quel turno</div>";
            }
        }
    }
}

?>
