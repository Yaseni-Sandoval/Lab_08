<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $flujo_id = $_POST['flujo'];
    $pais_id = $_POST['pais'];

    $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', flujo_id = $flujo_id, pais_id = $pais_id WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=Producto actualizado satisfactoriamente");
        exit;
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conn);
    }
}

$id = $_GET['id']; 
$sqlProducto = "SELECT * FROM productos WHERE id = $id";
$resultadoProducto = mysqli_query($conn, $sqlProducto);
$filaProducto = mysqli_fetch_assoc($resultadoProducto);

$sqlFlujo = "SELECT * FROM flujo";
$resultadoFlujo = mysqli_query($conn, $sqlFlujo);

$sqlPaises = "SELECT * FROM paises";
$resultadoPaises = mysqli_query($conn, $sqlPaises);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <style>
        body {
            background-image: url('https://pbs.twimg.com/media/EcwP9QqWoAAgqi3.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
        }
        .navbar {
            justify-content: center;
            background-color: var(top, #fcc5e4 0%, #fda34b 15%, #ff7882 35%, #c8699e 52%, #7046aa 71%, #0c1db8 87%, #020f75 100%);
            padding: 10px 0;
        }
        .navbar h1 {
            margin-bottom: 0;
            color: #e7f0fd; 
        }
        .container {
            max-width: 500px; 
        }
        .form-label, .btn {
            color: #ffffff;
            font-weight: bold;
        }
        .form-control, .form-select {
            background-color: #d9ded8; 
        }
        .btn-primary:hover, .btn-secondary:hover {
            background-color: #28a745; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light fs-3 mb-5">
        <h1>Editar Producto</h1>
    </nav>
    <div class="container">
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $filaProducto['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo $filaProducto['nombre']; ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?php echo $filaProducto['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="flujo" class="form-label">Tipo de Flujo</label>
                <select class="form-select" id="flujo" name="flujo">
                    <option value="" selected>Seleccionar Tipo de Flujo</option>
                    <?php
                    while ($fila = mysqli_fetch_assoc($resultadoFlujo)) {
                        $selected = ($filaProducto['flujo_id'] == $fila['id']) ? "selected" : "";
                        echo '<option value="' . $fila['id'] . '" ' . $selected . '>' . $fila['tipo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">Tipo de Relación</label>
                <select class="form-select" id="pais" name="pais">
                    <option value="" selected>Seleccionar Tipo de Relación</option>
                    <?php
                    mysqli_data_seek($resultadoPaises, 0); 
                    while ($fila = mysqli_fetch_assoc($resultadoPaises)) {
                        $selected = ($filaProducto['pais_id'] == $fila['id']) ? "selected" : "";
                        echo '<option value="' . $fila['id'] . '" ' . $selected . '>' . $fila['tipo_relacion'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
