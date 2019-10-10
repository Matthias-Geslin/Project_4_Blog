<?php $title = "Mon blog"; ?>


<?php
// BDD connect
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

?>

<?php ob_start(); ?>
    <!--Checking in the login info -->
<?php
if (isset($_POST['login']) AND $_POST['login'] ==  "test") // If the login info are good
{
    // Display of the content
    ?>

    <?php
    // Get back the lasts posts
    $req = $bdd->query('SELECT id, title, content AS date_creation_fr FROM posts ORDER BY creation_date');

    while ($data = $req->fetch())
    {
        ?>
        <section>
            <h1>Voici les derniers billets à jour :</h1>
            <h3>
                <?php echo htmlspecialchars($data['title']); ?>
                <em>le <?php echo $data['date_creation_fr']; ?></em>
            </h3>

            <p>
                <?php
                // On affiche le contenu du billet
                echo nl2br(htmlspecialchars($data['content']));
                ?>
                <br />
                <em><a href="commentaires.php?billet=<?php echo $data['id']; ?>">Commentaires</a></em>
            </p>
        </section>
        <?php
    } // end of the posts loop
    $req->closeCursor();
}
else // Else we send an error
{
    echo '<p>Mot de passe incorrect</p>';
}
?>


<?php $content = ob_get_clean(); ?>

<?php require('template.php');
