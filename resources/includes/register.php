<h1>Inscription</h1>

<form action="public_backend/account_action" method="post">
    <input type="hidden" name="type" value="register">

    <label for="firstname">Prénom</label>
    <input type="text" name="firstname" id="firstname" placeholder="Jean" required>

    <label for="lastname">Nom</label>
    <input type="text" name="lastname" id="lastname" placeholder="Dupond" required>

    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" placeholder="mail@exemple.fr" required>

    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" placeholder="•••••••••" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>

    <label for="password_confirm">Confirmer le mot de passe</label>
    <input type="password" name="password_confirm" id="password_confirm" placeholder="•••••••••" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>

    <p>Pour des raisons de sécurité, votre mot de passe doit contenir :</p>
    <ul>
        <li>Une minuscule</li>
        <li>Une majuscule</li>
        <li>Un caractère spécial</li>
        <li>8 caractères minimum</li>
    </ul>

    <label for="captcha">Sécurité</label>
    <div id="captcha-div">
        <input type="text" name="captcha" id="captcha" placeholder="Entrez le texte suivant" required>
        <input type="hidden" name="captcha_string" id="captcha_string">
        <canvas id="captcha-image"></canvas>
    </div>

    <?php

    // Think about bad captcha
    
    if (isset($_SESSION["bad-captcha"])){
        echo "<p style='color: red'>Mauvais captcha.</p>";
        unset($_SESSION["bad-captcha"]);
    }

    if (isset($_SESSION["already"])){
        echo "<p style='color: red'>Email déjà utilisé.</p>";
        unset($_SESSION["already"]);
    }

    ?>

    <div id="submit-div">
        <input type="submit" value="S'inscrire" disabled>
    </div>
</form>

<script src="resources/scripts/register.js"></script>

<p><em>Vous avez un compte ? <a href="espace">Connexion</a>.</em></p>