<?php
session_start();
$tabFormat = array("Très petit", "Petit", "Moyen", "Grand", "Très grand");

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
    $tabRange = array(
        array(
            "inputId" => "inputLait",
            "valueId" => "valueLait",
            "label" => "Laits",
            "max" => "5",
            "name" => "laits"
        ),
        array(
            "inputId" => "inputSucres",
            "valueId" => "valueSucres",
            "label" => "Sucres",
            "max" => "3",
            "name" => "sucres"
        ),
        array(
            "inputId" => "inputExpresso",
            "valueId" => "valueExpresso",
            "label" => "Doses d'expresso",
            "max" => "3",
            "name" => "doseExpresso"
        )
    );

    echo '<fieldset>';
    foreach ($tabRange as $array) {
        echo
        '<div class="form-group">
            <label for="' . $array["inputId"] . '" class="form-label">' . $array["label"] . ' :</label>
            <div class="d-flex gap-20px">
                <input id="' . $array["inputId"] . '" type="range" class="custom-range" min="0" max="' . $array["max"] . '" name="' . $array["name"] . '" value="' . ($array["name"] == "sucres" ? sessionRange($array["name"], 'Café moulu') : sessionRange($array["name"])) . '">
                <p id="' . $array["valueId"] . '" class="bg-white rounded rangeValuePart2"></p>
            </div>
        </div>';
    }
    echo '</fieldset>';
}

//La maquette de l'expressos
function expressos()
{
    $tableauExtra = array("Aucun", "baileys", "tia maria");

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
                <select class="form-control text-dark border-0 selectColor" id="extra" name="extra">';

    for ($i = 0; $i < sizeof($tableauExtra); $i++) {
        echo '<option value="' . $tableauExtra[$i] . '" ' . sessionExtra($tableauExtra[$i]) . '>' . ucwords($tableauExtra[$i]) . '</option>';
    }

    echo '      </select>
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

function ecrireFormat()
{
    global $tabFormat;

    for ($i = 0; $i < sizeof($tabFormat); $i++) {
        echo '<span>' . $tabFormat[$i] . '</span>';
    }
}

// Écrire les options de breuvage dans part1.php
function ecrireOptionsDeBreuvage()
{
    $tabBreuvage = array("Café moulu", "Expresso", "Cappuccino");

    for ($i = 0; $i < sizeof($tabBreuvage); $i++) {
        echo '<option ' . breuvageSelecte($tabBreuvage[$i], "breuvage") . ' value="' . $tabBreuvage[$i] . '">' . $tabBreuvage[$i] . '</option>';
    }
}

// Écrire les types de grain dans part2.php
function ecrireTypeDeGrain()
{
    $tabGrain = array(
        array(
            "name" => "arabica",
            "image" => "img/arabica.webp"
        ),
        array(
            "name" => "robusta",
            "image" => "img/robusta.webp"
        ),
        array(
            "name" => "kopi luwak",
            "image" => "img/kopi-luwak.webp"
        )
    );

    foreach ($tabGrain as $array) {
        echo '
            <div class="col-12 col-md-4 d-flex flex-column align-items-center mb-4">
                <img class="imageGrain mb-2" src="' . $array["image"] . '" alt="' . $array["name"] . '">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="grain" id="' . $array["name"] . '" value="' . ucwords($array["name"]) . '" 
                        ' . grainSelectione($_SESSION['breuvage'], ucwords($array["name"])) . '>
                    <label class="form-check-label" for="' . $array["name"] . '">' . ucwords($array["name"]) . '</label>
                </div>
             </div>';
    }
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
    global $tabFormat;

    $_SESSION['breuvage'] = $breuvage;
    $_SESSION['formatEnNombre'] = $format;
    $_SESSION['format'] = $tabFormat[$format - 1];
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
        return "selected";

    return "";
}

//Présélectioner le grain si il est déjà enregistré dans $_SESSION[$breuvage]['grain'] et présélectioner "Robusta" si non
function grainSelectione($breuvage, $grain)
{
    if ((!isset($_SESSION[$breuvage]['grain']) && $grain == "Robusta") || (isset($_SESSION[$breuvage]['grain']) && $grain == $_SESSION[$breuvage]['grain']))
        return "checked";

    return "";
}
