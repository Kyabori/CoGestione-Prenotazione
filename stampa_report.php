<?php 
require_once 'func.php';
hasToBeLoggedIn(true);
$role = minRole(2);

// 0 -> studente
// 1 -> Helpdesk
// 2 -> organizzazione

capa();
?>
<form action="server_stampa.php" target="_blank" method="post">
    <h1>Seleziona i corsi da stampare (giorno e turno)</h1>
    <div class="mb-3">
        <select class="form-select" aria-label="" name="giorno">
            <option selected disabled>Seleziona Giorno</option>
            <option value="1">Giorno 1</option>
            <option value="2">Giorno 2</option>
        </select>
    </div>
    <div class="mb-3">
        <select class="form-select" aria-label="" name="turno">
            <option selected disabled>Seleziona Turno</option>
            <option value="1">Turno 1</option>
            <option value="2">Turno 2</option>
            <option value="3">Turno 3</option>
            <option value="4">Turno 4</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 8px; width: 100%;">GENERA E STAMPA</button>
</form>
<?php
separatore();
pulsanteMenu("Home", "menu.php", "primary");
coda();
?>