<?php
// login.php — robust version

session_start();
require_once __DIR__ . '/config.php';

// 1) Ensure we got the expected POST fields
if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: index.html'); // open the public/home page
    exit;
}

$user = trim($_POST['username']);
$pass = trim($_POST['password']);

// 2) Connect DB
$db = @new mysqli($dbhost, $dbuser, $dbpass, $db);
if ($db->connect_errno) {
    // Show a simple error; for demo we won't print details
    exit('Error connecting to database.');
}

// 3) Pick table name (from config.php or default 'login')
$table = isset($dbtable) && $dbtable ? $dbtable : 'login';

// 4) Check credentials safely
$stmt = $db->prepare("SELECT role FROM `$table` WHERE username = ? AND password = ? LIMIT 1");
$stmt->bind_param('ss', $user, $pass);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

// 5) No match → go back to home
if (!$row) {
    header('Location: index.html');
    exit;
}

// 6) Role routing — make sure these strings match your DB exactly
$role = $row['role'];

if ($role === 'med_admin') {
    $_SESSION['admin'] = 'adminadmin';
    header('Location: med_admin_screen.php'); exit;
} elseif ($role === 'receptionist') {
    // IMPORTANT: use the SAME key your reception page checks
    // If your med_store_reception.php checks $_SESSION['reception'], set that:
    $_SESSION['reception'] = 'receptionreception';
    header('Location: med_store_reception.php'); exit;
} elseif ($role === 'doctor') {
    $_SESSION['doctor'] = 'doctordoctor';
    header('Location: med_store_doctor.php'); exit;
} else {
    header('Location: index.html'); exit;
}
