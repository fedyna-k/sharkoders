<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Meta of the website -->
        <?php include("resources/includes/meta.php"); ?>
        <!-- -->

        <link rel="stylesheet" href="resources/stylesheets/main.css">
        <link rel="stylesheet" href="resources/stylesheets/complement.css">

        <link rel="shortcut icon" href="resources/images/icon.svg" type="image/x-icon">

        <title>Sharkoders</title>
    </head>

    <body>
        <!-- Header -->
        <?php include("resources/includes/header.php"); ?>
        <!-- -->
        
        <section>
            <h1>Conditions d'utilisation<h1>

            <h2>Conditions relatives aux comptes</h2>

            <h3>Nombre de comptes</h3>

            <p>
                L'utilisateur est limité à un seul compte.
                Afin de pouvoir appliquer cette limite, nous recueuillons un email à la création du compte.
            </p>

            <h3>Badge Polytech Marseille</h3>

            <p>
                L'accès aux Challenges des Sharkoders est tout public.
                Pour bénéficier d'un badge Polytech Marseille, il faut être inscrit dans l'école, c'est alors le Webmaster qui se charge de donner le badge sur le site. 
            </p>

            <h3>Utilisation des données</h3>

            <p>Les données ne seront pas utilisée à des fins de promotion ou commerciales.</p>
            <p>Liste de l'utilisation des données :</p>
            <ul>
                <li>Nom, prénom : <em>Poly'derboard, personnalisation du site</em></li>
                <li>Email : <em>Modération, inscription aux évènements, connexion</em></li>
            </ul>

            <h2>Conditions relatives aux Challenges</h2>

            <h3>Nombre d'essais</h3>

            <p>
                Chaque utilisateur ne dispose que d'un essai, c'est-à-dire un seul temps entre l'ouverture du challenge, et l'envoi d'une bonne réponse.<br>
                Il n'est pas possible d'améliorer son temps puisque l'énoncé n'est pas modifié entre temps.
            </p>

            <h3>Poly'derboard</h3>

            <p>En participant, l'utilisateur accepte que son nom soit affiché sur le "Poly'derboard" avec le temps qu'il a mis pour résoudre le challenge.</p>

            <h3>Evènements</h3>

            <p>
                La liste des participants aux évènements divers évènements est prédéfinie par les gestionnaires du club.
                Pour participer, il faut donc voir avec la communication pour s'inscrire (extérieur au site).
            </p>

            <h2>Conditions relatives à la modération</h2>

            <p>
                La modération se réserve le droit de supprimer un compte ou une performance sur un challenge. <br>
                <em>N.B. : Chaque suppression sera suivi d'un mail expliquant la raison de cette dernière.</em>
            </p>
        </section>

        <!-- Footer -->
        <?php include("resources/includes/footer.php"); ?>
        <!-- -->
    </body>
</html>