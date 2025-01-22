<?php
include './header.php';
?>

<main>
<section>
    <h1 style="color: white;">Votre Commande</h1>
    <table style="color: white;">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <!-- Exemple de produit -->
            <tr>
                <td>Nom du produit 1</td>
                <td>10.00 €</td>
            </tr>
            <!-- Ajoutez d'autres produits ici -->
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>----</td>
            </tr>
        </tfoot>
    </table>
    <button style="color: black;">Détails</button>
</section>

<section style="color: white;">
    <article>
        <label for="nom">NOM</label>
        <input id="nom" type="text">
    </article>

    <article>
        <label for="prenom">PRÉNOM</label>
        <input id="prenom" type="text">
    </article>

    <article>
        <label for="email">EMAIL</label>
        <input id="email" type="text">
    </article>

    <article>
        <label for="tel">TÉLÉPHONE</label>
        <input id="tel" type="text">
    </article>
</section>


    <section>

        <label for="adresse">VOTRE ADRESSE</label>
        <input id="adresse" type="text">

    </section>

    <button type="submit">ENVOYER</button>

    </section>
</main>

<?php
include './footer.php';
?>