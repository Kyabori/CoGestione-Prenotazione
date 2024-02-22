<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

capa();
?>

<h1>Elimina singola prenotazione</h1>
<form action="elimina_singola_prenotazione.php" method="post">
    <div class="form-group">
        <label for=id_alunno>ID alunno</label>
        <input type="text" class="form-control" id="id_alunno" name="id_alunno" required>
    </div>
    <div class="form-group">
        <label for=giorno>Giorno</label>
        <input type="text" class="form-control" id="giorno" name="giorno" required>
    </div>
    <div class="form-group">
        <label for=turno>Turno</label>
        <input type="text" class="form-control" id="turno" name="turno" required>
    </div>
    <hr>
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">ELIMINA PRENOTAZIONE</button>
</form>

<?php
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");
coda();
if(isset($_POST['id_alunno'])) {
    $pren = "prenotazione_g0".$_POST['giorno']."_t0".$_POST['turno'];
    $idalunno = $_POST['id_alunno'];

    $res = $db_a->query("SELECT $pren FROM au_prenotazioni WHERE idalunno = '$idalunno'");
    if ($res->num_rows == 0) {
        echo "<div class='alert alert-danger' role='alert'>Prenotazione non trovata!</div>";
    } else {
        $row = $res->fetch_assoc();
        if($row[$pren] == 0) {
            echo "<div class='alert alert-danger' role='alert'>Prenotazione non trovata!</div>";
        } else {
            $idcorso = $row[$pren];
            $db_a->query("UPDATE au_corsi SET n_pren = n_pren - 1 WHERE id_corso = '$idcorso'");
            $db_a->query("UPDATE au_prenotazioni SET $pren = '0' WHERE idalunno = '$idalunno'");
            echo "<div class='alert alert-success' role='alert'>Prenotazione eliminata con successo!</div>";
        }
    }

}
?>