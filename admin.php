<?php
session_start();

// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['type_utilisateur']) || $_SESSION['type_utilisateur'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'thedistrict';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Supprimer un utilisateur
if (isset($_POST['supprimer_utilisateur'])) {
    $utilisateur_ID = $_POST['utilisateur_ID'];
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE utilisateur_ID = ?");
    $stmt->execute([$utilisateur_ID]);
    header('Location: admin.php');
    exit();
}

// Récupérer la liste des utilisateurs
$utilisateurs = $pdo->query("SELECT * FROM utilisateur")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h1>Gestion des Utilisateurs</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?= htmlspecialchars($utilisateur['utilisateur_ID']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['utilisateur_email']) ?></td>
                        <td>
                            <form method="post" action="admin.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                <input type="hidden" name="utilisateur_ID" value="<?= $utilisateur['utilisateur_ID'] ?>">
                                <button type="submit" name="supprimer_utilisateur" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container my-5">
        <h1>Gestion des Codes Promo</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#codePromoModal">Ajouter un Code Promo</button>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Réduction (%)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($codes_promo as $code_promo): ?>
                    <tr>
                        <td><?= htmlspecialchars($code_promo['code_promo_id']) ?></td>
                        <td><?= htmlspecialchars($code_promo['code']) ?></td>
                        <td><?= htmlspecialchars($code_promo['date_debut']) ?></td>
                        <td><?= htmlspecialchars($code_promo['date_fin']) ?></td>
                        <td><?= htmlspecialchars($code_promo['reduction']) ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#codePromoModal" data-id="<?= $code_promo['code_promo_id'] ?>" data-code="<?= $code_promo['code'] ?>" data-date_debut="<?= $code_promo['date_debut'] ?>" data-date_fin="<?= $code_promo['date_fin'] ?>" data-reduction="<?= $code_promo['reduction'] ?>">Modifier</button>
                            <form method="post" action="admin.php" style="display:inline;">
                                <input type="hidden" name="code_promo_id" value="<?= $code_promo['code_promo_id'] ?>">
                                <button type="submit" name="supprimer_code_promo" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal pour ajouter/modifier un code promo -->
    <div class="modal fade" id="codePromoModal" tabindex="-1" aria-labelledby="codePromoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="codePromoModalLabel">Ajouter un Code Promo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php">
                        <input type="hidden" name="code_promo_id" id="code_promo_id">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code Promo</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de Début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut">
                        </div>
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de Fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin">
                        </div>
                        <div class="mb-3">
                            <label for="reduction" class="form-label">Réduction (%)</label>
                            <input type="number" class="form-control" id="reduction" name="reduction" step="0.01" required>
                        </div>
                        <button type="submit" name="action" id="action" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var codePromoModal = document.getElementById('codePromoModal');
        codePromoModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var code_promo_id = button.getAttribute('data-id');
            var code = button.getAttribute('data-code');
            var date_debut = button.getAttribute('data-date_debut');
            var date_fin = button.getAttribute('data-date_fin');
            var reduction = button.getAttribute('data-reduction');

            var modalTitle = codePromoModal.querySelector('.modal-title');
            var actionButton = codePromoModal.querySelector('#action');
            var codePromoIdInput = codePromoModal.querySelector('#code_promo_id');
            var codeInput = codePromoModal.querySelector('#code');
            var dateDebutInput = codePromoModal.querySelector('#date_debut');
            var dateFinInput = codePromoModal.querySelector('#date_fin');
            var reductionInput = codePromoModal.querySelector('#reduction');

            if (code_promo_id) {
                modalTitle.textContent = 'Modifier le Code Promo';
                actionButton.textContent = 'Modifier';
                actionButton.name = 'action';
                actionButton.value = 'modifier';
                codePromoIdInput.value = code_promo_id;
                codeInput.value = code;
                dateDebutInput.value = date_debut;
                dateFinInput.value = date_fin;
                reductionInput.value = reduction;
            } else {
                modalTitle.textContent = 'Ajouter un Code Promo';
                actionButton.textContent = 'Ajouter';
                actionButton.name = 'action';
                actionButton.value = 'ajouter';
                codePromoIdInput.value = '';
                codeInput.value = '';
                dateDebutInput.value = '';
                dateFinInput.value = '';
                reductionInput.value = '';
            }
        });
    </script>
</body>

</html>