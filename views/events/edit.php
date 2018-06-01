<?php
	require_once '../../includes/includes.php';

	include_once ROOT_PATH . '/Model/Mapper/EventMapper.php';

	$em = new EventMapper($con);

	if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin){
		
		if(isset($_GET['id'])){
			$_SESSION['selected_event'] = $em->findById($_GET['id']);
		}

		if(isset($_POST['new_event'])){
			$updated_event = new Event($_POST['new_event']);
			$updated_event->id = $_SESSION['selected_event']->id;
			$em->update($updated_event);
			redirect("/views/events/index.php");
		}
	}

	require_head('/lib/datetimepicker/css/bootstrap-datetimepicker.min.css');
?>

<main role="main" class="container">
	<?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
		<h3>Agregar</h3>
		<form action="edit.php" method="POST">
				<div class="form-group">
						<label for="new_event[name]">Nombre</label>
						<input type="text" class="form-control" name="new_event[name]" value="<?php echo $_SESSION['selected_event']->name; ?>" required>
				</div>
				<div class="form-group">
						<label for="new_event[starts_at]">Inicio</label>
						<input type="text" readonly class="form_datetime form-control" name="new_event[starts_at]" value="<?php echo $_SESSION['selected_event']->starts_at;?>" required>
				</div>
				<div class="form-group">
						<label for="new_event[ends_at]">Fin</label>
						<input type="text" readonly class="form_datetime form-control" name="new_event[ends_at]" value="<?php echo $_SESSION['selected_event']->ends_at;?>" required>
				</div>
				<div class="form-group">
						<label for="new_event[location]">Ubicación</label>
						<input type="text" class="form-control" name="new_event[location]" value="<?php echo $_SESSION['selected_event']->location;?>" required>
				</div>

				<button type="submit" class="btn btn-primary">Actualizar</button>
		</form>
		<br>
    <?php endif; ?>
</main>

<?php require_foot(
	'/lib/datetimepicker/js/bootstrap-datetimepicker.js',
	'/js/datetime.js'
) ?>

