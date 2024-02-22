<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
echo "<h1>Lista corsi</h1>";
echo "<form action='rimuovi_corso.php' method='POST'>";
echo "<label for='id_corso' class='form-label'>ID corso</label>";
echo "<select name='id_corso' class='form-select'>";
echo "<option value='' disabled selected>Seleziona un corso</option>";
$res = $db_a->query("SELECT * FROM au_corsi");
while ($row = $res->fetch_assoc()) {
    $nomecorso = $row['nome_corso'];
    $id_corso = $row['id_corso'];
    $giorno = $row['giorno'];
    $turno = $row['turno'];
    $biennio = $row['biennio'];
    if($biennio == 1){
        echo "<option value='$id_corso'>$nomecorso - Giorno 0$giorno/Turno 0$turno - Biennio</option>";
    } else {
        echo "<option value='$id_corso'>$nomecorso - Giorno 0$giorno/Turno 0$turno - Triennio</option>";
    }
}
echo "</select>";
echo "<br>";
echo "<button type='submit' class='btn btn-danger' style='margin-bottom: 8px; width: 100%;'>Rimuovi corso</button>";
echo "</form>";

if(isset($_POST['id_corso'])){
    $id_corso = $_POST['id_corso'];
    $db_a->query("DELETE FROM au_corsi WHERE id_corso = $id_corso");
    header("Location: gestisci_corsi.php");
}

separatore();
pulsanteMenu("Indietro", "gestisci_corsi.php", "primary");
coda();
?>