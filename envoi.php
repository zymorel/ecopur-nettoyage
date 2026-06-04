<?php
/**
 * Traitement du formulaire de devis ECOPUR Nettoyage.
 * Envoie la demande à contact@ecopurnettoyage.com via la fonction mail() de l'hébergement (Hostinger).
 *
 * - Réponse JSON si la requête est en AJAX (fetch).
 * - Sinon, redirection vers contact.html?envoi=ok (ou =erreur) pour les navigateurs sans JS.
 */

$destinataire = 'contact@ecopurnettoyage.com';

// Adresse expéditrice sur le domaine (recommandé pour la délivrabilité Hostinger).
$expediteur   = 'contact@ecopurnettoyage.com';

// Détection d'une requête AJAX.
$estAjax = (
    (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)
);

function repondre($ok, $message, $estAjax) {
    if ($estAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($ok ? 200 : 400);
        echo json_encode(['ok' => $ok, 'message' => $message]);
    } else {
        $statut = $ok ? 'ok' : 'erreur';
        header('Location: /contact?envoi=' . $statut . '#devis');
    }
    exit;
}

// Seules les requêtes POST sont acceptées.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    repondre(false, 'Méthode non autorisée.', $estAjax);
}

// Piège anti-spam : un robot remplira ce champ caché, pas un humain.
if (!empty($_POST['site_web'])) {
    // On simule un succès pour ne pas renseigner le robot.
    repondre(true, 'Merci, votre demande a bien été envoyée.', $estAjax);
}

// Nettoyage des entrées.
function champ($cle) {
    return isset($_POST[$cle]) ? trim($_POST[$cle]) : '';
}

$nom     = champ('nom');
$societe = champ('societe');
$email   = champ('email');
$tel     = champ('tel');
$presta  = champ('presta');
$ville   = champ('ville');
$message = champ('message');

// Validation minimale (le nom, l'e-mail et le message sont requis).
$erreurs = [];
if ($nom === '')                                  { $erreurs[] = 'le nom'; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL))   { $erreurs[] = 'un e-mail valide'; }
if ($message === '')                              { $erreurs[] = 'votre demande'; }

if ($erreurs) {
    repondre(false, 'Merci d\'indiquer ' . implode(', ', $erreurs) . '.', $estAjax);
}

// Empêche l'injection d'en-têtes via les champs réinjectés dans le mail.
function sansSautDeLigne($v) {
    return str_replace(["\r", "\n", "%0a", "%0d"], ' ', $v);
}

$sujet = 'Demande de devis' . ($presta !== '' ? ' (' . sansSautDeLigne($presta) . ')' : '');

$corps  = "Nouvelle demande depuis le site ecopurnettoyage.com\n";
$corps .= "----------------------------------------------------\n\n";
$corps .= 'Nom : ' . $nom . "\n";
$corps .= 'Société / copropriété : ' . ($societe !== '' ? $societe : '—') . "\n";
$corps .= 'E-mail : ' . $email . "\n";
$corps .= 'Téléphone : ' . ($tel !== '' ? $tel : '—') . "\n";
$corps .= 'Prestation : ' . ($presta !== '' ? $presta : '—') . "\n";
$corps .= 'Ville du site : ' . ($ville !== '' ? $ville : '—') . "\n\n";
$corps .= "Demande :\n" . $message . "\n";

$entetes  = 'From: Site ECOPUR <' . $expediteur . ">\r\n";
$entetes .= 'Reply-To: ' . sansSautDeLigne($nom) . ' <' . sansSautDeLigne($email) . ">\r\n";
$entetes .= "Content-Type: text/plain; charset=utf-8\r\n";

$envoye = @mail(
    $destinataire,
    '=?UTF-8?B?' . base64_encode($sujet) . '?=',
    $corps,
    $entetes
);

if ($envoye) {
    repondre(true, 'Merci, votre demande a bien été envoyée. Nous revenons vers vous rapidement.', $estAjax);
} else {
    repondre(false, 'L\'envoi a échoué. Écrivez-nous directement à contact@ecopurnettoyage.com ou appelez le 06 66 30 24 43.', $estAjax);
}
