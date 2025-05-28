<?php
// Mostrar errores (si usarás validación en PHP)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ejemplo: variable de error para mostrar validaciones del servidor
$errorMsg = '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registro de Usuario | EducaSex</title>

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
      overflow: hidden;
    }
    .bg-shapes {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top left, #ffd1dc 0%, transparent 60%),
                  radial-gradient(circle at bottom right, #ffe4e1 0%, transparent 60%);
      z-index: -2;
    }
    .bg-shapes::after {
      content: "";
      position: absolute;
      bottom: -50px;
      left: -50px;
      width: 200%;
      height: 200%;
      background: url('img/abstract_wave.svg') no-repeat center center;
      background-size: cover;
      opacity: 0.1;
      animation: drift 25s infinite linear;
    }
    @keyframes drift {
      from { transform: translate(0, 0) rotate(0deg); }
      to   { transform: translate(-20px, -20px) rotate(360deg); }
    }

    /* ==========================
       Contenedor Centrado
       ========================== */
    .register-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
    }

    /* ============================================
       Tarjeta de Registro (con Scroll Interno)
       ============================================ */
    .register-card {
      position: relative;
      background: rgba(255, 255, 255, 0.9);
      border: none;
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      width: 100%;
      max-height: 90vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    .register-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 150%;
      height: 140px;
      background: url('img/pastel_wave.svg') no-repeat bottom center;
      background-size: cover;
      opacity: 0.15;
      transform: translateX(-25%);
    }
    .register-card .card-body {
      padding: 3rem 1.5rem 1.5rem;
      position: relative;
      z-index: 1;
      overflow-y: auto;
    }

    /* =================
       Sección del Logo
       ================= */
    .logo-section {
      position: absolute;
      top: -50px;
      left: 50%;
      transform: translateX(-50%);
      background: #fff;
      border-radius: 50%;
      padding: 8px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
      z-index: 2;
      width: 90px;
      height: 90px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .logo-section img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      border-radius: 50%;
    }

    /* =======
       Título
       ======= */
    .register-title {
      margin-top: 60px;
      margin-bottom: 1.2rem;
      font-weight: 700;
      color: #6f42c1;
      text-align: center;
      letter-spacing: 1px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
      font-size: 1.75rem;
    }

    /* ========================================
       Floating Labels con Etiquetas Visible
       y Corrección de “tapado” de texto
       ======================================== */
    .form-floating > .form-control {
      border: 2px solid #e83e8c;
      padding: 1.5rem 1rem 0.5rem 1rem;
      border-radius: 8px;
      background: transparent;
      transition: border-color 0.3s, box-shadow 0.3s;
      font-size: 0.95rem;
    }
    .form-floating > .form-control:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
      background: #fff;
    }
    .form-floating > label {
      position: absolute;
      top: 0;
      left: 0;
      padding: 1rem 1rem 0.5rem;
      pointer-events: none;
      color: #6f42c1;
      transition: transform 0.3s, color 0.3s, font-size 0.3s;
      transform-origin: left top;
      font-size: 0.95rem;
    }
    /* El input debe tener placeholder="" para permitir flotar correctamente */
    .form-floating > .form-control::placeholder {
      color: transparent;
    }
    /* Etiqueta flota cuando el input está enfocado */
    .form-floating > .form-control:focus ~ label {
      transform: translateY(-0.75rem) scale(0.85);
      color: #5930a4;
      font-size: 0.85rem;
    }
    /* Etiqueta flota cuando el usuario ya escribió (campo no está vacío) */
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
      transform: translateY(-0.75rem) scale(0.85);
      color: #5930a4;
      font-size: 0.85rem;
    }

    /* ================
       Select Personalizado
       ================ */
    .form-select {
      border: 2px solid #e83e8c;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      transition: border-color 0.3s, box-shadow 0.3s;
      font-size: 0.95rem;
    }
    .form-select:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
    }

    /* =================
       Botón Registrar
       ================= */
    .btn-primary-custom {
      background: linear-gradient(135deg, #e83e8c, #6f42c1);
      border: none;
      border-radius: 8px;
      font-weight: 600;
      padding: 0.65rem;
      color: #fff;
      transition: background 0.3s, transform 0.2s;
      width: 100%;
      font-size: 1rem;
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

    /* ================
       Enlaces Secundarios
       ================ */
    .link-secondary {
      color: #6f42c1;
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }
    .link-secondary:hover {
      color: #5930a4;
      text-decoration: underline;
    }

    /* ================
       Pie de Página
       ================ */
    .footer-text {
      font-size: 0.75rem;
      color: #858796;
      text-align: center;
      margin-top: 1rem;
      padding-bottom: 1rem;
    }

    @media (max-width: 576px) {
      .register-card {
        margin: 0.5rem;
        max-height: 95vh;
      }
      .register-card::before {
        height: 100px;
      }
      .logo-section {
        width: 70px;
        height: 70px;
        top: -35px;
      }
      .register-title {
        margin-top: 50px;
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="bg-shapes"></div>

  <div class="register-wrapper">
    <div class="register-card card">

      <!-- ===== SECCIÓN DEL LOGO ===== -->
      <div class="logo-section">
        <!-- Reemplaza 'img/logo.png' por la ruta de tu logo -->
        <img src="img/logo.png" alt="Logo EducaSex" />
      </div>
      <!-- ===== FIN SECCIÓN LOGO ===== -->

      <div class="card-body">
        <h2 class="register-title">Registro de Usuario</h2>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (!empty($errorMsg)): ?>
          <div class="alert alert-danger py-2">
            <?= htmlspecialchars($errorMsg) ?>
          </div>
        <?php endif; ?>

        <!-- Formulario de Registro en formato horizontal (dos columnas) -->
        <form method="post" action="codigo.php">
          <div class="row g-3">
            <!-- Documento -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control"
                  id="documento"
                  name="documento"
                  placeholder=""
                  required
                  pattern="\d{7,11}"
                  minlength="7"
                  maxlength="11"
                  title="Ingrese entre 7 y 11 dígitos numéricos"
                />
                <label for="documento"><i class="fas fa-id-card me-2"></i>Documento</label>
              </div>
            </div>

            <!-- Tipo de Documento -->
            <div class="col-md-6">
              <label class="form-label text-muted"><i class="fas fa-file-alt me-2"></i>Tipo de Documento</label>
              <select
                id="tipo_documento"
                name="tipo_documento"
                class="form-select"
                required
              >
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="cedula">Cédula</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="ti">Tarjeta de Identidad</option>
                <option value="te">Tarjeta de Extranjería</option>
                <option value="otro">Otro</option>
              </select>
            </div>

            <!-- Primer Nombre -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control"
                  id="primer_nombre"
                  name="txt_primer_nombre"
                  placeholder=""
                  required
                />
                <label for="primer_nombre"><i class="fas fa-user me-2"></i>Primer Nombre</label>
              </div>
            </div>

            <!-- Segundo Nombre (opcional) -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control"
                  id="segundo_nombre"
                  name="txt_segundo_nombre"
                  placeholder=""
                />
                <label for="segundo_nombre"><i class="fas fa-user-circle me-2"></i>Segundo Nombre (opcional)</label>
              </div>
            </div>

            <!-- Primer Apellido -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control"
                  id="primer_apellido"
                  name="txt_primer_apellido"
                  placeholder=""
                  required
                />
                <label for="primer_apellido"><i class="fas fa-user me-2"></i>Primer Apellido</label>
              </div>
            </div>

            <!-- Segundo Apellido (opcional) -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control"
                  id="segundo_apellido"
                  name="txt_segundo_apellido"
                  placeholder=""
                />
                <label for="segundo_apellido"><i class="fas fa-user-circle me-2"></i>Segundo Apellido (opcional)</label>
              </div>
            </div>

            <!-- Teléfono -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="tel"
                  class="form-control"
                  id="telefono"
                  name="telefono"
                  placeholder=""
                  required
                />
                <label for="telefono"><i class="fas fa-phone me-2"></i>Teléfono</label>
              </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder=""
                  required
                />
                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
              </div>
            </div>

            <!-- Tipo de Usuario -->
            <div class="col-md-6">
              <label class="form-label text-muted"><i class="fas fa-user-tag me-2"></i>Tipo de Usuario</label>
              <select
                id="tipo_usuario"
                name="tipo_usuario"
                class="form-select"
                required
              >
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="1">Administrador</option>
                <option value="2">Operario</option>
                <option value="3">Asesor</option>
              </select>
            </div>

            <!-- Clave -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="password"
                  class="form-control"
                  id="clave"
                  name="clave"
                  placeholder=""
                  required
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Mínimo 8 caracteres, al menos 1 número, 1 minúscula y 1 mayúscula"
                />
                <label for="clave"><i class="fas fa-lock me-2"></i>Clave</label>
              </div>
            </div>

            <!-- Confirmar Clave -->
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="password"
                  class="form-control"
                  id="c_clave"
                  name="c_clave"
                  placeholder=""
                  required
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Mínimo 8 caracteres, al menos 1 número, 1 minúscula y 1 mayúscula"
                />
                <label for="c_clave"><i class="fas fa-lock me-2"></i>Confirmar Clave</label>
              </div>
            </div>
          </div>

          <!-- Botón Registrar en nueva fila completa -->
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" name="btnregistrar" class="btn btn-primary-custom btn-lg w-100">
                <i class="fas fa-user-plus me-2"></i>Registrar
              </button>
            </div>
          </div>

          <!-- Enlace para volver al login -->
          <div class="row mt-3">
            <div class="col-12 text-center">
              <a href="index.php" class="link-secondary">Volver al Login</a>
            </div>
          </div>
        </form>

        <!-- Pie de página -->
        <div class="footer-text">
          &copy; 2025 EducaSex. Todos los derechos reservados.
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
