<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/BookMapper.php';

if (isset($_POST['new_book'])) {
    $con->insert('books', $_POST['new_book']);
}
$bm = new BookMapper($con);

$cols_to_search = ['title', 'author', 'edition', 'copies'];
if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
    foreach($cols_to_search as $col)
        $_REQUEST[$col] = $_REQUEST['search'];

$search = request_vars_to_search($cols_to_search, isset($_REQUEST['search']) ? "OR" : "AND");
$books = $bm->find($search);

require_head();
?>

<main role="main" class="container" style="margin-top: 60px;">
    <div id="messages">
    </div>
    <div class="row">

    <?php include_once ROOT_PATH .'/views/layout/search_basic.php' ?>

    
    <table class="table table-sm">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Título</th>
        <th scope="col">Autor</th>
        <th scope="col">Edición</th>
        <th scope="col">Editorial</th>
        <th scope="col">ISBN</th>
        <th scope="col">Copias disponibles</th>
        <th scope="col"> acciones </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $b): ?>
        <tr>
        <th scope="row"><?php echo $b->id; ?></th>
        <td><?php echo $b->title; ?></td>
        <td><?php echo $b->author; ?></td>
        <td><?php echo $b->edition; ?></td>
        <td><?php echo $b->publisher; ?></td>
        <td><?php echo $b->isbn; ?></td>
        <td id="book_<?=$b->id;?>"><?= $b->copies; ?></td>
        <td>
            <form class="loan_request" action="/biblioteca/views/books/ajax_request_loan.php" method="post">
            <input type="hidden" name="book_id" value="<?= $b->id?>">
            <?php if($b->copies > 0):?>
            <input type="submit" class="btn btn-primary btn-sm" value="Solicitar">
            <?php else:?>
            <input type="submit" class="btn btn-primary btn-sm" value="Solicitar" disabled>
            <?php endif?>
            </form>
        </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
    </div>
    
</main>

<?php require_foot('/js/books.js','/js/ajax_request_loan.js') ?>