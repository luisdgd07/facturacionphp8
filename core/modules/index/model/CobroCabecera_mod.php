<?php
class CobroCabecera
{
    public static $tablename = "cobro_cabecera";

    public $COBRO_ID;
    public $NIVEL1;
    public $NIVEL2;
    public $RECIBO;
    public $FECHA_COBRO;
    public $CLIENTE_ID;
    public $TOTAL_COBRO;
    public $SUCURSAL_ID;
    public $MONEDA_ID;
    public $COMENTARIO;
    public $configfactura_id;
    public $anulado;
    public $ID_COBRANZA;

    public function __construct()
    {
        $this->FECHA_COBRO = date('Y-m-d');
        $this->anulado = 0;
        $this->NIVEL1 = $this->NIVEL1 ?? 1;
        $this->NIVEL2 = $this->NIVEL2 ?? 1;
    }

    public function registro()
    {
        $RECIBO           = addslashes($this->RECIBO);
        $FECHA_COBRO      = addslashes($this->FECHA_COBRO);
        $CLIENTE_ID       = (int)$this->CLIENTE_ID;
        $TOTAL_COBRO      = ($this->TOTAL_COBRO === null || $this->TOTAL_COBRO === '') ? 'NULL' : floatval(str_replace(',', '', $this->TOTAL_COBRO));
        $SUCURSAL_ID      = (int)$this->SUCURSAL_ID;
        $MONEDA_ID        = (int)$this->MONEDA_ID;
        $COMENTARIO       = isset($this->COMENTARIO) ? addslashes($this->COMENTARIO) : '';
        $configfactura_id = ($this->configfactura_id === null || $this->configfactura_id === '') ? 'NULL' : (int)$this->configfactura_id;
        $anulado          = (int)($this->anulado ?? 0);
        $NIVEL1           = (int)($this->NIVEL1 ?? 1);
        $NIVEL2           = (int)($this->NIVEL2 ?? 1);
        $ID_COBRANZA      = ($this->ID_COBRANZA === null || $this->ID_COBRANZA === '') ? 'NULL' : (int)$this->ID_COBRANZA;

        $sql = "INSERT INTO ".self::$tablename." (
                    NIVEL1, NIVEL2, RECIBO, FECHA_COBRO, CLIENTE_ID,
                    TOTAL_COBRO, SUCURSAL_ID, MONEDA_ID, COMENTARIO,
                    configfactura_id, anulado, ID_COBRANZA
                ) VALUES (
                    {$NIVEL1}, {$NIVEL2}, '{$RECIBO}', '{$FECHA_COBRO}', {$CLIENTE_ID},
                    {$TOTAL_COBRO}, {$SUCURSAL_ID}, {$MONEDA_ID}, '{$COMENTARIO}',
                    {$configfactura_id}, {$anulado}, {$ID_COBRANZA}
                )";
        Executor::doit($sql);
        if (method_exists('Executor', 'lastInsertId')) {
            $this->COBRO_ID = Executor::lastInsertId();
        } else {
            $q = Executor::doit("SELECT LAST_INSERT_ID() AS id");
            if ($q && isset($q[0])) {
                $row = Model::one($q[0], new stdClass());
                $this->COBRO_ID = isset($row->id) ? $row->id : null;
            }
        }
        return $this->COBRO_ID;
    }

    public static function getultimoCobro()
    {
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY COBRO_ID DESC LIMIT 1";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return null;
        }
        return Model::one($query[0], new CobroCabecera());
    }

    public static function getById($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM ".self::$tablename." WHERE COBRO_ID = {$id} LIMIT 1";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return null;
        }
        return Model::one($query[0], new CobroCabecera());
    }

    public static function obtenerCobro($recibo)
    {
        $recibo = addslashes($recibo);
        $sql = "SELECT * FROM ".self::$tablename." WHERE RECIBO = '{$recibo}'";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return [];
        }
        return Model::many($query[0], new CobroCabecera());
    }

    public static function eliminarVentaCliente($factura, $cliente)
    {
        $factura = addslashes($factura);
        $cliente = (int)$cliente;
        $sql = "DELETE FROM ".self::$tablename." WHERE RECIBO = '{$factura}' AND CLIENTE_ID = {$cliente}";
        return Executor::doit($sql);
    }

// === NUEVO: Registrar Tarjeta para un Cobro (cabecera única + N detalles) ===
public static function registrarTarjetaParaCobro($id_cobro, $tablaCobro, $moneda_id = 0) {
    $items = is_array($tablaCobro) ? $tablaCobro : [];
    if (!$items) { return; }

    // Filtrar pagos con tarjeta
    $tarjetas = [];
    foreach ($items as $it) {
        if (isset($it['tipo_id']) && (int)$it['tipo_id'] === 1) { $tarjetas[] = $it; }
    }
    if (!$tarjetas) { return; }

    // Total y moneda
    $totalTarjeta = 0.0;
    $moneda = (int)$moneda_id;
    if (!$moneda && isset($tarjetas[0]['moneda_id'])) { $moneda = (int)$tarjetas[0]['moneda_id']; }
    foreach ($tarjetas as $p) {
        if (isset($p['monto']))      { $totalTarjeta += (float)str_replace(',', '', $p['monto']); }
        elseif (isset($p['monto2'])) { $totalTarjeta += (float)str_replace(',', '', $p['monto2']); }
    }

    // Crear o actualizar cabecera (importetotal)
    $q = Executor::doit("SELECT id_tarjeta FROM tarjeta_cabecera WHERE tarjeta_id = ".((int)$id_cobro)." LIMIT 1");
    $row = (isset($q[0]) ? mysqli_fetch_assoc($q[0]) : null);
    if ($row && isset($row['id_tarjeta'])) {
        $idTarjetaCabecera = (int)$row['id_tarjeta'];
        // limpiar detalles existentes
        Executor::doit("DELETE FROM tarjeta_detalle WHERE tarjeta_id = {$idTarjetaCabecera}");
        // actualizar total + moneda + fecha
        Executor::doit("UPDATE tarjeta_cabecera 
                           SET importetotal = ".((float)$totalTarjeta).", 
                               moneda_id = ".((int)$moneda).", 
                               fecha = CURDATE()
                         WHERE id_tarjeta = {$idTarjetaCabecera}");
    } else {
        // insertar cabecera
        Executor::doit("INSERT INTO tarjeta_cabecera (tarjeta_id, transaccion, importetotal, fecha, moneda_id)
                        VALUES (".((int)$id_cobro).", ".count($tarjetas).", ".((float)$totalTarjeta).", CURDATE(), ".((int)$moneda).")");
        // recuperar id
        $q2 = Executor::doit("SELECT id_tarjeta FROM tarjeta_cabecera WHERE tarjeta_id = ".((int)$id_cobro)." ORDER BY id_tarjeta DESC LIMIT 1");
        $row2 = (isset($q2[0]) ? mysqli_fetch_assoc($q2[0]) : null);
        if (!$row2 || !isset($row2['id_tarjeta'])) { throw new Exception('No se pudo obtener id_tarjeta de tarjeta_cabecera.'); }
        $idTarjetaCabecera = (int)$row2['id_tarjeta'];
    }

    // Insertar detalles
    foreach ($tarjetas as $pago) {
        $monto = 0.0;
        if (isset($pago['monto']))      { $monto = (float)str_replace(',', '', $pago['monto']); }
        elseif (isset($pago['monto2'])) { $monto = (float)str_replace(',', '', $pago['monto2']); }

        $vaucher = isset($pago['vaucher']) ? addslashes($pago['vaucher']) : '';
        $procesadora = isset($pago['tipo_tar']) ? (int)$pago['tipo_tar'] : 0;
        $tipo = isset($pago['tarjeta']) ? (int)$pago['tarjeta'] : 0;

        $sqlDet = "INSERT INTO tarjeta_detalle (tarjeta_id, transaccion, numero_vaucher, procesadora_id, importe, tipo)
                   VALUES ({$idTarjetaCabecera}, ".((int)$id_cobro).", '{$vaucher}', {$procesadora}, ".((float)$monto).", {$tipo})";
        Executor::doit($sqlDet);
    }
}

}
