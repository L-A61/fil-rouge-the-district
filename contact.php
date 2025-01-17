<?php    
include './header.php';
echo "Ceci est la page contact!";
?>

<main>
    <section>
        
        <h1>Nous Contacter</h1>

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
        <label for="demande">VOTRE DEMANDE</label>
        <input id="demande" type="text">
    </section>

    <button type="submit">ENVOYER</button>

</main>

<?php  
include './footer.php';
?>