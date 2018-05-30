<?php
$entity = strpos(current_uri(), 'equipment') ? 'equipment' : 'books';
?>
<div class="col-md-12">


    <form class="form-inline" method="get">
        <label class="sr-only" for="search">Busqueda básica</label>
        <input type="text" class="form-control mb-2 mr-sm-2" id="search" placeholder="Ingrese busqueda"
               name="search" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : "" ?>">

        <button type="submit" class="btn btn-primary mb-2">Buscar</button>

        <div class="form-check mb-2 mr-sm-2">
            <a href="<?php echo nav_link("/views/$entity/search.php") ?>">Busqueda avanzada</a>
        </div>


    </form>
</div>