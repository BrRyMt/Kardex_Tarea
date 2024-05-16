<?php require_once "../../header.php" ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Colaboradores</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Registro de Colaboradores</li>
  </ol>
  <div class="card mb-4">
    <div class="card-header">
      Complete los datos
    </div>
    <div class="card-body">
      <form action="" id="form-registrarcolaborador">

        <div class="row g-2">
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" id="apepaterno" maxlength="60" required>
              <label for="apepaterno">Apellido Paterno</label>
            </div>
          </div>
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" id="apepmaterno" maxlength="60" required>
              <label for="apepmaterno">Apellido Materno</label>
            </div>
          </div>
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" id="nombres" maxlength="80" required>
              <label for="nombres">Nombres</label>
            </div>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="tel" class="form-control" id="nrodocumento" maxlength="8" minlength="8" pattern="[0-9]+" title="Solo numeros" required autofocus>
              <label for="nrodocumento">Nro° documento</label>
            </div>
          </div>
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="tel" class="form-control" id="telprincipal" maxlength="9" required>
              <label for="telprincipal">Telefono Principal</label>
            </div>
          </div>
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="tel" class="form-control" id="telsecundario" maxlength="9">
              <label for="telsecundario">Telefono Secundario</label>
            </div>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-md mb-2">
            <div class="form-floating">
              <select name="idrol" id="idrol" class="form-select" required>
                <option value="">Seleccione un Rol</option>

              </select>
              <label for="idrol">Rol</label>
            </div>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" id="nomusuario" maxlength="100" required>
              <label for="nomusuario">Nombre de Usuario</label>
            </div>
          </div>
          <div class="col-md mb-2">
            <div class="form-floating">
              <input type="password" class="form-control" id="passusuario" maxlength="60" minlength="8" required>
              <label for="passusuario">Contraseña</label>
            </div>
          </div>
        </div>

        <div class="text-end">
          <button class="btn btn-primary btn-sm" type="submit" id="registrarcolaborador">Registrar Colaborador</button>
          <button class="btn btn-secondary btn-sm" type="reset">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once "../../footer.php"; ?>

<script>
  document.addEventListener("DOMContentLoaded", () => {

    const formcollab = document.getElementById('form-registrarcolaborador');

    const apepaterno = document.getElementById('apepaterno').value;
    const apepmaterno = document.getElementById('apepmaterno').value;
    const nombres = document.getElementById('nombres').value;
    const nrodocumento = document.getElementById('nrodocumento').value;
    const telprincipal = document.getElementById('telprincipal').value;
    const telsecundario = document.getElementById('telsecundario').value;

    const idrol = document.getElementById('idrol').value;
    const nomusuario = document.getElementById('nomusuario').value;
    const passusuario = document.getElementById('passusuario').value;

    (() => {
      fetch(`../../controllers/Roles.controller.php?operacion=getAllRL`)
        .then(response => response.text())
        .then(data => {
          console.log(data)
          const selectProducto = document.getElementById('idrol');
          data.forEach(rol => {
            const option = document.createElement('option');
            option.value = rol.idrol;
            option.textContent = rol.rol;
            selectProducto.appendChild(option);
          });
        })
        .catch(error => console.error('Error:', error));
    })();
  })
</script>

</body>

</html>