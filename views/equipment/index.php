<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/EquipmentMapper.php';
include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';

$em = new EquipmentMapper($con);
$rm = new RentalMapper($con);

$msj = [];
if(isset($_POST['equipment_id'])){
    $equipment = $em->findById($_POST['equipment_id']);
    if($equipment->quantity > 0) {
        $equipment->quantity -= 1;
        $em->update($equipment);
        $rental = new Rental([
            'user_id' => $_SESSION['current_user']->id,
            'equipment_id' => $equipment->id,
            'status' => 'pending_for_approval',
            'is_approved' => 0
        ]);
        $rm->insert($rental, $rental);

        $msj = ['status' => 'success', 'msj' => 'Solicitud creada exitosamente, espere confirmación del Administrador'];
    }else
        $msj = ['status' => 'danger', 'msj' => 'No hay mas unidades para prestar'];
}

//SEARCH
$cols_to_search = ['name', 'maker', 'quantity'];
if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
    foreach($cols_to_search as $col)
        $_REQUEST[$col] = $_REQUEST['search'];
$search = request_vars_to_search($cols_to_search, isset($_REQUEST['search']) ? "OR" : "AND");

$equipments = $em->find($search);


require_head();
?>

<main role="main" class="container">

    <div class="row">
        <?php if($msj): ?>
            <div class="col-md-12">
                <div class="alert alert-<?php echo $msj['status'] ?>"><?php echo $msj['msj'] ?></div>
            </div>
        <?php endif ?>

        <?php include_once ROOT_PATH .'/views/layout/search_basic.php' ?>
        <div class="col-md-12">
            <form action="" method="post">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fabricante</th>
                        <th scope="col">Número serial</th>
                        <th scope="col">Unidades disponibles</th>
                        <?php if(isVisitor()): ?>
                            <th scope="col">Acciones</th>
                        <?php endif ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($equipments as $equipment): ?>
                        <tr>
                            <th scope="row"><?php echo $equipment->id; ?></th>
                            <td><?php echo $equipment->name; ?></td>
                            <td><?php echo $equipment->maker; ?></td>
                            <td><?php echo $equipment->serial_number; ?></td>
                            <td><?php echo $equipment->quantity; ?></td>
                            <?php if(isVisitor()): ?>
                                <td>
                                    <button class="btn btn-sm btn-primary" name="equipment_id"
                                            value="<?php echo $equipment->id ?>"
                                            <?php echo $equipment->quantity == 0 ? "disabled" : "" ?>>
                                        Solicitar
                                    </button>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</main>

<?php require_foot() ?>
