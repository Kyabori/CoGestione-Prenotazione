<?php 
require_once 'func.php';
hasToBeLoggedIn(true);

$turno = $_POST['turno'];
$giorno = $_POST['giorno'];

//query per ottenere i partecipanti di un corso in base al giorno e al turno selezionato
$sql = "SELECT * FROM au_corsi WHERE giorno = '$giorno' AND turno = '$turno'";
$sesso = $db_a->query($sql);
while ($result = $sesso->fetch_assoc()) {
    //print_r($result);
    $id_corso = $result['id_corso'];
    $nome_corso = $result['nome_corso'];
    $prenotazione = "prenotazione_g0".$giorno."_t0".$turno;
    $sql = "SELECT idalunno FROM au_prenotazioni WHERE $prenotazione = '$id_corso'";
    $lista_id_alunni = $db_a->query($sql);
    if($lista_id_alunni->num_rows == 0){
        continue;
    }
    //query per ottenere i dati degli alunni partecipanti al corso
    $sql = "SELECT * FROM it_tbl_alunni, it_tbl_classi WHERE it_tbl_alunni.idclasse = it_tbl_classi.idclasse AND idalunno IN (";
    while($row = $lista_id_alunni->fetch_array()) {
        $sql .= $row['idalunno'].",";
    }
    $sql = substr($sql, 0, -1);
    $sql .= ")";
    $lista_alunni = $db_b->query($sql);

    //query per ottenere i dati del corso
    $sql = "SELECT * FROM au_corsi WHERE id_corso = '$id_corso'";
    $corso = $db_a->query($sql)->fetch_assoc();

    // porco dio!!!!!!!
    //print_r($corso);
    //echo "<br>";
    //print_r($lista_alunni);
    //echo "<br><div ></div>";
    ?>
    <div style='page-break-after: always;'>
        <b>Nome corso: </b> <?= $corso['nome_corso'] ?> <br>
        <b>AULA: </b> <?= $corso['aula'] ?> <br>
        <b>Giorno: </b> <?= $corso['giorno'] ?> 
        ---<b> Turno: </b> <?= $corso['turno'] ?> 
        ---<b> Biennio: </b> <?= $corso['biennio'] == 0 ? "NO" : "SI" ?> <br>
        <b>Moderatore: </b> <?= $corso['mod_corso'] ?> <br>
        <br> <br>
        <table border="1">
            <thead>
                <tr>   
                    <td><b>Presente</b></td>
                    <td><b>Nome</b></td>
                    <td><b>Cognome</b></td>
                    <td><b>Classe</b></td>
                </tr>
            </thead>
            <tbody>
                <?php while ($alunn = $lista_alunni->fetch_assoc()) { ?>
                    <tr>
                        <td> <input type="checkbox" name="" id=""> </td>
                        <td> <?= $alunn['nome'] ?> </td>
                        <td> <?= $alunn['cognome'] ?> </td>
                        <td> <?= $alunn['anno']." ".$alunn['sezione']." ".$alunn['specializzazione'] ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <label for=""><b>DOCENTE: </b></label> <input type="text" name="" id="" width="100">
        <label for=""><b>  FIRMA: ____________________________</b></label> 
    </div>
    <?php
}

?>

<script>
    window.print();
</script>