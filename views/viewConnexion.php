<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="./views/styles/styles.css">
</head>
<body>
    <main>
        <!-- MESSAGE D'ERREUR / SUCCES -->
        <span class="msg"><?= isset($message) ? $message : '' ?></span>
        <!-- CONNEXION -->
        <div class="login">
            <form action="http://localhost/backend/index.php?url=login" method="post" class="form container">
                <div class="field">
                    <label class="label">Adresse e-mail ou mobile </label>
                    <input name="email" value="<?= isset($login->email) ? $login->email : '' ?>" class="input" type="text" placeholder="Votre login" />
                </div>
                <div class="field">
                    <label class="label">Mot de passe</label>
                    <input name="password" value="<?= isset($login->password) ? $login->password : '' ?>" class="input" type="text" placeholder="Votre mot de passe" />
                    <button class="forgot_password">Mot de passe oubliées ?</button>
                </div>
                <div class="field">
                    <div></div>
                    <button type="submit" class="btn">Connexion</button>
                    <div></div>
                </div>
            </form>
        </div>
        <!-- INSCRIPTION -->
        <div class="register container">
            <div class="head__section">
                <h2 class="title">Inscription</h2>
                <h3 class="subtitle">C'est gratuit (et ça le restera toujours)</h3>
            </div>
            <form action="http://localhost/backend/index.php?url=register" method="post" class="form">
                <div class="field">
                    <div class="field__name">
                        <input name="firstname" value="<?= isset($register->firstname) ? $register->firstname : '' ?>" type="text" placeholder="Prénom" class="input" />
                        <input name="lastname" value="<?= isset($register->lastname) ? $register->lastname : '' ?>" type="text" placeholder="Nom de famille" class="input" />
                    </div>
                </div>
                <div class="field">
                    <input name="email" value="<?= isset($register->email) ? $register->email : '' ?>" type="text" placeholder="Numéro de mobile ou email" class="input" />
                </div>
                <div class="field">
                    <input name="email_check" value="<?= isset($register->email_check) ? $register->email_check : '' ?>" type="text" placeholder="Confirmer numéro de mobile ou email" class="input" />
                </div>
                <div class="field">
                    <input name="password" value="<?= isset($register->password) ? $register->password : '' ?>" type="text" placeholder="Nouveau mot de passe" class="input" />
                </div>
                <div class="field">
                    <label class="label">Date de naissance</label>
                    <input name="birthdate" value="<?= isset($register->birthdate) ? $register->birthdate : '' ?>" type="date" class="input" />
                    <!-- <span class="label">Pourquoi indiquer ma date de naissance ?</span> -->
                </div>
                <div class="field">
                    <div class="gender_section">
                        <input type="radio" name="gender" value="2" class="gender" />Femme
                        <input type="radio" name="gender" value="1" class="gender" />Homme
                    </div>
                </div>
                <p class="cgu">
                    En cliquant sur Inscription, vous acceptez nos <a href="#">Conditions</a> et indiquez que vous avez lu notre <a href="#">Politique d'utilisation des données</a>, y compris notre <a href="#">Utilisation des cookies</a>. Vous pourrez recevoir des notifications par texto de la part de Facebook et pourrez vous désabonner à tout moment.
                </p>
                <div class="field">
                    <button type="submit" class="btn">Inscription</button>
                </div>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="./views/js/main.js"></script>
</body>
</html>