<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

include "conexion.php";

$sql = "SELECT productos.id, productos.nombre, productos.descripcion, flujo.tipo AS flujo_tipo, paises.nombre_pais, paises.tipo_relacion, paises.fecha_relacion
        FROM productos
        INNER JOIN flujo ON productos.flujo_id = flujo.id
        INNER JOIN paises ON productos.pais_id = paises.id
        ORDER BY productos.id ASC";

$resultado = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
    $id_a_eliminar = $_POST['eliminar'];
    $sql_eliminar = "DELETE FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_eliminar);
    mysqli_stmt_bind_param($stmt, "i", $id_a_eliminar);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=Producto eliminado satisfactoriamente");
        exit;
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-image: url('https://blog.redbus.pe/wp-content/uploads/2019/12/40547475.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
        }
        .btn:hover {
            background-color: #28a745;
        }
        .navbar {
            justify-content: center;
            background-color: #A0CBEC;
            padding: 10px 0;
        }
        .navbar a {
            color: white;
        }
        .cerrar-sesion {
            position: absolute;
            margin-right: 75rem;
            top: 10px;
            right: 10px;
        }
        .table-outer-borders {
            border: 1px solid #dee2e6;
        }

        .table-outer-borders th,
        .table-outer-borders td {
            border: 1px solid #dee2e6;
        }
        body, th, td, h2, .btn {
            color: #ffffff;
        }
        th, td {
            font-weight: bold; 
        }

    </style>
</head>
<body>
    <div class="container" style="max-width: fit-content;" class="resposive">
        <div class="text-center mb-4" style="margin-top: 2.5rem;">
            <h2>Lista de Productos</h2>
        </div>
        <?php
        if ($_SESSION['nivel'] === 'superadmin') {
            echo '<a class="btn btn-primary mb-3" href="agregar_producto.php">Agregar Producto</a>';
        }
        ?>
        <table class="table table-striped table-hover table-bordered table-outer-borders">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo de Flujo</th>
                    <th>Nombre del País</th>
                    <th>Tipo de Relación</th>
                    <th>Fecha de Relación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo '<tr class="table-row">';
                    echo '<td>' . $fila['id'] . '</td>';
                    echo '<td>' . $fila['nombre'] . '</td>';
                    echo '<td>' . $fila['descripcion'] . '</td>';
                    echo '<td>' . $fila['flujo_tipo'] . '</td>';
                    echo '<td>' . $fila['nombre_pais'] . '</td>';
                    echo '<td>' . $fila['tipo_relacion'] . '</td>';
                    echo '<td>' . $fila['fecha_relacion'] . '</td>';
                    echo '<td>';
                    echo '<form method="POST" style="display: inline;">';
                    if ($_SESSION['nivel'] === 'superadmin') {
                        echo '<button type="submit" name="eliminar" value="' . $fila['id'] . '" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>';
                    }
                    echo '</form>';
                    if ($_SESSION['nivel'] === 'superadmin' || $_SESSION['nivel'] === 'usuario_general') {
                        echo '<a href="editar.php?id=' . $fila['id'] . '" class="btn btn-primary btn-sm mx-1"><i class="bi bi-pencil"></i></a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="login.php" class="btn btn-danger cerrar-sesion">Cerrar Sesión</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
