<?php require_once "../../header.php" ?>

<div class="container mt-5">
    <h2>Kardex</h2>

    <!-- Formulario para registrar movimiento -->
    <div class="card">
        <div class="card-header">Registrar Movimiento</div>
        <div class="card-body">
            <form action="#" method="POST" id="form-kardex">
                <div class="row">
                    <div class="col">
                        <label for="idproducto">Producto:</label>
                        <select class="form-control" id="idproducto" name="idproducto" required>
                            <!-- OPTIONS WILL BE LOADED BY JS -->
                        </select>
                    </div>
                    <div class="col">
                        <label for="tipomovimiento">Tipo de Movimiento:</label>
                        <select class="form-control" id="tipomovimiento" name="tipomovimiento" required>
                            <option value="ENT">Entrada</option>
                            <option value="SAL">Salida</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mt-4">Registrar Movimiento</button>
                        <button type="button" class="btn btn-secondary mt-4" data-toggle="modal" data-target="#reportModal">Reporte</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<div class="container">
    <div class="card">
        <div class="card-header">Kardex</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Almacén</th>
                            <th>Fecha de Registro</th>
                            <th>Producto</th>
                            <th>Modelo</th>
                            <th>Tipo de Movimiento</th>
                            <th>Cantidad</th>
                            <th>Stock Actual</th>
                            <th>Colaborador</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-kardex">
                        <!-- Filas de la tabla serán cargadas con JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para los reportes -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Generar Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para generar el reporte -->
                <form action="" method="" id="form-modal-pdf">
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <select class="form-control" id="producto" name="producto">
                            <!-- opciones-->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidadlimit">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidadlimit" name="cantidadlimit" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Generar Reporte</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php require_once "../../footer.php"; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formkrd = document.getElementById("form-kardex");
        const limit = document.getElementById("cantidadlimit");
        const nms = document.getElementById("producto");

        function cargarKardex() {
            fetch('../../controllers/Kardex.controller.php?operacion=getAll')
                .then(response => response.json())
                .then(data => {
                    const tablaKardex = document.getElementById('tabla-kardex');
                    tablaKardex.innerHTML = '';
                    data.forEach(registro => {
                        const row = `
                        <tr>
                            <td>${registro.idalmacen}</td>
                            <td>${registro.fecharegistro}</td>
                            <td>${registro.producto}</td>
                            <td>${registro.modelo}</td>
                            <td>${registro.tipomovimiento}</td>
                            <td>${registro.cantidad}</td>
                            <td>${registro.stockactual}</td>
                            <td>${registro.nomusuario}</td>
                            <td>${registro.rol}</td>
                        </tr>
                    `;
                        tablaKardex.innerHTML += row;
                    });
                })
                .catch(error => console.error('Error:', error));
        }


        (() => {
            fetch(`../../controllers/Producto.controller.php?operacion=getAll`)
                .then(response => response.json())
                .then(data => {
                    const selectProducto = document.getElementById('idproducto');
                    data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.idproducto;
                        option.textContent = producto.descripcion;
                        selectProducto.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        })();

        formkrd.addEventListener("submit", (event) => {
            event.preventDefault();
            console.log(<?= $_SESSION['login']["idcolaboradores"]; ?>);
            const params = new FormData();
            params.append('operacion', 'addmv');
            params.append('idcolaborador', <?= $_SESSION['login']["idcolaboradores"]; ?>);
            params.append('idproducto', document.querySelector("#idproducto").value);
            params.append('tipomovimiento', document.querySelector("#tipomovimiento").value);
            params.append('cantidad', document.querySelector("#cantidad").value);
            fetch('../../controllers/Kardex.controller.php', {
                    method: 'POST',
                    body: params
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    formkrd.reset();
                    cargarKardex();
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        });

        $('#reportModal').on('show.bs.modal', function(event) {
            const selectProductoModal = document.getElementById('producto');
            selectProductoModal.innerHTML = '';
            fetch(`../../controllers/Producto.controller.php?operacion=getAll`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(producto => {
                        const optionModal = document.createElement('option');
                        optionModal.value = producto.idproducto;
                        optionModal.textContent = producto.descripcion;
                        selectProductoModal.appendChild(optionModal);
                    });
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById("form-modal-pdf").addEventListener("submit", (event) => {
            event.preventDefault()
            window.open(`../../views/reportes/reporte.php?producto=${nms.options[nms.selectedIndex].text}&limit_n=${limit.value}`, '_blank');
        })

        cargarKardex();
    })
</script>

</body>

</html>