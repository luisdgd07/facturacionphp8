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
    public $ventaId;
    public $notaCreditoId;
    public function __construct()
    {
        $this->FECHA_COBRO = date('Y-m-d');
        $this->anulado = 0;
        $this->NIVEL1 = $this->NIVEL1 ?? 1;
        $this->NIVEL2 = $this->NIVEL2 ?? 1;
    }

    public function registro()
    {
        $RECIBO = addslashes($this->RECIBO);
        $FECHA_COBRO = addslashes($this->FECHA_COBRO);
        $CLIENTE_ID = (int) $this->CLIENTE_ID;
        $TOTAL_COBRO = ($this->TOTAL_COBRO === null || $this->TOTAL_COBRO === '') ? 'NULL' : floatval(str_replace(',', '', $this->TOTAL_COBRO));
        $SUCURSAL_ID = (int) $this->SUCURSAL_ID;
        $MONEDA_ID = (int) $this->MONEDA_ID;
        $COMENTARIO = isset($this->COMENTARIO) ? addslashes($this->COMENTARIO) : '';
        $configfactura_id = ($this->configfactura_id === null || $this->configfactura_id === '') ? 'NULL' : (int) $this->configfactura_id;
        $anulado = (int) ($this->anulado ?? 0);
        $NIVEL1 = (int) ($this->NIVEL1 ?? 1);
        $NIVEL2 = (int) ($this->NIVEL2 ?? 1);
        $ID_COBRANZA = ($this->ID_COBRANZA === null || $this->ID_COBRANZA === '') ? 'NULL' : (int) $this->ID_COBRANZA;
        $ventaId = ($this->ventaId ?? 'null');
        $notaCreditoId = ($this->notaCreditoId ?? 'null');

        $sql = "INSERT INTO " . self::$tablename . " (
                    NIVEL1, NIVEL2, RECIBO, FECHA_COBRO, CLIENTE_ID,
                    TOTAL_COBRO, SUCURSAL_ID, MONEDA_ID, COMENTARIO,
                    configfactura_id, anulado, ID_COBRANZA, id_venta, id_nota_credito 
                ) VALUES (
                    {$NIVEL1}, {$NIVEL2}, '{$RECIBO}', '{$FECHA_COBRO}', {$CLIENTE_ID},
                    {$TOTAL_COBRO}, {$SUCURSAL_ID}, {$MONEDA_ID}, '{$COMENTARIO}',
                    {$configfactura_id}, {$anulado}, {$ID_COBRANZA}, {$ventaId}, {$notaCreditoId}
                )";
        Executor::doit($sql);
        if (method_exists('Executor', 'lastInsertId')) {
            $this->COBRO_ID = Executor::lastInsertId();
        } else {
            $q = Executor::doit("SELECT LAST_INSERT_ID() AS id");
            if ($q && isset($q[0])) {
                $row = Model::one($q[0], "CobroCabecera");
                $this->COBRO_ID = isset($row->id) ? $row->id : null;
            }
        }
        return $this->COBRO_ID;
    }

    public static function getultimoCobro()
    {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY COBRO_ID DESC LIMIT 1";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return null;
        }
        return Model::one($query[0], new CobroCabecera());
    }

    public static function getById($id)
    {
        $id = (int) $id;
        $sql = "SELECT * FROM " . self::$tablename . " WHERE COBRO_ID = {$id} LIMIT 1";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return null;
        }
        return Model::one($query[0], new CobroCabecera());
    }

    public static function obtenerCobro($recibo)
    {
        $recibo = addslashes($recibo);
        $sql = "SELECT * FROM " . self::$tablename . " WHERE RECIBO = '{$recibo}'";
        $query = Executor::doit($sql);
        if (!$query || !isset($query[0])) {
            return [];
        }
        return Model::many($query[0], new CobroCabecera());
    }

    public static function eliminarVentaCliente($factura, $cliente)
    {
        $factura = addslashes($factura);
        $cliente = (int) $cliente;
        $sql = "DELETE FROM " . self::$tablename . " WHERE RECIBO = '{$factura}' AND CLIENTE_ID = {$cliente}";
        return Executor::doit($sql);
    }
}
