<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/BookMapper.php';

if (isset($_POST['new_book'])) {
    $con->insert('books', $_POST['new_book']);
}
$bm = new BookMapper($con);
$book = $bm->findById(1); // finds only one
$books = $bm->find(); // perferms a SELECT * from books with no condition

require_head();
?>

<main role="main" class="container" style="margin-top: 60px;">
    <div class="row">
    <div class="col-md-9">
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Título</th>
        <th scope="col">Autor</th>
        <th scope="col">Edición</th>
        <th scope="col">Editorial</th>
        <th scope="col">ISBN</th>
        <th scope="col">Copias disponibles</th>
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
        <td><?php echo $b->copies; ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
    </div>
    <div class="col-md-3">
        <form action="index.php" method="POST" novalidate>
            <div class="form-group">
                <label for="element">Elija una opción</label>
                <select id="kind" class="form-control" name ="element" placeholder="s" required>
                    <option value="1">Equipo</option>
                    <option value="2">Libro</option>
                </select>
            </div>
            <div id="equipment_form">
                <div class="form-group">
                    <label for="new_equipment['name']">Título</label>
                    <input type="text" class="form-control" name="new_equipment['name']" required>
                </div>
                <div class="form-group">
                    <label for="new_equipment['maker']">Título</label>
                    <input type="text" class="form-control" name="new_equipment['maker']" required>
                </div>
                <div class="form-group">
                    <label for="new_equipment['serial_number']">Título</label>
                    <input type="text" class="form-control" name="new_equipment['serial_number']" required>
                </div>
                <div class="form-group">
                    <label for="new_equipment['quantity']">Título</label>
                    <input type="text" class="form-control" name="new_equipment['quantity']" required>
                </div>
            </div>
            <div id="book_form">
                <div class="form-group">
                    <label for="new_book['title']">Título</label>
                    <input type="text" class="form-control" name="new_book['title']" required>
                </div>
                <div class="form-group">
                    <label for="new_book['author']">Autor</label>
                    <input type="text" class="form-control" name="new_book['author']" required>
                </div>
                <div class="form-group">
                    <label for="new_book['edition']">Edición</label>
                    <input type="text" class="form-control" name="new_book['edition']" required>
                </div>
                <div class="form-group">
                    <label for="new_book['publisher']">Editorial</label>
                    <input type="text" class="form-control" name="new_book['publisher']" required>
                </div>
                <div class="form-group">
                    <label for="new_book['isbn']">ISBN</label>
                    <input type="text" class="form-control" name="new_book['isbn']" required>
                </div>
                <div class="form-group">
                    <label for="new_book['copies']"># copias</label>
                    <input type="number" class="form-control" name="new_book['copies']" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    </div>

</main>

<?php require_foot('/js/books.js') ?>