<div class="row">
    <?php if(isset($_SESSION['guest'])):?>
        <div> Hello: <?= $_SESSION['guest']?></div>
    <?php endif?>
</div>
