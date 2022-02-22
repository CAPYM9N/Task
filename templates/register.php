<div class="row justify-content-center">
    <div class="col-3">
        <?php if(!isset($_SESSION['guest'])):?>
        <form method="post" action="/register" id="registration-form">
            <div class="mb-3">
                <label for="exampleInputLogin" class="form-label">Логин</label>
                <input type="text" name="login" class="form-control" id="exampleInputLogin" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['result']['login']) ? htmlspecialchars($_SESSION['result']['login']) : ''?>">
                <?php if(isset($_SESSION['result']['warning']['login'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['login']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email адрес</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['result']['email']) ? htmlspecialchars($_SESSION['result']['email']) : ''?>">
                <?php if(isset($_SESSION['result']['warning']['email'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['email']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3">
                <label for="autoSizingInputGroup" class="form-label">Имя</label>
                <input type="text" name="name" class="form-control" id="autoSizingInputGroup"
                       value="<?= isset($_SESSION['result']['name']) ? htmlspecialchars($_SESSION['result']['name']) : ''?>">
                <?php if(isset($_SESSION['result']['warning']['name'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['name']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <?php if(isset($_SESSION['result']['warning']['password'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['password']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
                <input type="password" name="password2" class="form-control" id="exampleInputPassword2">
                <?php if(isset($_SESSION['result']['warning']['password2'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['password2']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <input class="btn btn-primary" value="Регистрация">
        </form>
        <?php else:?>
        <div> Hello: <?= $_SESSION['guest']?></div>
        <?php endif?>
    </div>
</div>
