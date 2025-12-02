<?php
// save_order.php
header('Content-Type: application/json');

if (isset($_GET['ping'])) {
  echo json_encode(["status"=>"ok","message"=>"save_order.php is reachable"]);
  exit;
}

require_once __DIR__ . '/config.php';

$mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $db);
if ($mysqli->connect_errno) {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"DB connect failed: ".$mysqli->connect_error]);
  exit;
}
$mysqli->set_charset('utf8mb4');

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Invalid JSON body"]);
  exit;
}

// Expecting: name, medicines (array), totalQty (int), distance (float), priority (string or 0/1), status
$name       = trim($data['name'] ?? '');
$medicines  = $data['medicines'] ?? [];
$totalQty   = (int)($data['totalQty'] ?? 0);
$distance   = (float)($data['distance'] ?? 0);
$priorityIn = $data['priority'] ?? 'Normal';
$status     = trim($data['status'] ?? 'Queued');

// Normalize priority
if ($priorityIn === 0 || $priorityIn === '0') {
  $priority = 'Emergency';
} elseif ($priorityIn === 1 || $priorityIn === '1') {
  $priority = 'Normal';
} else {
  // If string already, keep as is but force to allowed values
  $p = strtolower((string)$priorityIn);
  $priority = ($p === 'emergency') ? 'Emergency' : 'Normal';
}

// Validate
if ($name === '' || !is_array($medicines) || $totalQty <= 0) {
  http_response_code(422);
  echo json_encode(["status"=>"error","message"=>"Missing/invalid fields","debug"=>[
    "name"=>$name,"totalQty"=>$totalQty,"medicines_type"=>gettype($medicines)
  ]]);
  exit;
}

// Serialize medicines as JSON
$medicinesJson = json_encode($medicines, JSON_UNESCAPED_UNICODE);

// Ensure table exists (optional safety)
$mysqli->query("CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100) NOT NULL,
  medicines TEXT NOT NULL,
  total_qty INT DEFAULT 0,
  distance FLOAT DEFAULT 0,
  priority VARCHAR(20) DEFAULT 'Normal',
  status VARCHAR(50) DEFAULT 'Queued',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert
$sql = "INSERT INTO orders (customer_name, medicines, total_qty, distance, priority, status)
        VALUES (?,?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Prepare failed: ".$mysqli->error]);
  exit;
}
$stmt->bind_param('ssisss', $name, $medicinesJson, $totalQty, $distance, $priority, $status);
$ok = $stmt->execute();

if (!$ok) {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Execute failed: ".$stmt->error]);
  $stmt->close();
  exit;
}

$id = $stmt->insert_id;
$stmt->close();

echo json_encode(["status"=>"ok","id"=>$id]);
