<?php
require "connection.php";
$conexion = conectarBD();

?>
<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <title>Taquillator</title>
    </head>

    <body>

        <form action="" method="get">
            <select name="localidad">
                <option value="">Todas las localidades</option>
                <option value="Gijón">Gijón</option>
                <option value="Oviedo">Oviedo</option>
                <option value="Avilés">Avilés</option>
            </select>
            <input type="submit" value="Buscar">
        </form>

        <?php
        if (isset($_GET['localidad'])) {

            ////////////////////////////////////////////
            // TODO 2: Obtener taquillas según filtro //
            ////////////////////////////////////////////

            $localidad = $_GET['localidad'];

            if (empty($localidad)) {
                $sql = "SELECT * FROM puntosderecogida";
            } else {
                $sql = "SELECT * FROM puntosderecogida WHERE localidad = '$localidad'";
            }

            $resultado = $conexion->query($sql);
            if ($resultado->rowCount() > 0) {
                echo "<table><tr><th>Localidad</th><th>Dirección</th><th>Capacidad</th><th>Ocupadas</th></tr>";

                /////////////////////////////////////
                // TODO 3: Imprimir filas de tabla //
                /////////////////////////////////////

                while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$fila['localidad']}</td><td>{$fila['direccion']}</td><td>{$fila['capacidad']}</td><td>{$fila['ocupadas']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "ERROR, algo ha salido mal a la hora de mostrar la tabala";
            }
        }
        ?>

    </body>

</html>