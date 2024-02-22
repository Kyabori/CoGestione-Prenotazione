<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>
<h1>Rimuovi Utenza</h1>
<form action="rimuovi_utenza_speciale.php" method="post">
    <div class="mb-3">
        <label for="codfisc" class="form-label">Matricola</label>
        <input type="text" class="form-control" id="matricola" name="matricola" required>
    </div>
    <button type="submit" class="btn btn-danger matricola" id="matricola" style="margin-bottom: 8px; width: 100%;">RIMUOVI UTENZA</button>
</form>
<?php
separatore();
pulsanteMenu("Indietro", "gestisci_utenze.php", "primary");
coda();

if(isset($_POST['matricola'])) {
    $matricola = $_POST['matricola'];
    $codfisc = $db_b->query("SELECT codfiscale FROM it_tbl_alunni WHERE idalunno = '$matricola'")->fetch_assoc()['codfiscale'];
    $db_a->query("DELETE FROM au_ruolispec WHERE codfisc = '$codfisc'");
    header("Location: gestisci_utenze.php");
    die();
}
?>