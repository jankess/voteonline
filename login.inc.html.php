<div class="modal-content">
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="text-center">Logowanie</h1>
        <p>Podaj login oraz hasło.</p>
        <?php if (isset($loginError)): $alert = 'alert alert-danger'; ?>
        <div class="<?php echo($alert); ?>"><p><?php echo($loginError);?></p></div>
        <?php else: $alert = ''; endif; ?>
        <form action="" method="post">
            <div>
                <label for="userlogin">Login:<input type="text" name="userlogin" id="userlogin" class="form-control <?php echo($alert); ?>"></label>
                <label for="password">Hasło: <input type="password" name="password" id="password" class="form-control <?php echo($alert); ?>"></label>
            </div>
            <div>
                <input type="hidden" name="action" value="login">
                <input type="submit" value="Zaloguj" class="btn btn-default ">
            </div>
        </form>  
    </div>
</div>