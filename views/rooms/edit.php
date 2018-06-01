<?php
	require_once '../../includes/includes.php';

	include_once ROOT_PATH . '/Model/Mapper/RoomMapper.php';

	$rm = new RoomMapper($con);

	if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin){
		
		if(isset($_GET['id'])){
			$_SESSION['selected_room'] = $rm->findById($_GET['id']);
		}

		if(isset($_POST['new_room'])){
			$updated_room = new Room($_POST['new_room']);
			$updated_room->id = $_SESSION['selected_room']->id;
			$rm->update($updated_room);
			redirect("/views/rooms/index.php");
		}
	}

	require_head();
?>

<main role="main" class="container">
	<?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
		<h3>Editar</h3>
		<form action="edit.php" method="POST">
				<div class="form-group">
						<label for="new_room[name]">Nombre</label>
						<input type="text" class="form-control" name="new_room[name]" value="<?php echo $_SESSION['selected_room']->name; ?>" required>
				</div>
				<div class="form-group">
						<label for="new_room[capacity]">Capacidad</label>
						<input type="number" class="form-control" name="new_room[capacity]" value="<?php echo $_SESSION['selected_room']->capacity;?>" required>
				</div>

				<button type="submit" class="btn btn-primary">Actualizar</button>
		</form>
		<br>
    <?php endif; ?>
</main>

<?php require_foot() ?>

