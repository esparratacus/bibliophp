<?php
require_once 'includes/includes.php';
require_head();
isAdmin();
?>

<main role="main" class="container">
    <?php if(!isset($_SESSION['current_user'])):
        redirect('/views/registration/login.php');
    endif;
    if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):
        redirect('/views/admin/home.php');
    endif;
    if(isset($_SESSION['current_user']) && !$_SESSION['current_user']->admin):
        redirect('/views/events/index.php');
    endif; ?>
</main>

<?php require_foot() ?>