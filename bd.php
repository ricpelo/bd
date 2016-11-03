<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bases de datos</title>
    </head>
    <body><?php
        require 'auxiliar.php'; ?>

        <form action="" method="post">
            <label for="dept_no">Número de departamento:</label>
            <input type="text" id="dept_no" name="dept_no" /><br/>
            <label for="dnombre">Nombre de departamento:</label>
            <input type="text" id="dnombre" name="dnombre" /><br/>
            <label for="localidad">Nombre de la localidad:</label>
            <input type="text" id="localidad" name="localidad" /><br/>
            <input type="submit" value="Buscar" />
        </form><?php

        try {
            $dept_no = filter_input(INPUT_POST, 'dept_no');
            $dnombre = filter_input(INPUT_POST, 'dnombre');
            $localidad = filter_input(INPUT_POST, 'localidad');

            $error = [];
            comprobar_dept_no($dept_no, $error);
            comprobar_dnombre($dnombre, $error);
            comprobar_localidad($localidad, $error);
            //comprobar_si_hay_uno([$dept_no, $dnombre], $error);
            comprobar_errores($error);
            $pdo = conectar_bd();
            $result = buscar_por_dept_no_y_dnombre_y_localidad($pdo, $dept_no, $dnombre, $localidad);
            comprobar_si_vacio($result, $error);
            comprobar_errores($error);
            dibujar_tabla($result);
        } catch (PDOException $e) {
            ?>
            <h3>Error de conexión a la base de datos</h3><?php

        } catch (Exception $e) {
            mostrar_errores($error);
        } ?>
    </body>
</html>
