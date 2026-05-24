<?php
require_once __DIR__ . '/../config/db.php';
require_role('admin');
$pdo = db();
$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $first = trim($_POST['first_name'] ?? '');
    $middle = trim($_POST['middle_initial'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $role = in_array($_POST['role'] ?? 'client', ['client', 'supplier', 'coordinator', 'admin'], true) ? $_POST['role'] : 'client';
    $status = in_array($_POST['status'] ?? 'approved', ['approved', 'pending', 'rejected'], true) ? $_POST['status'] : 'approved';
    $phone = trim($_POST['phone'] ?? '');
    $age = ($_POST['age'] ?? '') !== '' ? intval($_POST['age']) : null;
    $gender = trim($_POST['gender'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $municipality = trim($_POST['municipality'] ?? '');
    $barangay = trim($_POST['barangay'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $businessName = trim($_POST['business_name'] ?? '');
    $businessAddress = trim($_POST['business_address'] ?? '');
    $fullName = trim(($first . ' ' . $middle . ' ' . $last));
    if ($fullName === '') {
        $fullName = $username;
    }

    if ($username === '' || $email === '' || $password === '' || $password !== $confirm) {
        $message = 'Please complete the required fields and ensure passwords match.';
        $messageClass = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (
                username, full_name, email, password, role, status,
                first_name, last_name, middle_initial, age, gender, phone,
                province, municipality, barangay, postal_code,
                business_name, business_address
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $username,
                $fullName,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $role,
                $status,
                $first,
                $last,
                $middle,
                $age,
                $gender,
                $phone,
                $province,
                $municipality,
                $barangay,
                $postal_code,
                $businessName,
                $businessAddress,
            ]);
            $message = 'Account created successfully. You can now log in or continue adding users.';
            $messageClass = 'success';
        } catch (Exception $e) {
            $message = 'Could not create account. Username or email may already exist.';
            $messageClass = 'error';
        }
    }
}

$stats = [
    'users' => $pdo->query('SELECT COUNT(*) c FROM users')->fetch()['c'],
    'pending' => $pdo->query("SELECT COUNT(*) c FROM users WHERE status='pending'")->fetch()['c'],
    'events' => $pdo->query('SELECT COUNT(*) c FROM events')->fetch()['c'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root{--bg:#050505;--panel:rgba(15,15,15,.92);--panel2:rgba(255,255,255,.035);--gold:#f3c547;--gold2:#fff1a8;--gold3:#c99208;--text:#fff;--muted:#a8a8a8;--border:rgba(255,215,0,.14);--border2:rgba(255,215,0,.32);--shadow:0 22px 50px rgba(0,0,0,.38);--side:280px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Arial,sans-serif}
        body{min-height:100vh;background:var(--bg);color:var(--text);}
        .wrap{display:flex;min-height:100vh;width:100%}
        .side{width:var(--side);min-width:var(--side);background:rgba(12,12,12,.96);border-right:1px solid var(--border);padding:30px 22px;display:flex;flex-direction:column;}
        .brand{font-size:30px;font-weight:900;color:var(--gold);margin-bottom:28px}
        .nav-menu{display:flex;flex-direction:column;gap:10px}
        .nav-menu a{display:block;color:var(--text);text-decoration:none;padding:14px 16px;border-radius:14px;border:1px solid transparent;transition:.25s}
        .nav-menu a:hover,.nav-menu a.active{background:rgba(243,197,71,.14);border-color:var(--border2);color:var(--gold)}
        .main{flex:1;padding:28px 34px;}
        .topbar{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:28px}
        .topbar h1{font-size:clamp(30px,4vw,44px);margin-bottom:10px}
        .topbar p{color:var(--muted);max-width:680px;line-height:1.7}
        .button{display:inline-flex;align-items:center;gap:10px;padding:12px 20px;border-radius:14px;border:1px solid var(--border2);background:linear-gradient(135deg,var(--gold2),var(--gold),var(--gold3));color:#111;font-weight:800;cursor:pointer;text-decoration:none;transition:.25s}
        .button:hover{transform:translateY(-2px);box-shadow:0 18px 30px rgba(243,197,71,.2)}
        .cards{display:grid;grid-template-columns:repeat(3,minmax(180px,1fr));gap:18px;margin-bottom:28px}
        .card{background:var(--panel);border:1px solid var(--border);border-radius:26px;padding:26px;box-shadow:var(--shadow)}
        .card p{color:var(--muted);margin-top:12px}
        .num{font-size:42px;color:var(--gold);font-weight:900;}
        .alert{border-radius:20px;padding:18px 22px;margin-bottom:24px;font-size:15px;line-height:1.6;}
        .alert.success{background:rgba(67,181,129,.16);border:1px solid rgba(67,181,129,.3);color:#c7ffda}
        .alert.error{background:rgba(255,80,80,.14);border:1px solid rgba(255,80,80,.28);color:#ffb3b3}
        .panel{background:var(--panel);border:1px solid var(--border);border-radius:30px;padding:28px;box-shadow:var(--shadow)}
        .panel-head{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:24px}
        .panel-head h2{font-size:32px;line-height:1.1}
        .panel-head p{color:var(--muted);max-width:640px}
        .grid-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
        .grid-form .full{grid-column:1/-1}
        .field{display:flex;flex-direction:column;gap:10px}
        label{font-size:14px;color:#c7c7c7;font-weight:700}
        input[type=text],input[type=email],input[type=password],input[type=number],select,textarea{width:100%;padding:14px 16px;border-radius:16px;border:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.03);color:var(--text);outline:none}
        textarea{min-height:120px;resize:vertical}
        .pill-group{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
        .pill-group label{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:14px 16px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:.25s}
        .pill-group input{accent-color:var(--gold);}
        .pill-group label:hover{border-color:var(--border2);}
        .grid-form button{grid-column:1/-1;justify-self:start}
        @media(max-width:980px){.cards{grid-template-columns:1fr 1fr}.grid-form{grid-template-columns:1fr}}
        @media(max-width:680px){.wrap{flex-direction:column}.side{width:100%;min-width:0}.main{padding:22px}}
    </style>
</head>
<body>
    <div class="wrap">
        <aside class="side">
            <div class="brand">EventIntel Admin</div>
            <nav class="nav-menu">
                <a class="active" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="request.php"><i class="fas fa-user-check"></i> Verification Requests</a>
            </nav>
        </aside>
        <main class="main">
            <div class="topbar">
                <div>
                    <h1>Admin Control Panel</h1>
                    <p>Use this workspace to manage site accounts, verify suppliers and coordinators, and register new businesses directly from the admin interface.</p>
                </div>
                <a href="../auth/logout.php" class="button"><i class="fas fa-right-from-bracket"></i> Logout</a>
            </div>

            <div class="cards">
                <article class="card">
                    <div class="num"><?= $stats['users'] ?></div>
                    <p>Total users</p>
                </article>
                <article class="card">
                    <div class="num"><?= $stats['pending'] ?></div>
                    <p>Pending approvals</p>
                </article>
                <article class="card">
                    <div class="num"><?= $stats['events'] ?></div>
                    <p>Total events</p>
                </article>
            </div>

            <?php if ($message): ?>
                <div class="alert <?= $messageClass ?>"><?= $message ?></div>
            <?php endif; ?>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Create a new account</h2>
                        <p>Fill in the details below to register a client, supplier, or event coordinator. The admin can approve accounts immediately or submit them as pending.</p>
                    </div>
                </div>
                <form class="grid-form" method="POST" autocomplete="off">
                    <input type="hidden" name="create_user" value="1">
                    <div class="field">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="First name">
                    </div>
                    <div class="field">
                        <label for="middle_initial">Middle Initial</label>
                        <input type="text" id="middle_initial" name="middle_initial" placeholder="M">
                    </div>
                    <div class="field">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Last name">
                    </div>
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required placeholder="user123">
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="email@example.com">
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Create a password">
                    </div>
                    <div class="field">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Repeat password">
                    </div>
                    <div class="field full">
                        <label>Account role</label>
                        <div class="pill-group">
                            <label><input type="radio" name="role" value="client" checked> Client</label>
                            <label><input type="radio" name="role" value="supplier"> Supplier</label>
                            <label><input type="radio" name="role" value="coordinator"> Coordinator</label>
                            <label><input type="radio" name="role" value="admin"> Admin</label>
                        </div>
                    </div>
                    <div class="field">
                        <label for="status">Account status</label>
                        <select id="status" name="status">
                            <option value="approved" selected>Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" placeholder="0912 345 6789">
                    </div>
                    <div class="field">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" min="13" placeholder="26">
                    </div>
                    <div class="field">
                        <label for="gender">Gender</label>
                        <input type="text" id="gender" name="gender" placeholder="Female">
                    </div>
                    <div class="field">
                        <label for="province">Province</label>
                        <input type="text" id="province" name="province" placeholder="Pampanga">
                    </div>
                    <div class="field">
                        <label for="municipality">Municipality</label>
                        <input type="text" id="municipality" name="municipality" placeholder="Apalit">
                    </div>
                    <div class="field">
                        <label for="barangay">Barangay</label>
                        <input type="text" id="barangay" name="barangay" placeholder="San Jose">
                    </div>
                    <div class="field">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" placeholder="2007">
                    </div>
                    <div class="field full">
                        <label for="business_name">Business / Organization Name</label>
                        <input type="text" id="business_name" name="business_name" placeholder="Event Intel Catering">
                    </div>
                    <div class="field full">
                        <label for="business_address">Business Address</label>
                        <textarea id="business_address" name="business_address" placeholder="Street, City, Province"></textarea>
                    </div>
                    <button type="submit" class="button">Create Account</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
