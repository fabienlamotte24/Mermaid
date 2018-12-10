<!--Barre de navigation-->
<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <h1 class="navbar-brand mt-2" id="logo">Mermaid</h1>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav text-center">
            <li class="nav-item">
                <a class="nav-link" href="profile.php" id="<?= (basename($_SERVER['PHP_SELF']) === 'profile.php') ? 'focus' : '' ?>">Mon profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="options.php" id="<?= (basename($_SERVER['PHP_SELF']) === 'options.php') ? 'focus' : '' ?>">Mes options</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="messages.php" id="<?= (basename($_SERVER['PHP_SELF']) === 'messages.php') ? 'focus' : '' ?>">Mes messages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php" data-toggle="modal" data-target="#showNotif">Notifications
                    <?php if ($checkNotif == 0) { ?>
                        <span class="badge badge-light"><?= $checkNotif ?></span>
                    <?php } else { ?>
                        <span class="badge badge-danger"><?= $checkNotif ?></span>
                    <?php } ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $_SERVER['PHP_SELF'] ?>?action=disconnect">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<!--Fenêtre modale affichant les notifications-->
<div class="modal fade" id="showNotif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 id="titleNavModal">Voici la liste de vos notifications</h1>
            </div>
            <div class="modal-body text-center">
                <?php
                foreach ($myNotifs as $notif) {
                    if ($checkNotif == 0) {
                        ?>
                        <div id="zeroNotif">
                            <p>Aucune notification</p>
                        </div>
                    <?php } else { ?>
                        <div id="backgroundNotif" id="notifLink" class="removeNotif" idNotif="<?= $notif->id ?>" idMessage="<?= $notif->idMessages ?>">
                            <p><?= $notif->notifDescription ?></p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>