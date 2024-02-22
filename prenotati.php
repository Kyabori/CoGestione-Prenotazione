<?php
require_once 'func.php';

// Verifica se l'utente deve essere loggato
hasToBeLoggedIn(true);

// Ottieni il ruolo minimo richiesto
$role = minRole(0);

// Esegui la funzione capa()
capa();

// Inizia l'output HTML
echo "<h1>Corsi prenotati</h1>";

// Controlla se l'id dell'alunno è disponibile nella sessione
if (isset($_SESSION['alunno']['idalunno'])) {
    $idalunno = $_SESSION['alunno']['idalunno'];

    // Esegui la query per ottenere i corsi prenotati dall'alunno
    $res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'");

    // Verifica se ci sono risultati
    if ($res && $res->num_rows > 0) {
        echo "<table class='table table-striped table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Giorno</th>";
        echo "<th scope='col'>Turno</th>";
        echo "<th scope='col'>Corso</th>";
        echo "<th scope='col'>Aula</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $res->fetch_assoc()) {
            // Scorrere i giorni e i turni
            for ($giorno = 1; $giorno <= 2; $giorno++) {
                for ($turno = 1; $turno <= 4; $turno++) {
                    $pr = "prenotazione_g0" . $giorno . "_t0" . $turno;
                    $idcorso = $row[$pr];

                    // Esegui la query per ottenere le informazioni sul corso
                    $corsoRes = $db_a->query("SELECT * FROM au_corsi WHERE id_corso = '$idcorso'");

                    if ($corsoRes && $corsoRow = $corsoRes->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><b>Giorno $giorno</b></td>";
                        echo "<td>Turno $turno</td>";
                        echo "<td>" . $corsoRow["nome_corso"] . "</td>";
                        echo "<td>" . $corsoRow["aula"] . "</td>";
                        echo "</tr>";
                    }
                }
            }
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Nessun corso prenotato.</p>";
    }

    $ress = $db_a->query("SELECT * FROM au_corsi WHERE (stud_1 = $idalunno OR stud_2 = $idalunno)");

    echo "<h3>Corsi che gestisci</h3>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>Giorno</th>";
    echo "<th scope='col'>Turno</th>";
    echo "<th scope='col'>Corso</th>";
    echo "<th scope='col'>Aula</th>";
    echo "<th scope='col'>Prenotazioni</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($roww = $ress->fetch_assoc()) {
        // Scorrere i giorni e i turni
        echo "<tr>";
        echo "<td><b>Giorno " . $roww["giorno"] ."</b></td>";
        echo "<td>Turno " . $roww["turno"] ."</td>";
        echo "<td>" . $roww["nome_corso"] . "</td>";
        echo "<td>" . $roww["aula"] . "</td>";
        echo "<td>" . $roww["n_pren"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Id alunno non disponibile nella sessione.</p>";
}

// Aggiungi un separatore
separatore();

// Aggiungi un pulsante per tornare al menu principale
pulsanteMenu("Indietro", "menu.php", "primary");

// Chiudi il documento HTML
coda();
