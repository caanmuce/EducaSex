<?php
// Mostrar errores (si usarás validación en PHP)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();
if (isset($_SESSION['USER'])) {
    echo "<script>window.location='admin/dashboard.php';</script>";
    exit();
}

// Verificar envío de formulario
if (isset($_POST['btningresar'])) {
    include "conexion.php";

    // Recibir variables
    $user = trim($_POST['txtdoc'] ?? '');
    $pass = trim($_POST['textpass'] ?? '');

    // Verificar campos vacíos
    if (empty($user) || empty($pass)) {
        $errorMsg = "Por favor, complete todos los campos.";
    } else {
        // Encriptar contraseña
        $clave = md5($pass);

        // Consulta a la base de datos 
        $sql = "SELECT primer_nombre, segundo_nombre
                FROM usuarios
                WHERE documento = '$user' AND clave = '$clave'";
        $consulta = mysqli_query($conexion, $sql)
            or die("Problemas en la consulta: " . mysqli_error($conexion));

        // Verificar resultados
        if (mysqli_num_rows($consulta) > 0) {
            // Obtener datos y guardar en sesión
            $fila = mysqli_fetch_assoc($consulta);
            $_SESSION['pn'] = $fila['primer_nombre'];
            $_SESSION['pa'] = $fila['segundo_nombre'];

            // Redirigir al dashboard
            header("Location: Admin/index.html");
            exit();
        } else {
            $errorMsg = "Documento o clave incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ingreso | EducaSex</title>

  <!-- Bootstrap 5 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <!-- FontAwesome para íconos -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  />
  <!-- Google Font: Nunito -->
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
    rel="stylesheet"
  />
  <style>
    /* ==================
       Estilos Generales
       ================== */
    html, body {
      height: 100%;
      margin: 0;
      font-family: "Nunito", sans-serif;
      background: linear-gradient(135deg, #ffe4e1 0%, #ffd1dc 100%);
    }
    .login-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      padding: 1rem;
    }
    /* ====================
       Tarjeta de Login
       ==================== */
    .login-card {
      background: rgba(255,255,255,0.9);
      border: none;
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.1);
      max-width: 900px;      /* Ancha para horizontal */
      width: 100%;
      display: flex;
      overflow: hidden;
    }
    /* Panel izquierdo con logo */
    .left-panel {
      flex: 1;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
    }
    .left-panel::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 180%;
      height: 140px;
      background: url('img/pastel_wave.svg') no-repeat bottom center;
      background-size: cover;
      opacity: 0.15;
      transform: translateX(-25%);
    }
    .left-panel img {
      max-width: 80%;
      height: auto;
      z-index: 1;
    }
    /* Panel derecho con formulario */
    .right-panel {
      flex: 1.2;
      padding: 3rem;
      overflow-y: auto;
    }
    /* Título grande */
    .login-title {
      font-size: 2rem;
      font-weight: 700;
      color: #6f42c1;
      text-align: center;
      margin-bottom: 2rem;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    /* ===================
       Input Groups
       =================== */
    .input-group .form-control {
      border: 2px solid #e83e8c;
      border-radius: 8px;
      padding: 1.25rem 1rem;
      font-size: 1rem;
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .input-group .form-control:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 0 0.2rem rgba(111,66,193,0.25);
      background: #fff;
    }
    .input-group-text {
      background: transparent;
      border: none;
      font-size: 1.25rem;
      color: #6f42c1;
      padding-right: 0.5rem;
      padding-left: 0.75rem;
    }

    /* ===================
       Botón Ingresar
       =================== */
    .btn-primary-custom {
      background: linear-gradient(135deg, #e83e8c, #6f42c1);
      border: none;
      border-radius: 8px;
      font-weight: 600;
      padding: 1rem;
      font-size: 1.1rem;
      color: #fff;
      transition: background 0.3s, transform 0.2s;
      width: 100%;
    }
    .btn-primary-custom:hover {
      background: linear-gradient(135deg, #d13779, #5930a4);
      transform: translateY(-2px);
      box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    }
    .btn-primary-custom:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* ========================
       Enlaces secundarios
       ======================== */
    .link-secondary {
      color: #6f42c1;
      text-decoration: none;
      font-size: 1rem;
      transition: color 0.3s;
    }
    .link-secondary:hover {
      color: #5930a4;
      text-decoration: underline;
    }

    /* =====================
       Pie de página
       ===================== */
    .footer-text {
      font-size: 0.85rem;
      color: #858796;
      text-align: center;
      margin-top: 1rem;
    }

    @media (max-width: 768px) {
      .login-card {
        flex-direction: column;
        max-height: 95vh;
      }
      .left-panel {
        display: none; /* Ocultar logo en móviles */
      }
      .right-panel {
        padding: 2rem 1rem;
      }
      .login-title {
        font-size: 1.75rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card card">

      <!-- ===== Panel Izquierdo (Logo) ===== -->
      <div class="left-panel">
        <img src="img/logo.png" alt="Logo EducaSex"/>
      </div>
      <!-- ================================ -->

      <!-- ===== Panel Derecho (Formulario) ===== -->
      <div class="right-panel">
        <h2 class="login-title">Ingreso a EducaSex</h2>

        <!-- Mensaje de error si existe -->
        <?php if (!empty($errorMsg)): ?>
          <div class="alert alert-danger py-2">
            <?= htmlspecialchars($errorMsg) ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="row g-4">
            <!-- Documento -->
            <div class="col-12">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-id-card"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  id="txtdoc"
                  name="txtdoc"
                  placeholder="Documento"
                  required
                  pattern="\d{7,11}"
                  minlength="7"
                  maxlength="11"
                  title="Ingrese únicamente números, entre 7 y 11 dígitos."
                />
              </div>
            </div>
            <!-- Contraseña -->
            <div class="col-12">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock"></i>
                </span>
                <input
                  type="password"
                  class="form-control"
                  id="textpass"
                  name="textpass"
                  placeholder="Clave"
                  required
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Mínimo 8 caracteres, al menos 1 número, 1 minúscula y 1 mayúscula."
                />
              </div>
            </div>
            <!-- Botón Ingresar -->
            <div class="col-12">
              <button
                type="submit"
                name="btningresar"
                class="btn btn-primary-custom"
              >
                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
              </button>
            </div>
          </div>
        </form>

        <!-- Enlaces Secundarios -->
        <div class="mt-4 d-flex justify-content-between">
          <a href="#" class="link-secondary">¿Olvidaste la contraseña?</a>
          <a href="registrar.php" class="link-secondary">Crear cuenta</a>
        </div>

        <!-- Pie de página -->
        <div class="footer-text">
          &copy; 2025 EducaSex. Todos los derechos reservados.
        </div>
      </div>
      <!-- ======================================= -->

    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
