<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>
<h1>Lista utenze</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Matricola</th>
            <th scope="col">Nome</th>
            <th scope="col">Cognome</th>
            <th scope="col">Ruolo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = $db_a->query("SELECT * FROM au_ruolispec");
        while ($row = $res->fetch_assoc()) {
            $codfisc = $row['codfisc'];
            $ruolo = $row['ruolo'];
            $matricola = $db_b->query("SELECT idalunno FROM it_tbl_alunni WHERE codfiscale = '$codfisc'")->fetch_assoc()['idalunno'];
            $nome = $db_b->query("SELECT nome FROM it_tbl_alunni WHERE codfiscale = '$codfisc'")->fetch_assoc()['nome'];
            $cognome = $db_b->query("SELECT cognome FROM it_tbl_alunni WHERE codfiscale = '$codfisc'")->fetch_assoc()['cognome'];
            echo "<tr>";
            echo "<td>$matricola</td>";
            echo "<td>$nome</td>";
            echo "<td>$cognome</td>";
            if ($ruolo == 1) {
                echo "<td>Helpdesk</td>";
            } elseif ($ruolo == 2) {
                echo "<td>Organizzazione</td>";
            } elseif ($ruolo == 3) {
                echo "<td>Sicurezza</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php
separatore();
pulsanteMenu("Indietro", "gestisci_utenze.php", "primary");
coda();
?>