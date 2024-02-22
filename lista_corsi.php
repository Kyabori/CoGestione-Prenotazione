<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
//stampa tutti i corsi
echo "<h1>Lista corsi</h1>";
echo "<table class='table table-striped table-hover'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th scope='col'>Nome corso</th>";
            echo "<th scope='col'>Posti rimanenti</th>";
            echo "<th scope='col'>Aula</th>";
            echo "<th scope='col'>Moderatore</th>";
            echo "<th scope='col'>Studente 1</th>";
            echo "<th scope='col'>Studente 2</th>";
            echo "<th scope='col'>Giorno</th>";
            echo "<th scope='col'>Turno</th>";
            echo "<th scope='col'>Tipo</th>";
        echo "</tr>";
    echo "</thead>";
echo "<tbody>";
$res = $db_a->query("SELECT * FROM au_corsi");
while ($row = $res->fetch_assoc()) {
    $nomecorso = $row['nome_corso'];
    $postidisponibili = $row['n_max'] - $row['n_pren'];
    $aula = $row['aula'];
    $moderatore = $row['mod_corso'];
    $stud1 = $row['stud_1'];
    $stud2 = $row['stud_2'];
    $studente1 = $db_b->query("SELECT nome, cognome FROM it_tbl_alunni WHERE idalunno = '$stud1'")->fetch_assoc()['nome'] . " " . $db_b->query("SELECT nome, cognome FROM it_tbl_alunni WHERE idalunno = '$stud1'")->fetch_assoc()['cognome'];
    $studente2 = $db_b->query("SELECT nome, cognome FROM it_tbl_alunni WHERE idalunno = '$stud2'")->fetch_assoc()['nome'] . " " . $db_b->query("SELECT nome, cognome FROM it_tbl_alunni WHERE idalunno = '$stud2'")->fetch_assoc()['cognome'];
    if($studente1 == " ") {
        $studente1 = "RDI";
    }
    if($studente2 == " ") {
        $studente2 = "RDI";
    }
    $giorno = $row['giorno'];
    $turno = $row['turno'];
    if($giorno == 1) {
        continue;
    }
    echo "<tr>";
    echo "<td>$nomecorso</td>";
    echo "<td>$postidisponibili</td>";
    echo "<td>$aula</td>";
    echo "<td>$moderatore</td>";
    echo "<td>$studente1</td>";
    echo "<td>$studente2</td>";
    echo "<td>$giorno</td>";
    echo "<td>$turno</td>";
    if($row['biennio'] == 1) {
        echo "<td>Biennio</td>";
    } else {
        echo "<td>Triennio</td>";
    }
    echo "</tr>";
}
echo "</table>";
separatore();
pulsanteMenu("Indietro", "gestisci_corsi.php", "primary");
coda();
?>