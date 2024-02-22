<?php
require_once 'func.php';
hasToBeLoggedIn(true);
capa();

$res= $db_b->query("SELECT idalunno FROM it_tbl_alunni WHERE idclasse = 65");

while ($result = $res->fetch_assoc()) {
    $id_alunno = $result['idalunno'];
    $sql = "SELECT * FROM it_tbl_alunni WHERE idalunno = '$id_alunno'";
    $alunno = $db_b->query($sql)->fetch_assoc();
    echo "<br>";
    print_r($alunno);
    echo "<br>";
}