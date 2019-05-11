<?php
defined('_EXEC') or die;
?>
<div class="alert alert-danger fade in fa-2x"> 
    <strong><i class="fa fa-exclamation-triangle "></i></strong> No puede ingresar a prematriculas.
</div>
<?php
foreach ($mensajeError as $error) {
    ?>
    <div class="alert alert-warning fade in">
        <button class="close" data-dismiss="alert"><span>×</span></button>
        <strong><i class="fa fa-exclamation-triangle"></i></strong> <?php echo $error; ?>.
    </div>
    <?php
}