<!-- Secciones del documentos PDF -->

<page backbottom="6mm" >
  <page_header>
      <span>Reporte General</span>
  </page_header>
  <page_footer>
      <div class="text-end ">PAGINA: [[page_cu]]/[[page_nb]]</div>
  </page_footer>
</page>

<!-- Tabla para los resultados del procedimiento sp_filtrar_kardex_por_producto -->
<h1 class="text-xl text-center mt-5 mb-3">Resultados</h1>
<table class="table mt-3">
  <colgroup>
    <col style="width: 10%;"> <!-- ID Almacén -->
    <col style="width: 15%;"> <!-- Fecha de Registro -->
    <col style="width: 15%;"> <!-- Producto -->
    <col style="width: 10%;"> <!-- Modelo -->
    <col style="width: 10%;"> <!-- Tipo de Movimiento -->
    <col style="width: 10%;"> <!-- Cantidad -->
    <col style="width: 10%;"> <!-- Stock Actual -->
    <col style="width: 10%;"> <!-- Usuario -->
    <col style="width: 8%;"> <!-- Rol -->
  </colgroup>
  <thead>
    <tr class="bg-danger text-light">
      <th>ID Almacén</th>
      <th>Fecha de Registro</th>
      <th>Producto</th>
      <th>Modelo</th>
      <th>Tipo de Movimiento</th>
      <th>Cantidad</th>
      <th>Stock Actual</th>
      <th>Usuario</th>
      <th>Rol</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($datoskr as $row): ?>
      <tr>
        <td><?php echo $row['idalmacen']; ?></td>
        <td><?php echo $row['fecharegistro']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['modelo']; ?></td>
        <td><?php echo $row['tipomovimiento']; ?></td>
        <td><?php echo $row['cantidad']; ?></td>
        <td><?php echo $row['stockactual']; ?></td>
        <td><?php echo $row['nomusuario']; ?></td>
        <td><?php echo $row['rol']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
