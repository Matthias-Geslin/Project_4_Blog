<?php $title = "Mon blog"; ?>

<?php ob_start(); ?>
    <!--Checking in the login info -->
<?php
if (isset($_POST['login']) AND $_POST['login'] ==  "test") // If the login info are good
{
    // On affiche les codes
    ?>
    <section>
        <h1>Voici les derniers billets du blog :</h1>

    </section>
    <?php
}
else // Else we send an error
{
    echo '<p>Mot de passe incorrect</p>';
}
?>


<?php $content = ob_get_clean(); ?>

<?php require('template.php');
