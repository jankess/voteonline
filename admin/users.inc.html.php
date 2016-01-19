 <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
         <h4><b>Użytkownicy Voteonline:</b></h4>
         
         <table class="table table-bordered table-responsive text-center">
             <tr class="info"><td><b>Login</b></td><td><strong>Adres email</strong></td><td><strong>Uprawnienia</strong></td></tr>
        <?php foreach ($users as $user): ?>
             <form action="" method="post">
                 <tr><input type="hidden" name="login" value="<?php echo ($user['login']); ?>"><td><?php htmlprint($user['login']); ?></td><td><?php htmlprint($user['email']); ?></td><td><?php htmlprint($user['roleid']); ?></td><td><input type="submit" name="action" value="Usuń"></td></tr></form>
      <?php endforeach; ?>
             </table>
        </div>
        </div>