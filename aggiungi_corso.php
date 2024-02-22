<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>
<h1>Aggiungi corso</h1>
<form action="aggiungi_corso.php" method="POST">
    <div class="container">
        <div class="mb-3 row">
            <!-- FORM AGGIUNTA CORSO -->
            <label for="nome_corso" class="form-label">Nome Corso</label>
            <input type="text" class="form-control" id="nome_corso" name="nome_corso" required>

            <label for="n_max" class="form-label">Posti Massimi</label>
            <input type="text" class="form-control" id="n_max" name="n_max" required>

            <label for="aula" class="form-label">Aula</label>
            <input type="text" class="form-control" id="aula" name="aula" required>

            <label for="moderatore" class="form-label">Moderatore</label>
            <input type="text" class="form-control" id="moderatore" name="moderatore" required>
            <div class="col" style="margin-top:10px;">
                <label for="stud_1" class="form-label">Studente 1 (matricola) </label>
                <input type="text" class="form-control" id="stud_1" name="stud_1" required>
            </div>
            <div class="col" style="margin-top:10px;">
                <label for="stud_2" class="form-label">Studente 2 (matricola)</label>
                <input type="text" class="form-control" id="stud_2" name="stud_2" required>
            </div>            
            <div class="col" style="margin-top:10px;">
                <label for="giorno" class="form-label">Giorno(1, 2) </label>
                <input type="text" class="form-control" id="giorno" name="giorno" max="2" required>
            </div>
            <div class="col" style="margin-top:10px;">
                <label for="turno" class="form-label">Turno(1, 2, 3, 4)</label>
                <input type="text" class="form-control" id="turno" name="turno" max="4" required>
            </div>
            <div class="col" style="margin-top:10px;">
                <label for="biennio" class="form-label">Biennio (0, 1)</label>
                <input type="text" class="form-control" id="biennio" name="biennio" max="1" required>
            </div>
            <!-- FINE FORM AGGIUNTA CORSO -->
        </div>
    </div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">AGGIUNGI CORSO</button>
</form>


<?php
separatore();
pulsanteMenu("Indietro", "gestisci_corsi.php", "primary");
coda();
// se tutto viene scritto, invia
if(isset($_POST['nome_corso']) && isset($_POST['n_max']) && isset($_POST['aula']) && isset($_POST['moderatore']) && isset($_POST['stud_1']) && isset($_POST['stud_2'])) {
    //prende le varie variabili dagli input e li inserisce in delle variabili
    $nome_corso = $_POST['nome_corso'];
    $n_max = $_POST['n_max'];
    $aula = $_POST['aula'];
    $moderatore = $_POST['moderatore'];
    $stud_1 = $_POST['stud_1'];
    $stud_2 = $_POST['stud_2'];
    $giorno = $_POST['giorno'];
    $turno = $_POST['turno'];
    $biennio = $_POST['biennio'];
    //inserisce il corso
    $db_a->query("INSERT INTO au_corsi (nome_corso, n_max, n_pren, aula, mod_corso, stud_1, stud_2, giorno, turno, biennio) VALUES ('$nome_corso', '$n_max', 0, '$aula', '$moderatore', '$stud_1', '$stud_2', '$giorno', '$turno', '$biennio')");
    //aggiunta del valore 'NULL' per ogni studente nel seguente giorno e turno nella tabella au_prenotazioni
    //per ogni studente in stud_1 e stud_2, occupa il corso
    $prenotazione = "prenotazione_g0" . $giorno . "_t0" . $turno;
    $db_a->query("UPDATE au_prenotazioni SET $prenotazione = 'NULL' WHERE idalunno = '$stud_1'");
    $db_a->query("UPDATE au_prenotazioni SET $prenotazione = 'NULL' WHERE idalunno = '$stud_2'");
    // sposta in gestisci_corsi.php
    header("Location: gestisci_corsi.php");
    die();
}
?>