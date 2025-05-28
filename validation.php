<?php
session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Partie validation

//Évalue si le nom est valide
function estValide($client)
{
    return preg_match('/^(?!\s*$)[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/', $client);
}

//Exécuter l'alerte si estValide($nomClient) retourne faux
function erreurNomClient()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client']) && !estValide($_POST['client']))
        echo
        '<div class="alert alert-danger" role="alert">
            <p class="m-0 bold">Erreur :</p>
            <p class="m-0 bold">Le nom est invalide</p>
         </div>';
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Partie conversion

//Convertir les valeurs du format en nom
function format($format)
{
    switch ($format) {
        case 1:
            return "Très petit";
        case 2:
            return "Petit";
        case 3:
            return "Moyen";
        case 4:
            return "Grand";
        case 5:
            return "Très grand";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Partie navigation

//Envoyer à la page de commande (part2.php)
function pageBreuvage($breuvage)
{
    if (isset($breuvage) && estValide($_POST['client'])) {
        header('Location: part2.php');
        exit();
    }
}

//Envoyer au menu (part1.php) ou à la page de confirmation (confirm.php)
function part1OuCommande()
{
    if (isset($_POST['retour'])) {
        header('Location: part1.php');
    }
    if (isset($_POST['confirmer']) && isset($_POST['grain'])) {
        header('Location: confirm.php');
    }

    exit();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Partie maquette

//Déterminer la maquette à utiliser
function maquette()
{
    if (isset($_SESSION['breuvage'])) {
        switch ($_SESSION['breuvage']) {
            case "Café moulu":
                moulu();
                break;
            case "Expresso":
                expressos();
                break;
            case "Cappuccino":
                cappucinos();
                break;
        }
    }
}

//Retourner les sessions des curseurs d’intervalle dans la partie 2
function sessionRange($nom, $breuvage = null)
{
    if ($breuvage !== null) {
        return isset($_SESSION[$breuvage][$nom]) ? $_SESSION[$breuvage][$nom] : 0;
    }

    return isset($_SESSION[$nom]) ? $_SESSION[$nom] : 0;
}

//Retourner les sessions des cases à cocher dans la partie 2
function sessionCheckbox($nom, $breuvage = null)
{
    if ($breuvage !== null) {
        return !empty($_SESSION[$breuvage][$nom]) ? 'checked' : '';
    }

    return !empty($_SESSION[$nom]) ? 'checked' : '';
}

//Retourner les sessions de la liste déroulante dans la partie 2, pour la maquette du cappucinos
function sessionExtra($nom)
{
    if (isset($_SESSION['extra']) && $_SESSION['extra'] == $nom)
        return 'selected';
}

//La maquette du café moulu
function moulu()
{
    echo
    '<fieldset>
        <div class="form-group">
            <label for="inputLait" class="form-label">Laits :</label>
            <div class="d-flex gap-20px">
                <input id="inputLait" type="range" class="custom-range" min="0" max="5" name="laits" value="' . sessionRange("laits") . '">
                <p id="valueLait" class="bg-white rounded rangeValuePart2"></p>
            </div>
        </div>

        <div class="form-group">
            <label for="inputSucres" class="form-label">Sucres :</label>
            <div class="d-flex gap-20px">
                <input id="inputSucres" type="range" class="custom-range" min="0" max="3" name="sucres" value="' . sessionRange('sucres', 'Café moulu') . '">
                <p id="valueSucres" class="bg-white rounded rangeValuePart2"></p>
            </div>
        </div>

        <div class="form-group">
            <label for="inputExpresso" class="form-label">Doses d\'expresso :</label>
            <div class="d-flex gap-20px">
                <input id="inputExpresso" type="range" class="custom-range" min="0" max="3" name="doseExpresso" value="' . sessionRange("doseExpresso") . '">
                <p id="valueExpresso" class="bg-white rounded rangeValuePart2"></p>
            </div>
        </div>
    </fieldset>';
}

//La maquette de l'expressos
function expressos()
{
    echo '<fieldset>
            <div>
                <label for="inputSucres" class="form-label">Sucres :</label>
                <div class="d-flex gap-20px">
                    <input id="inputSucres" type="range" class="custom-range" min="0" max="3" name="sucres" value="' . sessionRange('sucres', 'Expresso') . '">
                    <p id="valueSucres" class="bg-white rounded rangeValuePart2"></p>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <div class="form-group">
                <label class="form-check-label" for="laitMousse">Lait moussé :</label>
                <div>
                    <input class="marginCheck" type="checkbox" value="Lait moussé" name="laitMousse" id="laitMousse" ' . sessionCheckbox('laitMousse', 'Expresso') . '>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <div class="form-group">
                <label for="extra" class="form-label">Extra :</label>
                <select class="form-control text-dark border-0 selectColor" id="extra" name="extra">
                    <option value="Aucun" ' . sessionExtra("Aucun") . '>Aucun </option>
                    <option value="baileys" ' . sessionExtra("baileys") . '>Baileys</option>
                    <option value="tia maria" ' . sessionExtra("tia maria") . '>Tia Maria</option>
                </select>
            </div>
        </fieldset>';
}

//La maquette du cappucinos
function cappucinos()
{
    echo '<fieldset>
            <div>
                <label for="inputSucres" class="form-label">Sucres :</label>
                <div class="d-flex gap-20px">
                    <input id="inputSucres" type="range" class="custom-range" min="0" max="3" name="sucres" value="' . sessionRange('sucres', 'Cappuccino') . '">
                    <p id="valueSucres" class="bg-white rounded rangeValuePart2"></p>
                </div>
            </div>
        </fieldset>

        <fieldset class="d-flex gap-20px">
            <div class="form-group">
                <input class="marginCheck" type="checkbox" value="Cacao" name="cacao" id="Cacao" ' . sessionCheckbox('cacao') . '>
                <label class="form-check-label" for="laitMousse">Cacao</label>
            </div>

            <div class="form-group">
                <input class="marginCheck" type="checkbox" value="Lait moussé" name="laitMousse" id="laitMousse" ' . sessionCheckbox('laitMousse', 'Cappuccino') . '>
                <label class="form-check-label" for="laitMousse">Lait moussé</label>
            </div>
        </fieldset>';
}

//Remplir la page confirm.php
function maquetteConfirm()
{
    if (isset($_SESSION['breuvage'])) {

        switch ($_SESSION['breuvage']) {
            case "Café moulu":
                echo '
                <li>' . $_SESSION['laits'] . ' lait(s)</li>
                <li>' . $_SESSION['Café moulu']['sucres'] . ' sucre(s)</li>
                <li>' . $_SESSION['doseExpresso'] . ' dose(s) d\'expresso(s)</li>';
                break;
            case "Expresso":
                echo '<li>' . $_SESSION['Expresso']['sucres'] . ' sucre(s)</li>';
                if ($_SESSION['extra'] == "Aucun")
                    echo '<li>' . $_SESSION['extra'] . ' extra</li>';
                if ($_SESSION['extra'] != "Aucun")
                    echo '<li>Extra ' . $_SESSION['extra'] . '</li>';
                if (!empty($_SESSION['Expresso']['laitMousse']))
                    echo '<li>' . $_SESSION['Expresso']['laitMousse'] . '</li>';
                break;
            case "Cappuccino":
                echo '<li>' . $_SESSION['Cappuccino']['sucres'] . ' sucre(s)</li>';
                if (!empty($_SESSION['Cappuccino']['laitMousse']))
                    echo '<li>' . $_SESSION['Cappuccino']['laitMousse'] . '</li>';
                if (!empty($_SESSION['cacao']))
                    echo '<li>' . $_SESSION['cacao'] . '</li>';
                break;
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Partie enregistrement

//Enregistre les données de part1.php dans des sessions
function enregisterPart1($breuvage, $format)
{
    $_SESSION['breuvage'] = $breuvage;
    $_SESSION['formatEnNombre'] = $format;
    $_SESSION['format'] = format($format);
}

//Enregistre les données de part2.php dans des sessions
function enregisterPart2()
{
    $_SESSION['grain'] = $_POST['grain'];

    switch ($_SESSION['breuvage']) {
        case "Café moulu":
            $_SESSION['laits'] = $_POST['laits'];
            $_SESSION['doseExpresso'] = $_POST['doseExpresso'];
            $_SESSION["Café moulu"]['sucres'] = $_POST['sucres'];
            $_SESSION["Café moulu"]['grain'] = $_POST['grain'];
            break;
        case "Expresso":
            $_SESSION["Expresso"]['laitMousse'] = $_POST['laitMousse'] ?? "";
            $_SESSION["Expresso"]['sucres'] = $_POST['sucres'];
            $_SESSION["Expresso"]['grain'] = $_POST['grain'];
            $_SESSION['extra'] = $_POST['extra'];
            break;
        case "Cappuccino":
            $_SESSION["Cappuccino"]['laitMousse'] = $_POST['laitMousse'] ?? "";
            $_SESSION["Cappuccino"]['sucres'] = $_POST['sucres'];
            $_SESSION["Cappuccino"]['grain'] = $_POST['grain'];
            $_SESSION['cacao'] = $_POST['cacao'] ?? "";
            break;
    }
}

//Présélectioner le breuvage si il est déjà enregistré dans $_SESSION['breuvage']
function breuvageSelecte($nomBreuvage)
{
    if (isset($_SESSION['breuvage']) && $nomBreuvage ==  $_SESSION['breuvage'])
        echo "selected";
}

//Présélectioner le grain si il est déjà enregistré dans $_SESSION[$breuvage]['grain'] et présélectioner "Robusta" si non
function grainSelectione($breuvage, $grain)
{
    if ((!isset($_SESSION[$breuvage]['grain']) && $grain == "Robusta") || (isset($_SESSION[$breuvage]['grain']) && $grain == $_SESSION[$breuvage]['grain']))
        echo "checked";
}
