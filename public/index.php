<?php $title = "Connexion au site"; ?>

<?php ob_start(); ?>
    <header>
        <h1>Bienvenue sur mon blog !</h1>
        <form action="../src/View/postsview.php" method="post">
            <label for="login">Veuillez choisir un nom d'utilisateur :</label>
            <input type="password" id="login" name="login">
            <input type="submit" value="Valider">
        </form>
    </header>
<?php $content = ob_get_clean(); ?>

<?php require('../src/View/template.php');
