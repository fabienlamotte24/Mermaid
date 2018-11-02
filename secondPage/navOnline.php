<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navLg row d-flex justify-content-between">
            <div>
                <a class="navbar-brand" id="logo" href="../../index.php">Mermaid</a>
            </div>
            <div class="linkNavClick">
                <a class="nav-link-dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                    <img src="../../assets/img/icoUser.png" id="icoUser" alt="photo de profil" title="photo de profil" />
                </a>
                <div class="dropdown-menu dropdown-menu-right text-right" id="dropdown" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item listNav" href="profile.php">Mon profil</a>
                    <a class="dropdown-item listNav" href="#">Consulter la carte</a>
                    <a class="dropdown-item listNav" href="#">Présentation du site</a>
                    <a class="dropdown-item listNav" href="options.php">Options de compte</a>
                    <a class="dropdown-item listNav" href="#">Découvrir des groupes</a>
                    <?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 3) { ?>
                        <a class="dropdown-item listNav" href="#">Mes contrats</a>
                        <a class="dropdown-item listNav" href="myBand.php">Mon groupe</a>
                    <?php } ?>
                    <?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 2) { ?>
                        <a class="dropdown-item listNav" href="#">Mes contrats</a>
                    <?php } ?>
                    <a class="dropdown-item listNav" href="<?= $_SERVER['PHP_SELF'] ?>?action=disconnect">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
</nav>