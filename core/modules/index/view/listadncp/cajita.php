<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper" style="height: 100vh;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class='fa  fa-laptop' style="color: orange;"></i>
      LISTA DE DNCP
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">

          <div class="box-body">
            <div class="table-responsive">
              <div class="box-header with-border">
                <a href="/index.php?view=nuevodncp&id_sucursal=<?= $_GET['id_sucursal'] ?>" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i> Nuevo</a>
              </div>

              <table id="example1" class="table table-bordered table-dark">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Modalidad</th>
                    <th>Entidad</th>
                    <th>Secuencia</th>
                    <th>Fecha</th>
                    <th></th>

                  </tr>
                </thead>
                <tbody id="tabla">
                  <?php
                  $credito = DNCPData::listar($_GET['id_sucursal']);
                  ?>
                  <?php foreach ($credito as $c): ?>
                    <tr>
                      <td><?= $c->id ?></td>
                      <td><?= $c->modalidad ?></td>
                      <td><?=

                          $c->entidad ?></td>
                      <td><?= $c->secuencia ?></td>
                      <td><?= $c->fecha ?></td>

                      <td>
                        <button onclick="eliminar(<?= $c->id ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button>
                        <a data-toggle="tooltip" data-placement="top" class="btn btn-info btn-sm" href="/index.php?view=editardncp&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id=<?= $c->id ?>">
                          <i style="color:#fff" class="glyphicon glyphicon-edit"></i>
                        </a>

                      </td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

<script>
  function eliminar(venta) {
    Swal.fire({
      title: 'Desea eliminar dncp',
      showDenyButton: true,
      confirmButtonText: 'Eliminar',
      denyButtonText: `Cerrar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = `./index.php?action=eliminardncp&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

      } else {}
    })
  }
</script>