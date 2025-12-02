<?php
// med_store_reception.php (fixed)

session_start();

// IMPORTANT: This must match what login.php sets.
// If your login.php does:  $_SESSION['reception'] = 'receptionreception';
// then keep the line below as-is.
// If your login.php sets $_SESSION['receptionist'], change the key here.
if (empty($_SESSION['reception'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$dbconn = @mysqli_connect($dbhost, $dbuser, $dbpass, $db);
// (optional) if (!$dbconn) { die('DB connect failed'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Reception Desk | Medicare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="assets/css/main.css" />

  <style>
    body {
      background: linear-gradient(135deg, #007bff 0%, #00d4ff 100%);
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      text-align: center;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    .topbar {
      padding:10px;
      background:#f6f7fb;
      border-bottom:1px solid #e5e7eb;
      color:#111827;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    h1 {
      margin-top: 30px;
      font-size: 2.0rem;
      font-weight: bold;
    }
    .admin-panel {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      padding: 25px;
      width: 90%;
      max-width: 900px;
      margin: 20px auto 40px auto;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .controls { margin-bottom: 12px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
    input, button {
      padding: 10px 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
    }
    button {
      background: #004aad;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover { background: #003680; }
    #ordersTable {
      width: 95%;
      margin: 20px auto;
      border-collapse: collapse;
      background: rgba(255,255,255,0.12);
      border-radius: 12px;
      overflow: hidden;
    }
    #ordersTable th, #ordersTable td {
      border: 1px solid #ffffff44;
      padding: 10px;
    }
    #ordersTable th { background: rgba(255, 255, 255, 0.25); }
    .muted { opacity: .9; }
  </style>
</head>
<body>

  <!-- Top bar -->
  <div class="topbar">
    <strong>Reception Dashboard</strong>
    <form method="post" action="distroy_session.php" style="margin:0;">
      <button style="padding:6px 10px;">Logout</button>
    </form>
  </div>

  <h1>Order Management (Reception)</h1>

  <div class="admin-panel" id="adminPanel">
    <div class="muted">You are logged in as <strong>Receptionist</strong>. Manage incoming medicine delivery orders below.</div>

    <div class="controls">
      <button onclick="processOrders()">Start Processing</button>
      <button style="background:#16a34a" onclick="seedSample()">Seed Sample Orders</button>
      <button style="background:#ef4444" onclick="clearAll()">Clear Orders</button>
    </div>

    <table id="ordersTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Medicines</th>
          <th>Distance</th>
          <th>Quantity</th>
          <th>Priority</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="ordersBody"></tbody>
    </table>
  </div>

  <script>
  // --- Simple reception-side order board using localStorage, as in your original ---
  let orders = JSON.parse(localStorage.getItem("orders")) || [];
  let isProcessing = false;

function renderOrders() {
  const body = document.getElementById("ordersBody");
  body.innerHTML = "";
  orders.forEach(o => {
    const row = `<tr>
      <td>${escapeHtml(o.name || '')}</td>
      <td>${
        Array.isArray(o.medicines)
          ? o.medicines
              .map(m => (typeof m === "object" ? `${m.name || ''} (${m.qty || ''})` : m))
              .join(", ")
          : ''
      }</td>
      <td>${Number(o.distance||0)} km</td>
      <td>${Number(o.totalQty||0)}</td>
      <td>${o.priority === 0 ? 'Emergency 🚨' : 'Normal'}</td>
      <td>${escapeHtml(o.status || '')}</td>
    </tr>`;
    body.insertAdjacentHTML('beforeend', row);
  });
}

  function loadOrders() {
    orders = JSON.parse(localStorage.getItem("orders")) || [];
    renderOrders();
  }

  function updateStorage() {
    localStorage.setItem("orders", JSON.stringify(orders));
    renderOrders();
  }

  function delay(ms) { return new Promise(res => setTimeout(res, ms)); }

  async function processOrders() {
    if (isProcessing) return;
    isProcessing = true;

    // Priority first (0 = emergency), then by arrival time, then by higher quantity
    orders.sort((a,b)=>{
      if(a.priority!==b.priority) return a.priority-b.priority;
      if((a.priority||1)===0) return (a.arrival||0)-(b.arrival||0); // emergency FCFS
      if((a.totalQty||0)!==(b.totalQty||0)) return (b.totalQty||0)-(a.totalQty||0);
      return (a.arrival||0)-(b.arrival||0);
    });

    for (let o of orders) {
      if (o.status === "Delivered ✅") continue;

      o.status = "Packing 📦"; updateStorage();
      await delay(1500);

      o.status = "Waiting for Dispatch ⏳"; updateStorage();
      await delay(1500);

      o.status = "Out for Delivery 🚚"; updateStorage();
      await delay(Math.max(800, (Number(o.distance||1) * 600))); // simulate per km

      o.status = "Delivered ✅"; updateStorage();
    }

    isProcessing = false;
  }

  // Utilities / helpers
  function clearAll(){
    orders = [];
    updateStorage();
  }

  function seedSample(){
    const now = Date.now();
    orders = [
      { name:"VIT Hostel A", medicines:["Paracetamol 650","ORS"], distance:2.4, totalQty:5, priority:0, arrival:now-300000, status:"Queued" },
      { name:"Kelambakkam Gate", medicines:["Cetirizine","Vitamin C"], distance:3.1, totalQty:3, priority:1, arrival:now-200000, status:"Queued" },
      { name:"Faculty Quarters", medicines:["Ibuprofen","Ranitidine"], distance:1.2, totalQty:6, priority:1, arrival:now-100000, status:"Queued" }
    ];
    updateStorage();
  }

  function escapeHtml(str){
    return String(str).replace(/[&<>"']/g, s=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;' }[s]));
  }

  // Initial load + gentle refresh if not processing
  loadOrders();
  setInterval(()=>{ if (!isProcessing) loadOrders(); }, 2000);
  </script>

  <!-- If you actually use it here; otherwise remove -->
  <script src="script_admin.js"></script>
</body>
</html>
