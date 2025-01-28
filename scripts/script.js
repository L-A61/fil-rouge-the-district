// pour ajouter un produit au panier en utilisant fetch API
function ajouterAuPanier(productData) {
    fetch('ajouter_au_panier.php', {
        method: 'POST',
        body: JSON.stringify(productData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour le contenu de l'offcanvas
        document.querySelector('.offcanvas-body').innerHTML = data.panierHtml;
        // Mettre à jour le compteur dans le bouton
        document.querySelector('.position1').innerHTML = `Mon Panier (${data.nombreItems})`;
    });
}