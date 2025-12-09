<?php
// cajita_unica_accion.php
// Vista de cobro con un solo endpoint (procesoventaproducto1)
// Incluye mejoras básicas para móviles y el modal de métodos de pago.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cobro de Venta</title>
  <style>
    :root{--gap:12px;}
    *{box-sizing:border-box}
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,'Helvetica Neue',Arial,'Noto Sans',sans-serif;margin:0;padding:16px;background:#f7f7fb;color:#222}
    .container{max-width:980px;margin:0 auto}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:16px;box-shadow:0 10px 20px rgba(0,0,0,.04)}
    h1{font-size:20px;margin:0 0 12px}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--gap)}
    .grid .col{display:flex;flex-direction:column}
    label{font-size:12px;color:#555;margin-bottom:6px}
    input,select,button,textarea{padding:10px;border:1px solid #d1d5db;border-radius:10px;font-size:14px;background:#fff}
    input:focus,select:focus,textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.15)}
    .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:12px}
    .btn{border:none;border-radius:999px;padding:10px 16px;cursor:pointer}
    .btn-primary{background:#4f46e5;color:#fff}
    .btn-secondary{background:#e5e7eb;color:#111}
    .btn-danger{background:#ef4444;color:#fff}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:left}
    th{font-size:12px;color:#666;text-transform:uppercase;letter-spacing:.04em}
    .right{text-align:right}
    .chip{background:#eef2ff;color:#3730a3;border-radius:999px;padding:4px 8px;font-size:12px}
    @media (max-width: 900px){
      .grid{grid-template-columns:1fr 1fr}
    }
    @media (max-width: 620px){
      .grid{grid-template-columns:1fr}
      .actions{justify-content:space-between}
      table{font-size:13px}
      th,td{padding:8px}
      .hide-sm{display:none}
    }
    /* Modal */
    .modal{position:fixed;inset:0;background:rgba(0,0,0,.4);display:none;align-items:center;justify-content:center;padding:16px}
    .modal.open{display:flex}
    .modal-card{background:#fff;border-radius:16px;max-width:680px;width:100%;padding:16px}
    .pay-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:var(--gap);margin-top:12px}
    @media (max-width:820px){.pay-grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:520px){.pay-grid{grid-template-columns:1fr}}
    .pay-row{display:grid;grid-template-columns:2fr 1fr 2fr 2fr 1fr 1fr;gap:var(--gap);align-items:center}
    @media (max-width:820px){.pay-row{grid-template-columns:1fr 1fr 1fr 1fr 1fr 1fr}}
    @media (max-width:520px){.pay-row{grid-template-columns:1fr 1fr}}
    .muted{color:#6b7280}
  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <h1>Registrar Cobro</h1>
    <div class="grid">
      <div class="col">
        <label>Cliente</label>
        <input id="cliente" type="number" placeholder="ID Cliente">
      </div>
      <div class="col">
        <label>Sucursal</label>
        <input id="sucursal" type="number" placeholder="ID Sucursal">
      </div>
      <div class="col">
        <label>Fecha</label>
        <input id="fecha" type="date">
      </div>
      <div class="col">
        <label>Moneda</label>
        <select id="moneda_id">
          <option value="32">PYG (32)</option>
          <option value="1">USD (1)</option>
        </select>
      </div>
      <div class="col">
        <label>Concepto</label>
        <input id="concepto" type="text" placeholder="Detalle del cobro">
      </div>
      <div class="col">
        <label>Total</label>
        <input id="total" type="number" step="0.01" placeholder="0.00">
      </div>
    </div>
    <div class="actions">
      <button class="btn btn-secondary" onclick="openModal()">Agregar métodos de pago</button>
      <span class="chip">Métodos: <span id="cantPagos">0</span></span>
      <div style="flex:1"></div>
      <button class="btn btn-primary" onclick="finalizarCobro()">Finalizar y Registrar</button>
    </div>

    <table id="tablaPagosTbl">
      <thead>
        <tr>
          <th>Tipo</th>
          <th class="right">Monto</th>
          <th class="hide-sm">Moneda</th>
          <th class="hide-sm">Voucher</th>
          <th class="hide-sm">Procesadora</th>
          <th class="right">Acción</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th>Total tarjeta</th>
          <th class="right" id="totalTarjeta">0</th>
          <th colspan="4"></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- Modal -->
<div id="modal" class="modal" role="dialog" aria-modal="true">
  <div class="modal-card">
    <h2 style="margin:0 0 8px">Agregar método de pago</h2>
    <p class="muted" style="margin:0 0 12px">Elegí el tipo, completá los datos y agregá. Podés agregar varios y se sumarán.</p>
    <div class="pay-grid">
      <div class="col">
        <label>Tipo</label>
        <select id="tipo_id">
          <option value="1">Tarjeta</option>
          <option value="2">Transferencia/Cta.</option>
          <option value="3">Cheque</option>
        </select>
      </div>
      <div class="col">
        <label>Monto</label>
        <input id="monto" type="number" step="0.01" placeholder="0.00">
      </div>
      <div class="col">
        <label>Moneda</label>
        <select id="moneda">
          <option value="32">PYG (32)</option>
          <option value="1">USD (1)</option>
        </select>
      </div>
      <div class="col">
        <label>N° Voucher</label>
        <input id="vaucher" type="text" placeholder="opcional">
      </div>
      <div class="col">
        <label>Procesadora</label>
        <select id="tipo_tar">
          <option value="1">Crédito</option>
          <option value="2">Débito</option>
        </select>
      </div>
      <div class="col">
        <label>Tipo Tarjeta</label>
        <select id="tarjeta">
          <option value="1">Visa</option>
          <option value="2">Mastercard</option>
        </select>
      </div>
    </div>
    <div class="actions">
      <button class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
      <div style="flex:1"></div>
      <button class="btn btn-primary" onclick="agregarPago()">Agregar</button>
    </div>
  </div>
</div>

<script>
  const pagos = [];
  function openModal(){ document.getElementById('modal').classList.add('open'); }
  function closeModal(){ document.getElementById('modal').classList.remove('open'); }
  function fmt(n){ return (Math.round((n+Number.EPSILON)*100)/100).toLocaleString('es-PY'); }
  function render(){
    const tbody = document.querySelector('#tablaPagosTbl tbody');
    tbody.innerHTML = '';
    let totalTar = 0;
    pagos.forEach((p,i)=>{
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${p.tipo_id==1?'Tarjeta':(p.tipo_id==2?'Transf/Cta.':'Cheque')}</td>
        <td class="right">${fmt(p.monto || p.monto2 || 0)}</td>
        <td class="hide-sm">${p.moneda_id || ''}</td>
        <td class="hide-sm">${p.vaucher || ''}</td>
        <td class="hide-sm">${p.tipo_tar || ''}</td>
        <td class="right"><button class="btn btn-danger" onclick="delPago(${i})">Quitar</button></td>`;
      tbody.appendChild(tr);
      if (p.tipo_id==1) totalTar += Number(p.monto || 0);
    });
    document.getElementById('cantPagos').textContent = String(pagos.length);
    document.getElementById('totalTarjeta').textContent = fmt(totalTar);
  }
  function agregarPago(){
    const tipo_id   = Number(document.getElementById('tipo_id').value);
    const monto     = Number(document.getElementById('monto').value||0);
    const moneda_id = Number(document.getElementById('moneda').value);
    const vaucher   = document.getElementById('vaucher').value.trim();
    const tipo_tar  = Number(document.getElementById('tipo_tar').value);
    const tarjeta   = Number(document.getElementById('tarjeta').value);
    if (!monto){ alert('Ingresá un monto'); return; }
    const payload = { tipo_id, moneda_id };
    if (tipo_id===1){ payload.monto=monto; payload.vaucher=vaucher; payload.tipo_tar=tipo_tar; payload.tarjeta=tarjeta; }
    else if (tipo_id===2){ payload.monto2=monto; payload.recibo=vaucher; payload.banco=tipo_tar; }
    else if (tipo_id===3){ payload.monto2=monto; payload.recibo=vaucher; payload.banco=tipo_tar; }
    pagos.push(payload);
    render();
    closeModal();
  }
  function delPago(i){ pagos.splice(i,1); render(); }

  async function finalizarCobro(){
    const body = {
      cliente: Number(document.getElementById('cliente').value||0),
      sucursal: Number(document.getElementById('sucursal').value||0),
      fecha: document.getElementById('fecha').value,
      moneda_id: Number(document.getElementById('moneda_id').value||0),
      concepto: document.getElementById('concepto').value,
      total: Number(document.getElementById('total').value||0),
      pagos: pagos
    };
    try{
      const resp = await fetch('index.php?action=procesoventaproducto1', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(body)
      });
      const data = await resp.json();
      if (!resp.ok || (data && data.ok===false)) {
        alert('Error: '+ (data && data.error ? data.error : resp.statusText));
        return;
      }
      alert('Cobro registrado. ID: '+ (data.cobro_id || ''));
      // Redirección simple; ajusta si usás remisión
      window.location.href = 'index.php?view=ventas&id_sucursal='+(body.sucursal||0);
    }catch(e){
      alert('Error de red: '+e.message);
    }
  }
</script>
</body>
</html>
