<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Modificar un departamento</title>
    </head>
    <body><?php
        require "../comunes/auxiliar.php";

        $pdo = conectar_bd();
        $localidad_id = filter_input(INPUT_GET, "localidad_id");

        if ($localidad_id !== null){ //Venimos del index.php
            $result = buscar_por_localidad_id($pdo, $localidad_id);
            if (empty($result)){
                header("Location: index.php");
            }
            $loc = $result['loc'];
        } else {
            $localidad_id = filter_input(INPUT_POST, "localidad_id");
            $loc = filter_input(INPUT_POST, "loc");
            try{
                $error = [];
                comprobar_existen([$loc, $localidad_id]);
                comprobar_loc($loc, $error, ESC_INSERTAR);
                comprobar_localidad_id($localidad_id, $pdo, $error);
                comprobar_errores($error);
                $pdo = conectar_bd();
                $orden = $pdo->prepare("update localidades
                                        set loc = :loc
                                        where id = :localidad_id");
                $orden->execute([
                        ':loc' => $loc,
                        ':localidad_id' => $localidad_id,
                ]);

                header("Location: index.php");
            } catch (PDOException $e) { ?>
                <h3>Error de conexión a la base de datos</h3><?php
            } catch (Exception $e) {
                mostrar_errores($error);
            }
        }?>


        <form action="modificar.php" method="post">
            <input type="hidden" name="localidad_id" value="<?= htmlentities($localidad_id) ?>">
            <label for="loc">Localidad: *</label>
            <input type="text" id="loc" name="loc" value="<?= htmlentities($loc) ?>" /><br/>
            <input type="submit" value="Modificar" />
            <a href="index.php" role="button">Cancelar</a>
        </form>
    </body>
</html>
