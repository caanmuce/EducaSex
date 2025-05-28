<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['btnregistrar'])) {
    include 'conexion.php';

    
    $pass   = $_POST['clave']    ?? '';
    $pass2  = $_POST['c_clave']  ?? '';
    $doc    = $_POST['documento']         ?? '';
    $tdoc   = $_POST['tipo_documento']    ?? '';
    $txtpn  = $_POST['txt_primer_nombre'] ?? '';
    $txtsn  = $_POST['txt_segundo_nombre']?? '';
    $txtpa  = $_POST['txt_primer_apellido']?? '';
    $txtsa  = $_POST['txt_segundo_apellido']?? '';
    $tel    = $_POST['telefono']           ?? '';
    $ema    = $_POST['email']              ?? '';
    $tius   = $_POST['tipo_usuario']       ?? '';

    
    if ($pass === $pass2) {
        // Encriptar la clave
        $clave = md5($pass);
        $estado = 1;

        
        $sql = "
            INSERT INTO usuarios
                (documento, tipo_documento,
                 primer_nombre, segundo_nombre,
                 primer_apellido, segundo_apellido,
                 telefono, email,
                 clave, id_rol)
            VALUES
                ($doc, '$tdoc',
                 '$txtpn', '$txtsn',
                 '$txtpa', '$txtsa',
                 '$tel', '$ema',
                 '$clave', $tius)
        ";

        // Ejecutar el INSERT
        if (mysqli_query($conexion, $sql)) {
            
            header('Location: index.php');
            exit;
        } else {
            
            die("Problemas para insertar: " . mysqli_error($conexion));
        }

    } else {
        
        echo "<script>
                alert('Las contraseñas no coinciden');
                window.location = 'index.php';
              </script>";
        exit;
    }

} else {
    
    echo "<script>
            alert('Error: no se envió el formulario');
            window.location = 'index.php';
          </script>";
    exit;
}
?>
