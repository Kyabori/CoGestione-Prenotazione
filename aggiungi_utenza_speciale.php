<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>

<form action="aggiungi_utenza_speciale.php" method="post">
    <h1>Aggiungi Utenza</h1>
    <div class="mb-3">
        <!-- form aggiunta utenza speciale -->
        <label for="matricola" class="form-label">Matricola</label>
        <input type="text" class="form-control" id="matricola" name="matricola" required>
    </div>
    <div class="mb-3">
        <label for="ruolo" class="form-label">Ruolo</label>
        <select class="form-select" id="ruolo" name="ruolo" required>
            <option value="" disabled selected>Seleziona un ruolo</option>
            <option value="3">Sicurezza</option>
            <option value="1">Helpdesk</option>
            <option value="2">Organizzazione</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">AGGIUNGI UTENZA</button>
</form>
<?php
separatore();
pulsanteMenu("Indietro", "gestisci_utenze.php", "primary");
coda();

//se matricola e ruolo vengono modificati, esegui
if(isset($_POST['matricola']) && isset($_POST['ruolo'])) {
    //salva le due variabili
    $matricola = $_POST['matricola'];
    $ruolo = $_POST['ruolo'];
    // dalla matricola al codice fiscale
    $codfisc = $db_b->query("SELECT codfiscale FROM it_tbl_alunni WHERE idalunno = '$matricola'")->fetch_assoc()['codfiscale'];
    //inserisci cod fiscale e ruolo
    $db_a->query("INSERT INTO au_ruolispec (codfisc, ruolo) VALUES ('$codfisc', '$ruolo')");
    //torna in gestisci_utente e die
    header("Location: gestisci_utenze.php");
    die();
}
?>