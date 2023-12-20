<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Añadir Nueva Taquilla</title>
    </head>

    <body>
        <h2>Añadir Nueva Taquilla</h2>
        <form action="nueva_taquilla.php" method="post">
            <label for="localidad">Localidad:</label><br>
            <select id="localidad" name="localidad" required>
                <option value="">Seleccione una localidad</option>
                <option value="Gijón">Gijón</option>
                <option value="Oviedo">Oviedo</option>
                <option value="Avilés">Avilés</option>
            </select><br>
        
            <label for="direccion">Dirección:</label><br>
            <input type="text" id="direccion" name="direccion" required><br>
        
            <label for="capacidad">Capacidad:</label><br>
            <input type="number" id="capacidad" name="capacidad" min="1" required><br>
        
            <label for="ocupadas">Taquillas Ocupadas:</label><br>
            <input type="number" id="ocupadas" name="ocupadas" min="0" required><br>
        
            <input type="submit" value="Añadir Taquilla">
        </form>
    </body>
</html>


<?php
require_once 'connection.php';
$conexion = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $localidad = $_POST['localidad'];
    $direccion = $_POST['direccion'];
    $capacidad = $_POST['capacidad'];
    $ocupadas = $_POST['ocupadas'];

    // Verificamos si la direccion ya existe en la base de datos, SI EXISTE, no añadiremos nada a la base de datos, ya que supongo que ya existe
    $direccionQueYaExiste = $conexion->prepare("SELECT COUNT(*) FROM puntosderecogida WHERE direccion = :direccion");
    $direccionQueYaExiste->bindParam(':direccion', $direccion);
    $direccionQueYaExiste->execute();
    $existeDireccion = $direccionQueYaExiste->fetchColumn();

    if ($existeDireccion > 0) {
        echo "ERROR, parece ser que la direccion ya coincide con otra que tengo en mi base de datos, cambia de direccion";
    } else {
        // Aqui, una vez comprobada que la direccion no existe, hacemos la consulta SQL de insertar "INSERT", con la que agregaremos los datos a la base de datos
        $sql = "INSERT INTO puntosderecogida (localidad, direccion, capacidad, ocupadas) VALUES (:localidad, :direccion, :capacidad, :ocupadas)";
        $consulta = $conexion->prepare($sql);

        $consulta->bindParam(':localidad', $localidad);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':capacidad', $capacidad);
        $consulta->bindParam(':ocupadas', $ocupadas);

        if ($consulta->execute()) {
            echo "Has creado un nuevo punto de recogida :)";
        } else {
            echo "ERROR, algo ha salido mal, tu punto de recogida no se ha creado correctamente :(";
        }
    }
}
?>