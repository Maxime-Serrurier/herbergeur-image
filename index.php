<?php
    // L'image a t'elle été envoyée et sans erreur ?
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        // l'image est elle trop lourde ?
        if($_FILES['image']['size'] <= 3_000_000) {

            // On récupère les informations de l'image.
            $informationsImage = pathinfo($_FILES['image']['name']);
            $extensionImage = $informationsImage['extension'];
            $extensionsArray = ['gif', 'jpeg', 'png', 'jpg', 'svg'];

            if(in_array($extensionImage, $extensionsArray)) {

                // On déplace le fichier en le renommant à la seconde près et avec l'extension.
                $newImageName = time().rand().rand() . '.' . $extensionImage;
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $newImageName);

                // Variable qui vérifie si l'image a été envoyée.
                $send = true;
            }
        }
    }

?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/default.css">
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <title>ShareFiles - Hébergez gratuitement vos images et en illimité</title>
    </head>
    <body>

        <header>
            <a href="../">
                <span>ShareFiles</span>
            </a>
        </header>

        <section>
            <h1>
                <?php 

                    // Condition si l'image existe ou pas.
                    if(isset($send) && $send) {
                        // On affiche l'image.
                        echo '<img src="uploads/' . $newImageName . '" alt="SharedFile" style="max-width: 75%">';
                    }
                    else {
                        // On affiche le logo par défaut.
                        echo '<i class="fas fa-paper-plane"></i>';
                    }
                ?>
            </h1>

            <!--Si l'image est envoyée on affiche le lien de l'image et succès  -->
            <?php if(isset($send) && $send) { ?>

              <h2>Fichier envoyé avec succès !</h2> 
              <p>Retrouvez ci-dessous le lien vers votre fichier :</p> 
              <input type="text" id="link" value="http://localhost/uploads/<?= $newImageName ?>" readonly>

            <?php } else { ?>

                <!-- Sinon on affiche le formulaire -->
                <form method="post" action="index.php" enctype="multipart/form-data">
                    <p>
                        <label for="image">Sélectionnez votre fichier</label><br>
                        <input type="file" name="image" id="image">
                    </p>
                    <p id="send">
                        <button type="submit">Envoyer <i class="fas fa-long-arrow-alt-right"></i></button>
                    </p>
                </form>

            <?php } ?>

            
        </section>
        
    </body>
</html>


