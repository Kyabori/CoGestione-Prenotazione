<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

capa();
?>

<h1>Elimina prenotazione</h1>
<form action="elimina_prenotazione.php" method="post">
    <div class="form-group">
    <label for=id_alunno>ID alunno</label>
    <input type="text" class="form-control" id="id_alunno" name="id_alunno" required>
    </div>
    <hr>
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">ELIMINA PRENOTAZIONE</button>
</form>

<?php
separatore();
pulsanteMenu("Indietro", "menu.php", "primary");
coda();
if(isset($_POST['id_alunno'])) {
    $idalunno = $_POST['id_alunno'];

    $res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'");
    if ($res->num_rows == 0) {
        echo "<div class='alert alert-danger' role='alert'>Prenotazione non trovata!</div>";
    } else {
        //cicla su tutte le prenotazioni, prende l'id del corso e sottrae 1 al numero di prenotazioni
        $res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'");
        for($i = 1; $i <= 2; $i++) {
            for($j = 1; $j <= 4; $j++) {
                $row = $res->fetch_assoc();
                $idcorso = $row['prenotazione_g0'.$i.'_t0'.$j];
                if($idcorso != 0) {
                    $db_a->query("UPDATE au_corsi SET n_pren = n_pren - 1 WHERE id_corso = '$idcorso'");
                }
            }
        }
        //elimina la prenotazione
        $db_a->query("UPDATE au_prenotazioni SET
            prenotazione_g01_t01 = '0',
            prenotazione_g01_t02 = '0',
            prenotazione_g01_t03 = '0',
            prenotazione_g01_t04 = '0',
            prenotazione_g02_t01 = '0',
            prenotazione_g02_t02 = '0',
            prenotazione_g02_t03 = '0'
            WHERE idalunno = '$idalunno'");
        echo "<div class='alert alert-success' role='alert'>Prenotazione eliminata con successo!</div>";
    }
}
?>