<?php
// verifie si il a des informations dans la table client
function clientHasInfo($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM client WHERE utilisateur_ID = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() > 0;
}
?>