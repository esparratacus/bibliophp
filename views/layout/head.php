<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Biblioteca PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">

    <link href="<?php echo nav_link('/css/main.css') ?>" rel="stylesheet">

    <?php foreach($links as $link): ?>
        <link href="<?php echo nav_link($link) ?>" rel="stylesheet">
    <?php endforeach ?>

</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo menu_item_active("/index.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/index.php") ?>">Inicio</a>
            </li>
            <li class="nav-item <?php echo menu_item_active("/views/events/show_event.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/views/events/show_event.php")  ?>">Eventos</a>
            </li>
            <li class="nav-item <?php echo menu_item_active("/views/rooms/calendar.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/views/rooms/calendar.php") ?>" >Salas</a>
            </li>
            <li class="nav-item <?php echo menu_item_active("/views/equipment/index.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/views/equipment/index.php") ?>">Equipos</a>
            </li>
            <li class="nav-item <?php echo menu_item_active("/views/books/index.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/views/books/index.php") ?>">Libros</a>
            </li>
            <li class="nav-item <?php echo menu_item_active("/views/inventory/index.php") ?>">
                <a class="nav-link" href="<?php echo nav_link("/views/inventory/index.php") ?>">Inventario</a>
            </li>
        </ul>
    </div>
</nav>