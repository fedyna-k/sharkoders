<h1>Connexion</h1>

<form action="public_backend/account_action" method="POST">
    <input type="hidden" name="type" value="login" />

    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" placeholder="mail@exemple.fr" required />

    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" required />

    <?php

    // Think about bad logins
    
    if (isset($_SESSION["bad-login"])){
        echo "<p style='color: red'>Mauvais e-mail ou mot de passe.</p>";
        unset($_SESSION["bad-login"]);
    }

    ?>

    <div id="submit-div">
        <input type="submit" value="Connexion" />
    </div>
</form>

<p><em>Vous n'avez pas de compte ? <a href="?register">Creer un compte</a>.</em></p>