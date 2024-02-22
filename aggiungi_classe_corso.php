<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(1);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>
<h1>Aggiungi classe a corso</h1>
<form action="aggiungi_classe_corso.php" method="POST">
    <div class="container">
        <div class="mb-3 row">
            <!--Inserimento ID Corso -->
            <label for="idcorso" class="form-label">ID Corso</label>
            <input type="text" class="form-control" id="idcorso" name="idcorso" required>
            <!--Inserimento ID Classe -->
            <label for="idclasse" class="form-label">ID Classe</label>
            <input type="text" class="form-control" id="idclasse" name="idclasse" required>
        </div>
    </div>
    <!--Invio-->
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">AGGIUNGI CLASSE A CORSO</button>
<?php
separatore();
pulsanteMenu("Indietro", "gestisci_corsi.php", "primary");
coda();
//se cliccato, esegui
if(isset($_POST['idcorso']) && isset($_POST['idclasse'])) {
    //preleva i dati inseriti
    $idcorso = $_POST['idcorso'];
    $idclasse = $_POST['idclasse'];
    // richiede i dati dell'alunno
    $alunni = $db_b->query("SELECT * FROM it_tbl_alunni WHERE idclasse = '$idclasse'");
    //richiede i dati del corso prenotato
    $corso = $db_a->query("SELECT * FROM au_corsi WHERE id_corso = '$idcorso'")->fetch_assoc();
    //salva giorno e turno
    $giorno = $corso['giorno'];
    $turno = $corso['turno'];
    //crea una variabile e inizializza la conta a 0
    $prenotazione = "prenotazione_g0{$giorno}_t0{$turno}";
    $conta = 0;
    // cicla fin quando non finisce
    while($alunno = $alunni->fetch_assoc()) {
        //controlla se l'alunno ha prenotato
        $idalunno = $alunno['idalunno'];
        $res = $db_a->query("SELECT * FROM au_prenotazioni WHERE idalunno = '$idalunno'");
        //se non ha prenotato, crea la row
        if ($res->num_rows == 0) {
            $db_a->query("INSERT INTO au_prenotazioni (idalunno, prenotazione_g01_t01, prenotazione_g01_t02, prenotazione_g01_t03, prenotazione_g01_t04, prenotazione_g02_t01, prenotazione_g02_t02, prenotazione_g02_t03, prenotazione_g02_t04) VALUES ($idalunno, '0', '0', '0', '0', '0', '0', '0', '0')");
            // Dopo che crea la row inserisci tutto
            $db_a->query("UPDATE au_prenotazioni SET $prenotazione = '$idcorso' WHERE idalunno = '$idalunno'");
            $conta = $conta + 1;
        } else {
            //se ha prenotato, aggiorna la row e conta
            $db_a->query("UPDATE au_prenotazioni SET $prenotazione = '$idcorso' WHERE idalunno = '$idalunno'");
            $conta = $conta + 1;
        }
    }
    //addiziona a $n_pren la var $conta
    $db_a -> query("UPDATE au_corsi SET n_pren = n_pren + 0 + $conta WHERE id_corso = '$idcorso'");
    //popup di success
    echo "<div class='alert alert-success' role='alert'>Classe aggiunta con successo!</div>";
}
?>