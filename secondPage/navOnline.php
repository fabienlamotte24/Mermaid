<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navLg row d-flex justify-content-between">
            <div>
                <a class="navbar-brand" id="logo" href="../../index.php">Mermaid</a>
            </div>
            <div class="linkNavClick">
                <a class="nav-link-dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                    <?php if (isset($_SESSION['profilPicture']) && $_SESSION['profilPicture'] != '') { ?>
                        <img src="../../assets/img/userPictures/avatars/<?= $_SESSION['profilPicture'] ?>" id="icoUser" class="rounded-circle <?= ($checkNotif != 0) ? 'border border-danger shadow bg-danger ' : ' ' ?>" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                        
                    <?php } else { ?>
                        <img src="../../assets/img/icoUser.png" class="rounded-circle <?= ($checkNotif != 0) ? 'border border-danger' : ' ' ?>" id="icoUser" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                    <?php } ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right text-right" id="dropdown" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item listNav" href="profile.php">Mon profil</a>
                    <a class="dropdown-item listNav" href="#">Notifications
                            <?php if($checkNotif == 0){ ?>
                            <span class="badge badge-light"><?=$checkNotif?></span>
                            <?php } else { ?>
                            <span class="badge badge-danger"><?=$checkNotif?></span>
                            <?php } ?>
                    </a>
                    <a class="dropdown-item listNav" href="#">Consulter la carte</a>
                    <a class="dropdown-item listNav" href="#">Mes messages</a>
                    <a class="dropdown-item listNav" href="#">Présentation du site</a>
                    <a class="dropdown-item listNav" href="options.php">Options de compte</a>
                    <a class="dropdown-item listNav" href="discover.php">Découvrir des groupes</a>
                    <?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 3) { ?>
                        <a class="dropdown-item listNav" href="#">Mes contrats</a>
                        <a class="dropdown-item listNav" href="myBand.php">Mon groupe</a>
                    <?php } ?>
                    <?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 2) { ?>
                        <a class="dropdown-item listNav" href="#">Mes contrats</a>
                        <a class="dropdown-item listNav" href="myCompany.php">Mon entreprise</a>
                    <?php } ?>
                    <a class="dropdown-item listNav" href="<?= $_SERVER['PHP_SELF'] ?>?action=disconnect">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
</nav>