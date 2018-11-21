<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navLg row d-flex justify-content-between">
            <div>
                <a class="navbar-brand" id="logo" href="profile.php">Mermaid</a>
            </div>
            <div class="linkNavClick h-100">
                <a class="nav-link-dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                    <?php if (isset($_SESSION['profilPicture']) && $_SESSION['profilPicture'] != ' ') { ?>
                        <img src="../../assets/img/userPictures/avatars/<?= $_SESSION['profilPicture'] ?>" id="icoUser" class="rounded-circle <?= ($checkNotif != 0) ? 'border border-danger shadow bg-danger ' : ' ' ?>" width="70" height="70" alt="Photo de profil" title="Photo de profil" />

                    <?php } else { ?>
                        <img src="../../assets/img/icoUser.png" class="rounded-circle <?= ($checkNotif != 0) ? 'border border-danger' : ' ' ?>" id="icoUser" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                    <?php } ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right text-right" id="dropdown" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item listNav" href="#" data-toggle="modal" data-target="#showNotif">Notifications
                        <?php if ($checkNotif == 0) { ?>
                            <span class="badge badge-light"><?= $checkNotif ?></span>
                        <?php } else { ?>
                            <span class="badge badge-danger"><?= $checkNotif ?></span>
                        <?php } ?>
                    </a>
                    <a class="dropdown-item listNav" href="messages.php">Mes messages</a>
                    <a class="dropdown-item listNav" href="<?= $_SERVER['PHP_SELF'] ?>?action=disconnect">Déconnexion</a>
                </div>
            </div>
        </div>
    </div><div class="modal fade" id="showNotif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="titleNavModal">Voici la liste de vos notifications</h1>
                </div>
                <div class="modal-body text-center">
                    <?php
                    foreach ($myNotifs as $notif) {
                        if ($checkNotif == 0) { ?>
                            <div id="zeroNotif">
                                <p>Aucune notification</p>
                            </div>
                        <?php } else { ?>
                            <div id="backgroundNotif" id="notifLink" class="removeNotif" idNotif="<?= $notif->id ?>" idMessage="<?= $notif->idMessages ?>">
                                <p><?= $notif->notifDescription ?></p>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</nav>