<?php    
include './header.php';
?>

<main>
    <section>

        <h1>Votre Commande</h1>

        <section>
            
            <img src="" alt="Photo Commande">
            <section>
                <article>Nom du produit 1</article>
                <article>Lorem ipsum dolor sit amet consectetur...</article>
            </section>
            <label for="total">TOTAL: </label>
            <article id="total">----</article>
            <button>Détails</button>   

        </section>
        
        <section>

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
include 'footer.php';
?>