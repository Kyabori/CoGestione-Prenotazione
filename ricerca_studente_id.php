<?php 
require_once 'func.php';

// Verifica se l'utente è loggato e ha il ruolo minimo richiesto
hasToBeLoggedIn(true);
$role = minRole(1);
capa();
?>
    <form action="" method="post">
        <h1>Ricerca studente per ID</h1>
        <label for="ids">ID STUDENTE (4 numeri): </label>
        <input type="number" name="ids" id="ids" class="form-control" value="<?= $_POST['ids'] ?>"> <br>
        <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">RICERCA STUDENTE</button>
    </form>

<?php

if(isset($_POST['ids'])) {
    $ids = $db_b->real_escape_string($_POST['ids']);
    $res = $db_b->query("SELECT * FROM it_tbl_alunni WHERE idalunno = $ids");
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