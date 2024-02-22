<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>

<h1>Lista corsi</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Nome corso</th>
            <th scope="col">Posti disponibili</th>
            <th scope="col">Data</th>
            <th scope="col">Aula</th>
            <th scope="col">Biennio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = $db_a->query("SELECT * FROM au_corsi");
        while ($row = $res->fetch_assoc()) {
            $nomecorso = $row['nome_corso'];
            $postidisponibili = $row['n_max'] - $row['n_pren'];
            $data = "G" . $row['giorno'] . "-T" . $row['turno'];
            $aula = $row['aula'];
            $biennio = $row['biennio'];
            if($biennio == 0){
                $biennio = "Triennio";
            }elseif($biennio == 1){
                $biennio = "Biennio";
            }
            if ($row['giorno'] == 1) {
                continue;
            }
            echo "<tr>";
            echo "<td>$nomecorso</td>";
            echo "<td>$postidisponibili</td>";
            echo "<td>$data</td>";
            echo "<td>$aula</td>";
            echo "<td>$biennio</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php
separatore();
pulsanteMenu("indietro", "gestisci_prenotazioni.php", "primary");
coda();
?>