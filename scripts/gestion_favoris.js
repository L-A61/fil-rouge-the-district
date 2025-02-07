document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-remove-favori").forEach(button => {
        button.addEventListener("click", function () {
            let produitID = this.getAttribute("data-produit-id");

            fetch("ajout_favoris.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "produit_id=" + produitID
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Produit retiré des favoris !");
                    location.reload(); // Recharge la page pour mettre à jour la liste
                } else {
                    alert("Erreur : " + data.message);
                }
            })
            .catch(error => console.error("Erreur AJAX :", error));
        });
    });
});
