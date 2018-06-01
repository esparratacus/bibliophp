<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';
include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';
include_once ROOT_PATH . '/Model/Mapper/ReportMapper.php';
include_once ROOT_PATH . '/Model/Mapper/EquipmentMapper.php';

$um = new UserMapper($con);
$rm = new RentalMapper($con);
$reportMapper = new ReportMapper($con);
$equipmentMapper = new EquipmentMapper($con);

$user = false;
$users = [];
$rentals = [];
$states = ['excelente', 'bueno', 'regular', 'averiado o deteriorado', 'devuelto'];
$msj = [];
if(isset($_POST['select_user']) && isset($_POST['user_id'])){
    $user = $um->findById($_POST['user_id']);
    $rentals = $rm->findByUserApproved($_POST['user_id']);
}else if(isset($_POST['report'])){
    $rental = $rm->findById($_POST['rental_id']);
    $equipment = $rental->equipment->load();

    $prev_report = $reportMapper->findLastReport($_POST['user_id'], $equipment->id);
    if($prev_report && $prev_report->state == 'averiado o deteriorado' && $_POST['state'] == 'devuelto'){
        $msj = ['status' => 'danger', 'msj' => 'El anterior reporte dice averiado, no puede devolverse'];
        $user = $um->findById($_POST['user_id']);
        $rentals = $rm->findByUserApproved($_POST['user_id']);
    }
    else{
        $report = new Report([
            'state' => $_POST['state'],
            'comments' => $_POST['comments'],
            'equipment_id' => $equipment->id,
            'user_id' => $_POST['user_id']
        ]);
        $reportMapper->insert($report, $report);
        if($_POST['state'] == 'devuelto'){
            //Se supone que si devuelto, debe modificar los registros relacionados a prestamo
            /*$equipment->quantity += 1;
            $equipmentMapper->update($equipment);
            $rental->status = 'returned';
            unset($rental->equipment);
            $rm->update($rental);*/
        }
        $msj = ['status' => 'success', 'msj' => 'Reporte creado exitosamente'];
    }
}
if(!$user)
    $users = $um->getVisitors();


require_head();
?>
<main role="main" class="container">
    <div class="row">
        <?php if($msj): ?>
            <div class="col-md-12">
                <div class="alert alert-<?php echo $msj['status'] ?>">
                    <?php echo $msj['msj'] ?>
                </div>
            </div>
        <?php endif ?>
        <div class="col-md-12">
            <form action="" method="post">
                <?php if(!$user): ?>
                    <div class="form-group row">
                        <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="user" name="user_id">
                                <?php foreach($users as $user): ?>
                                    <option value="<?php echo $user->id ?>"><?php echo $user->username ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <button type="submit" class="btn btn-primary" name="select_user">Seleccionar</button>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="user_id" value="<?php echo $user->id ?>" >
                    <div class="form-group row">
                        <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                        <div class="col-sm-10">
                            <p><?php echo $user->username ?></p>
                        </div>
                    </div>

                    <?php if($rentals->count()): ?>
                        <div class="form-group row">
                            <label for="rental_id" class="col-sm-2 col-form-label">Elemento</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="rental_id" name="rental_id">
                                    <?php foreach($rentals as $rental):
                                        $equipment = $rental->equipment->load();
                                        ?>
                                        <option value="<?php echo $rental->id ?>"><?php echo $equipment->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Estado</legend>
                                <div class="col-sm-10">
                                <?php for($i = 0; $i < count($states); $i++): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="state" id="state<?php echo $i ?>"
                                               value="<?php echo $states[$i] ?>" <?php echo $i == 0 ? "checked" : "" ?>>
                                        <label class="form-check-label" for="state<?php echo $i ?>">
                                            <?php echo ucfirst($states[$i]) ?>
                                        </label>
                                    </div>
                                <?php endfor ?>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="comments" class="col-sm-2 col-form-label">Comentario</label>
                            <div class="col-sm-10">
                                <textarea name="comments" id="comments" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" name="report">Registrar reporte</button>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>El usuario no tiene equipos prestados actualmente</p>
                    <?php endif ?>
                    <a href="<?php nav_link("/views/admin/resultado_reporte.php") ?>"> Cancelar </a>
                <?php endif ?>
            </form>
        </div>
    </div>
</main>
<?php require_foot() ?>