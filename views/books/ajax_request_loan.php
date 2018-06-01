<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';
include_once ROOT_PATH . '/Model/Loan.php';
include_once ROOT_PATH . '/Model/Book.php';
$lm = new LoanMapper($con);
$loanParams= array('user_id'=> $_SESSION['current_user']->id,'status'=>'pending_for_approval','is_approved'=>0,'book_id'=>$_POST['book_id']);

$loan = new Loan($loanParams);
$result = $lm->insert($loan,$loan);
$lBook=null;
if($result !== null){
    $loan= $lm->findById($result);
    $book= $loan->book->load();
    $book->setCopies($book->copies-1);
    $lm->getBookMapper()->update($book,$book);
    $lBook=$book;
}
?>

<?php if($result !== null):?>
<div class="alert alert-primary" role="alert">
    Préstamo solicitado satisfactoriamente
</div>
<?php else:?>
<div class="alert alert-danger" role="alert">
    Error al pedir su prestamo. Comunicarse con admin
</div>
<?php endif;?>

<script>
$('#book_<?=$lBook->id?>').text('<?=$lBook->copies?>');
</script>