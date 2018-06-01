<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';
include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';

$um = new UserMapper($con);
$rm = new RentalMapper($con);

$user = false;
$users = [];
$equipments = [];
if(isset($_POST['user_id'])){
    $user = $um->findById($_POST['user_id']);
    $equipments = $em->find();
}else
    $users = $um->getVisitors();



require_head();
?>
<main role="main" class="container">
    <div class="row">
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
                            <button type="submit" class="btn btn-primary">Seleccionar</button>
                        </div>
                    </div>
                <?php else: ?>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    First radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                <label class="form-check-label" for="gridRadios2">
                                    Second radio
                                </label>
                            </div>
                            <div class="form-check disabled">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                                <label class="form-check-label" for="gridRadios3">
                                    Third disabled radio
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-2">Checkbox</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                            <label class="form-check-label" for="gridCheck1">
                                Example checkbox
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </div>
                <?php endif ?>
            </form>
        </div>
    </div>
</main>
<?php require_foot() ?>