<div class="row justify-content-center">
    <div class="col-3">
        <?php if(!isset($_SESSION['guest'])):?>
        <form method="post" action="/login" id="login-form">
            <div class="mb-3">
                <label for="exampleInputLogin1" class="form-label">Логин</label>
                <input type="text" name="aut_login" class="form-control" id="exampleInputLogin1" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['result']['aut_login']) ? htmlspecialchars($_SESSION['result']['aut_login']) : ''?>">
                <?php if(isset($_SESSION['result']['warning']['aut_login'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['aut_login']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="aut_password" class="form-control" id="exampleInputPassword1">
                <?php if(isset($_SESSION['result']['warning']['aut_password'])):?>
                    <p class="alert alert-warning"><?=$_SESSION['result']['warning']['aut_password']?></p>
                    <?php unset($_SESSION['result']);?>
                <?endif;?>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
            </div>
            <input class="btn btn-primary" value="Войти">
        </form>
        <?php else:?>
            <div> Hello: <?= $_SESSION['guest']?></div>
        <?php endif?>
    </div>
</div>
