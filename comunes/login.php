<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    </head>
    <body><?php
        require('auxiliar.php');

        if (usuario_logueado()) {
            header("Location: /iesdonana/bd/");
        }

        menu("login");

        $user = filter_input(INPUT_POST, "user");
        $pass = filter_input(INPUT_POST, "pass");

        try {
            $error = [];
            comprobar_existen([$user, $pass]);
            $user = trim($user);
            $pass = trim($pass);
            $pdo = conectar_bd();
            comprobar_credenciales($pdo, $user, $pass, $error);
            comprobar_errores($error);
            //setcookie('login', $user, 0, '/');
            $_SESSION['login'] = $user;
            header("Location: /iesdonana/bd/");
        } catch (Exception $e) {
            mostrar_errores($error);
        } ?>

        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">Identificación de usuario</div>
                        <div class="panel-body">
                            <form action="" method="post"> <!-- El action vacio indica que el submit enviara el formulario a si mismo -->
                                <div class="form-group">
                                    <label for="user">Usuario</label>
                                    <input type="text" id="user" name="user" value="<?= htmlentities($user) ?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="pass">Contraseña</label>
                                    <input type="password" id="pass" name="pass"  value="" class="form-control" />
                                </div>
                                <button type="submit" class="btn btn-default">Login</button>
                                <button type="reset" class="btn">Limpiar</button>
                                <a href="/iesdonana/bd/index.php" class="btn btn-warning" role="button">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
