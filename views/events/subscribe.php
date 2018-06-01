<?php
	require_once '../../includes/includes.php';

	include_once ROOT_PATH . '/Model/Mapper/SubscriptionMapper.php';
	include_once ROOT_PATH . '/Model/Mapper/EventMapper.php';

	$sm = new SubscriptionMapper($con);
	$em = new EventMapper($con);

	if(isset($_SESSION['current_user']) && !$_SESSION['current_user']->admin){
		
		if(isset($_GET['id'])){
			$_SESSION['selected_event'] = $em->findById($_GET['id']);
		}

		if(isset($_POST['new_subscription'])){
			$subscription = new Subscription($_POST['new_subscription']);
			$sm->insert($subscription, $subscription);
		}
	}

	require_head();
?>
<main role="main" class="container">

<?php if(isset($_SESSION['current_user']) && !$_SESSION['current_user']->admin):?>
		<h3>Nueva subscripción</h3>
		<form action="subscribe.php" method="POST">
				<div class="form-group">
						<label for="event">Evento</label>
						<input type="text" readonly class="form-control" name="event" value="<?php echo $_SESSION['selected_event']->name;?>">
				</div>
				<div class="form-group">
						<label for="username">Usuario</label>
						<input type="text" readonly class="form-control" name="username" value="<?php echo $_SESSION['current_user']->username;?>">
				</div>
				<div class="form-group">
						<label for="new_subscription[subscription_email]">Email</label>
						<input type="email" class="form-control" name="new_subscription[subscription_email]" value="<?php echo $_SESSION['current_user']->email;?>">
				</div>
				<input type="hidden" name="new_subscription[user_id]" value="<?php echo $_SESSION['current_user']->id;?>">
				<input type="hidden" name="new_subscription[event_id]" value="<?php echo $_SESSION['selected_event']->id;?>">

				<button type="submit" class="btn btn-primary">Suscribirse</button>
		</form>
		<br>
<?php endif; ?>

</main>

<?php require_foot() ?>
