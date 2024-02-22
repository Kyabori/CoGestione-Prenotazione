<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(0);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();

$idalunno = $_SESSION['alunno']['idalunno'];
$biennio_ses = $_SESSION['biennio'];
$prenotazioni = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'")->fetch_assoc();

$qp = "select it_tbl_classi.anno from it_tbl_alunni, it_tbl_classi where it_tbl_alunni.idclasse = it_tbl_classi.idclasse and it_tbl_alunni.idalunno = $idalunno";
$primina = $db_b->query($qp)->fetch_assoc()['anno'];

echo "<h1>Prenota un corso</h1>";
echo "<div class='mb-3 row'>";
echo "<form action='prenota.php' method='POST'>";
//inizia il ciclo per i giorni (1, 2)
for ($giorno = 1; $giorno < 3; $giorno++) {
    echo "<div class='col'>";
    echo "<h2>Giorno $giorno</h2>";
    //inizia il ciclo per i turni (1, 2, 3, 4)
    for ($turno = 1; $turno <= 4; $turno++) {
        //prende tutte le prenotazioni dell'utente
        $prenotazione = "prenotazione_g0" . $giorno . "_t0" . $turno;
        $corso = 'corso-g' . $giorno . '-t' . $turno . '';
        //se la prenotazione è vuota (uguale a 0), mostra i corsi disponibili
            $sessoanale = $db_a->query("SELECT COUNT(*) FROM au_corsi WHERE giorno = $giorno AND turno = $turno AND (stud_1 = $idalunno OR stud_2 = $idalunno)")->fetch_array()[0];
            if ($prenotazioni[$prenotazione] == 0) {
                $res = $db_a->query("SELECT * FROM au_corsi WHERE giorno = $giorno AND turno = $turno AND (n_pren < n_max)");
                echo "<label for='$corso' class='form-label'>Turno $turno</label>";
                if ($sessoanale > 0) {
                    echo "<br><b>In questo turno sei organizzatore di un corso</b><input type='hidden' name='corso-g$giorno-t$turno' value='0'>";
                } else if ($giorno == 2 && $turno == 4 && $primina != 1) {
                    echo "<br><b>Questo turno è accessibile solo alle prime</b><input type='hidden' name='corso-g2-t4' value='0'>";
                } else { 
                    echo "<select name='$corso' class='form-select' required>";
                    echo "<option value='0' selected>Seleziona un corso</option>";
                    while ($row = $res->fetch_assoc()) {
                        $idcorso = $row['id_corso'];
                        $nomecorso = $row['nome_corso'];
                        $bienno = $row['biennio'];
                        $postirimanenti = $row['n_max'] - $row['n_pren'];
                        if ($bienno == 0 && $biennio_ses == false) {
                            $bienno = "Triennio";
                            echo "<option value='$idcorso'>$nomecorso - $postirimanenti Posti rimanenti - $bienno</option>";
                        } elseif ($bienno == 1 && $biennio_ses == true) {
                            $bienno = "Biennio";
                            echo "<option value='$idcorso'>$nomecorso - $postirimanenti Posti rimanenti - $bienno</option>";
                        }
                    }
                    echo "</select>";
                }
            } elseif ($prenotazioni[$prenotazione] > 0) {
                $sessovaginale = $prenotazioni[$prenotazione];
                echo "<br><b>Turno $turno - prenotazione esistente</b><input type='hidden' name='corso-g$giorno-t$turno' value='$sessovaginale'>";
            }
            echo "<hr>";
    }
}
echo "</div>";
echo "<input type='submit' name='prenota' id='prenota' value='PRENOTA' style='margin-bottom: 8px; margin-top:4px; width: 100%;' class='btn btn-success'>";
echo "</form>";
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");

//carica tutti i corsi in au_prenotazioni, prendendo l'idutente

if(isset($_POST['prenota'])) {
    $idalunno = $_SESSION['alunno']['idalunno'];
    $giorno1t1 = $_POST['corso-g1-t1'];
    $giorno1t2 = $_POST['corso-g1-t2'];
    $giorno1t3 = $_POST['corso-g1-t3'];
    $giorno1t4 = $_POST['corso-g1-t4'];
    $giorno2t1 = $_POST['corso-g2-t1'];
    $giorno2t2 = $_POST['corso-g2-t2'];
    $giorno2t3 = $_POST['corso-g2-t3'];
    $giorno2t4 = $_POST['corso-g2-t4'];

    $msg = "";

    //controlla se ci sono i posti disponibili
    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno1t1'")->fetch_assoc()["n"];
    if($res > 0) {
        if($giorno1t1 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g01_t01 = '$giorno1t1' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno1t1'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno1t2'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno1t2 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g01_t02 = '$giorno1t2' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno1t2'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno1t3'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno1t3 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g01_t03 = '$giorno1t3' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno1t3'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno1t4'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno1t4 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g01_t04 = '$giorno1t4' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno1t4'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno2t1'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno2t1 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g02_t01 = '$giorno2t1' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno2t1'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno2t2'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno2t2 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g02_t02 = '$giorno2t2' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno2t2'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno2t3'")->fetch_assoc()["n"];
    if($res > 0) {
        if ($giorno2t3 != 0) {
            $db_a->query("UPDATE au_prenotazioni SET prenotazione_g02_t03 = '$giorno2t3' WHERE idalunno = '$idalunno'");
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno2t3'");
        }
    } else {
        $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
    }

    if ($primina == 1) {
        $res = $db_a->query("SELECT (n_max - n_pren) AS n FROM au_corsi WHERE id_corso = '$giorno2t4'")->fetch_assoc()["n"];
        if($res > 0) {
            if ($giorno2t4 != 0) {
                $db_a->query("UPDATE au_prenotazioni SET prenotazione_g02_t04 = '$giorno2t4' WHERE idalunno = '$idalunno'");
                $db_a->query("UPDATE au_corsi SET n_pren = n_pren + 1 WHERE id_corso = '$giorno2t4'");
            }
        } else {
            $msg = ", tuttavia alcuni corsi non sono piu disponibili. Ricontrolla la pagina.";
        }
    }

    echo "<script>alert('Prenotazione effettuata con successo $msg');</script>";
    echo "<script>window.location.href='menu.php';</script>";
}

coda();
?>