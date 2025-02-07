
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionne tous les boutons favoris
    document.querySelectorAll(".btn-favori").forEach(button => {
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
                    if (data.action === "added") {
                        this.classList.remove("btn-danger");
                        this.classList.add("btn-success");
                        this.textContent = "♥ Favori";
                    } else {
                        this.classList.remove("btn-success");
                        this.classList.add("btn-danger");
                        this.textContent = "♡";
                    }
                } else {
                    alert("Erreur : " + data.message);
                }
            })
            .catch(error => console.error("Erreur AJAX :", error));
        });
    });
});

