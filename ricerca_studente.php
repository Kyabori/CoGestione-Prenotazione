<?php 
require_once 'func.php';

// Verifica se l'utente è loggato e ha il ruolo minimo richiesto
hasToBeLoggedIn(true);
$role = minRole(1);
capa();
?>
    <form action="ricerca_studente.php" method="post">
        <h1>Ricerca studente</h1>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="cognome" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="cognome" name="cognome" required>
        </div>

        <!-- inserimento classe da 3 input da anno, sezione e specializzazione -->
        <div class="mb-3">
            <label for="anno" class="form-label">Anno</label>
            <select class="form-select" id="anno" name="anno">
                <option value="0" selected>Seleziona un anno</option>
                <option value="1">1 anno</option>
                <option value="2">2 anno</option>
                <option value="3">3 anno</option>
                <option value="4">4 anno</option>
                <option value="5">5 anno</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="classe" class="form-label">Sezione</label>
            <input type="text" class="form-control" id="sezione" name="sezione">
        </div>
        <div class="mb-3">
            <label for="classe" class="form-label">Classe</label>
            <select class="form-select" id="classe" name="classe">
                <option value="0" selected>Seleziona un indirizzo</option>
                <option value="Informatica">Informatica</option>
                <option value="Biotecnologie Sanitarie">Biotecnologie</option>
                <option value="Elettrotecnica">Elettrotecnica</option>
                <option value="SIA">SIA</option>
                <option value="AFM">AFM</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">RICERCA STUDENTE</button>
    </form>

<?php

if(isset($_POST['nome']) && isset($_POST['cognome'])) {
    $nome = $db_b->real_escape_string($_POST['nome']);
    $cognome = $db_b->real_escape_string($_POST['cognome']);
    $anno = $db_b->real_escape_string($_POST['anno']);
    $sezione = $db_b->real_escape_string($_POST['sezione']);
    $classe = $db_b->real_escape_string($_POST['classe']);
    $res = $db_b->query("SELECT * FROM it_tbl_alunni WHERE nome = '$nome' AND cognome = '$cognome' AND idclasse = (SELECT idclasse FROM it_tbl_classi WHERE anno = '$anno' AND sezione = '$sezione' AND specializzazione = '$classe')");
    if ($res->num_rows == 0) {
        echo "<div class='alert alert-danger' role='alert'>Studente non trovato!</div>";
    } else {
        $row = $res->fetch_assoc();
        $matricola = $row['idalunno'];
        $nome = $row['nome'];
        $cognome = $row['cognome'];
        $classe = $row['idclasse'];
    }
}


separatore();

$classe_completa = $db_b->query("SELECT * FROM it_tbl_classi WHERE idclasse = '$classe'")->fetch_assoc();
$classe = $classe_completa['anno'] . $classe_completa['sezione'] . " " . $classe_completa['specializzazione'];

echo "<h1> Corsi prenotati </h1>";
echo "<center><p>Matricola: $matricola - Nome: $nome $cognome</p></center>";
$res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$matricola'")->fetch_assoc();
echo "<table class='table table-striped'>
    <thead>
        <tr>
            <th scope='col'>Giorno</th>
            <th scope='col'>Turno</th>
            <th scope='col'>Corso</th>
            <th scope='col'>Aula</th>
        </tr>
    </thead>
    <tbody>";
for ($i = 1; $i <= 2; $i++) {
    for ($j = 1; $j <= 4; $j++) {
        $corso = $res["prenotazione_g0$i" . "_t0$j"];
        if ($corso != 0) {
            $giorno = $i;
            $turno = $j;
            $nomecorso = $db_a->query("SELECT nome_corso FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['nome_corso'];
            $aula = $db_a->query("SELECT aula FROM au_corsi WHERE id_corso = '$corso'")->fetch_assoc()['aula'];
            /*if ($giorno == 1) {
                continue;
            }*/
            echo "<tr>";
            echo "<td>$giorno</td>";
            echo "<td>$turno</td>";
            echo "<td>$nomecorso</td>";
            echo "<td>$aula</td>";
            echo "</tr>";
        }
    }
}
echo "</tbody>
</table>";

pulsanteMenu("Home", "menu.php", "primary");
coda();
?>