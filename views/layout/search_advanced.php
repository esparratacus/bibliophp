<?php
$entity = strpos(current_uri(), 'equipment') ? 'equipment' : 'books';
?>

<main role="main" class="container">
    <h3>Búsqueda avanzada <?php echo $entity == 'equipment' ? "equipo" : "libro" ?></h3>
    <br>
    <form action="<?php echo nav_link("/views/$entity/index.php") ?>" method="get">
        <?php if($entity == "equipment"): ?>
            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="fabricante" class="col-sm-2 col-form-label">Fabricante</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fabricante" placeholder="Fabricante" name="maker">
                </div>
            </div>
        <?php else : ?>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Títluo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="titulo" placeholder="Titulo" name="title">
                </div>
            </div>
            <div class="form-group row">
                <label for="autor" class="col-sm-2 col-form-label">Autor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="autor" placeholder="Autor" name="author">
                </div>
            </div>
            <div class="form-group row">
                <label for="editorial" class="col-sm-2 col-form-label">Editorial</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="editorial" placeholder="Editorial" name="edition">
                </div>
            </div>
        <?php endif ?>

        <div class="form-group row">
            <div class="col-sm-2">Disponibilidad</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input type="hidden" name="<?php echo $entity == "equipment" ? "quantity" : "copies" ?>"
                           value="0" />
                    <input class="form-check-input" type="checkbox" id="disponible" value=">0" checked
                           name="<?php echo $entity == "equipment" ? "quantity" : "copies" ?>" >
                    <label class="form-check-label" for="disponible">
                        Disponible
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>
</main>
