
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
        DETALLE STOCK POR DEPOSITO
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table class="table table-bordered">
			    <tr>
                  <td class="alert alert-warning"><b>Nombre producto:</b>
                <?php echo $_GET["nombre"];?></td>
                </tr>
			  
			  
			     <tr>
                  <td class="alert alert-warning"><b>Codigo:</b>
                <?php echo $_GET["codigo"];?></td>
                </tr>
			   </table>
             <br><table class="table table-bordered table-hover">
                <thead>
                
                  <th>Cantidad</th>
              
				 
				 
                  <th>Depósito</th>
				
                 

                </thead>
              <?php
			 
			  $id_prod=0;
			  
         
			   $cant  = StockData::vercontenidos($_GET["product_id"]);
	          foreach($cant as $can){
	          $q1=$can->CANTIDAD_STOCK;
	          $id_dep=$can->DEPOSITO_ID;
			  $precio_com=$can->COSTO_COMPRA;
			  $id_prod=$can->PRODUCTO_ID ;
	
	                              
	
	          $deposit  = StockData::verdeposito($id_dep);
	          foreach($deposit as $dep){
	          $de=$dep->NOMBRE_DEPOSITO;
	                                   } 
			  
			  
					
              ?>
              <tr>
         
				 <td style="width:30px;"><?php echo $q1 ;?></td>
             
             
				
				  
				

				  
				
                <td style="width:30px;"> <?php echo $de;
				?></td>
				
				
				
              </tr>
              <?php
                }
                ?>
				
				
				
              </table>
              <br><br>
              <div class="row">
              <div class="col-md-4">
              <table class="table table-bordered">
              
             
              </table>
              </div>
              </div>
              <div class="box">
                    <div class="box-body">
                      <div class="box box-danger">
                      </div>
					  
					  
					  
                          </div>
                  </div>
                
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>