<nav class="navbar navbar-expand-md bg-dark justify-content-center navbar-dark fixed-top">
    <a class="navbar-brand" href="../../index.php" id="logo">Mermaid</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center " id="collapsibleNavbar">
        <!--Formulaire dédié à la connexion de l'utilisateur-->
        <form id="connectForm" method="POST" action="traitement.php">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!--Section d'Identifiant de l'utilisateur-->
                    <div id="user">
                        <img src="../../assets/img/icoUser.png" id="icoUser" title="icone identifiant" alt="icone identifiant" />
                        <input type="text" name="pseudo" id="pseudo" placeholder="Identifiant" maxlength="15" size="15" style="border: hidden; border: 0" />
                        <abbr><a href="../../forget.php?forget=login" class="forgot">Oublié ?</a></abbr>
                    </div>
                    <?php (isset($errorList['pseudo'])) ? $errorList['pseudo'] : '';?>
                </li>
                <li class="nav-item">
                    <!--Section de Mot de passe de l'utilisateur-->
                    <div id="Pass">
                        <img src="../../assets/img/icoPass.png" id="icoPass" title="icone Mot de passe" alt="icone Mot de passe" />
                        <input type="password" name="pass" id="pass" placeholder="Mot de passe" maxlength="15" size="15" style="border: hidden; border: 0" />
                        <abbr><a href="../../forget.php?forget=pass" class="forgot">Oublié ?</a></abbr>
                    </div>
                    <?php (isset($errorList['password'])) ? $errorList['password'] : '';?>
                </li>
                <li class="nav-item">
                    <!--Section de Validation d'entrée de login et de mot de passe pour accéder au site-->
                    <div id="connexion">
                        <input type="submit" name="connexion" value="connexion" />
                    </div>
                </li>    
            </ul>
        </form>
    </div>  
</nav>