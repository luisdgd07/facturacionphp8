  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-institution' style="color: orange;"></i>
        CONFIGURACION
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <div class="table-responsive">
              <?php
                $users = ConfigData::getAll();
                if(count($users)>0){
                  ?>
              <table id="example" class="table table-bordered table-dark" style="width:100%">
                <thead>
                </thead>
                <tbody>
                   <?php
                    foreach($users as $user){
                    ?>
                  <tr style="width: 100%">
                  <center >
                    <a  class="btn btn-lg btn-warning img-responsive" href="index.php?view=configuracion&id_empresa=<?php echo $user->id_empresa;?>">
                      <i class="fa fa-cog fa-spin fa-5x  pull-left"></i>CONFIGURACION GENERAL DEL SISTEMA <br>Portal de Administración.
                    </a>
                  </center>
                  </tr>
                <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Datos de la Institucion Registrados</p>";
                }
                ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>