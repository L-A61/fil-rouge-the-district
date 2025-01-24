<?php    
include './header.php';
echo "Ceci est la page contact!";
?>

<main>
    <section>
        
        <h1>Nous Contacter</h1>

        <article>
            <label for="nom">Nom:</label>
            <input id="nom" type="text">
        </article>

        <article>
            <label for="prenom">Prénom:</label>
            <input id="prenom" type="text">
        </article>

        <article>
            <label for="email">Email:</label>
            <input id="email" type="text">
        </article>

        <article>
            <label for="tel">Téléphone:</label>
            <input id="tel" type="text">
        </article>

    </section>

    <section>
        <label for="demande">Votre demande:</label>
        <input id="demande" type="text">
    </section>

    <button type="submit">ENVOYER</button>

</main>

<?php  
include './footer.php';
?>