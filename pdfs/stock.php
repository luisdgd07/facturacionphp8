<?php
include "./PDF.php";
$pdf = new PDF();
// $sd = date($_GET['sd']);
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de productos desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);
$operationData = "";
if ($_GET['categoria'] == 'todos' && $_GET['producto'] == 'todos') {

    $operationData = ProductoData::verproductosucursal($_GET['id_sucursal']);
} else if ($_GET['categoria'] != 'todos' && $_GET['producto'] == 'todos') {
    $operationData = ProductoData::verproductoscate($_GET['categoria']);
} else if ($_GET['producto'] != 'todos') {
    $operationData = ProductoData::getProducto2($_GET['producto']);
}
$k = 0;
foreach ($operationData as $op) {
    $opert = OperationData::getByProductoId4($_GET['id_sucursal'], $op->id_producto, $_GET['sd'], $_GET['ed']);
    if (isset($opert[0]) === true) {

        $stocks2 = StockData::vercontenidos($op->id_producto);
        $concepto = ProductoData::categorian($op->categoria_id);

        foreach ($concepto as $cambios) {
            if ($cambios) {
                $categ = $cambios->nombre;
            }
        }
        $opr[$k] = array('CODIGO', 'PRODUCTO', 'STOCK', 'ALMACEN');
        $k++;

        echo $op->codigo;
        echo $op->nombre;
        $stock = StockData::vercontenidos2($op->id_producto);
        echo $stock->CANTIDAD_STOCK;
        $concepto = ProductoData::deposito($stock->DEPOSITO_ID);

        foreach ($concepto as $cambios) {
            if ($cambios) {
                $camnbio = $cambios->NOMBRE_DEPOSITO;
            }
        }
        $opr[$k] = array($op->codigo, $op->nombre, $stock->CANTIDAD_STOCK, $camnbio);
        $k++;
        $nuevafecha =  date($_GET["sd"]);
        $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
        $opertAnte = OperationData::getByProductoId4($_GET['id_sucursal'], $op->id_producto, '2022-12-27', $n);


        $anterior = $stock->CANTIDAD_STOCK;
        $opr[$k] = array('FECHA', 'ENTRADA', 'SALIDA', 'STOCK');
        $k++;
        if ($opert > 0) {
            foreach ($opert as $op) {
                // echo $op->fecha;
                if ($op->accion_id == 1) {
                    $anterior -= $op->q;

                    // echo  $op->q;
                } else if ($op->accion_id == 2) {
                    $anterior += $op->q;
                }
            }
        }

        $ante1 = 0;
        $ante2 = 0;
        $ante3 = 0;
        if (isset($opertAnte[0])) {
            // foreach ($opert as $op) {
            if ($opertAnte[0]->accion_id == 1) {
                $anterior -= $opertAnte[0]->q;

                // echo  $opertAnte[0]->q;
            } else if ($opertAnte[0]->accion_id == 2) {
                $anterior += $opertAnte[0]->q;

                // echo  $opertAnte[0]->q;
            }
            if ($opertAnte[0]->accion_id == 1) {
                $anterior += $opertAnte[0]->q;
            } else if ($opertAnte[0]->accion_id == 2) {
                $anterior -= $opertAnte[0]->q;
            }
            // echo $anterior;
            if ($opertAnte[0]->accion_id == 1) {
                $opr[$k] = array('Anterior', $opertAnte[0]->q, '0,00', $anterior);
            } else if ($opertAnte[0]->accion_id == 2) {
                $opr[$k] = array('Anterior', '0,00', $opertAnte[0]->q,  $anterior);
            }
            $k++;
            // }
        } else {
            $opr[$k] = array('Anterior', '0,00', '0,00', '0,00');
            $k++;
        }
        // if ($opert > 0) {
        $opert = array_reverse($opert);
        $total1 = 0;
        $total2 = 0;

        foreach ($opert as $op) {
            //  echo $op->fecha; 
            if ($op->accion_id == 1) {
                $anterior += $op->q;
                $total1 += $op->q;
                // echo  $op->q; 
            } else if ($op->accion_id == 2) {
                $anterior -= $op->q;
                $total2 += $op->q;
                // echo  $op->q; 
            }
            //  echo $anterior;
            if ($op->accion_id == 1) {
                $opr[$k] = array($op->fecha, $op->q, '0,00', $anterior);
            } else if ($op->accion_id == 2) {
                $opr[$k] = array($op->fecha, '0,00', $op->q,  $anterior);
            }
            $k++;
        }
        $opr[$k] = array("Total:", $total1, $total2, '');
        $k++;
    }
}
$width = [40, 55, 40, 40, 18, 18, 18, 18, 20, 15];
$rows = [];
$total = 0;
$totall = 0;
$total = 0;
$totall = 0;
$sucur = SuccursalData::VerId($_GET["id_sucursal"]);
$total = 0;
$totalg = 0;
$totali = 0;
$totalg5 = 0;
$totalii5 = 0;
$totalexent = 0;
$totalusd = 0;
$totalcajas = 0;
$cambio = 0;
$j = 0;
$k = 0;
// var_dump($opr);
$pdf->imprimirReporte([], $width, $opr, false);
$pdf->Output();
