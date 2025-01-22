<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=thedistrict', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE utilisateur SET type_ID = 1 WHERE utlisateur_email = 'lylia.star@gmail.com'");
    $stmt->execute();

    echo "Type d'utilisateur modifié avec succès!";

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>