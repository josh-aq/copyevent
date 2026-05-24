<?php
require_once __DIR__ . '/../config/db.php';
require_role('admin');
$pdo = db();

if (isset($_GET['approve'])) {
    $pdo->prepare("UPDATE users SET status='approved' WHERE user_id=?")->execute([intval($_GET['approve'])]);
    header('Location: request.php'); exit;
}
if (isset($_GET['reject'])) {
    $pdo->prepare("UPDATE users SET status='rejected' WHERE user_id=?")->execute([intval($_GET['reject'])]);
    header('Location: request.php'); exit;
}
$req = $pdo->query("SELECT * FROM users WHERE role IN ('supplier','coordinator') ORDER BY CASE WHEN status='pending' THEN 0 ELSE 1 END, created_at DESC")->fetchAll();
$stats = [
    'users' => $pdo->query('SELECT COUNT(*) c FROM users')->fetch()['c'],
    'pending' => $pdo->query("SELECT COUNT(*) c FROM users WHERE status='pending'")->fetch()['c'],
    'events' => $pdo->query('SELECT COUNT(*) c FROM events')->fetch()['c'],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verification Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root{--bg:#050505;--panel:rgba(15,15,15,.92);--gold:#f3c547;--border:rgba(255,215,0,.14);--border2:rgba(255,215,0,.32);--text:#fff;--muted:#a8a8a8;--shadow:0 20px 40px rgba(0,0,0,.35);--side:280px}
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
        .topbar p{color:var(--muted);max-width:700px;line-height:1.7}
        .cards{display:grid;grid-template-columns:repeat(3,minmax(180px,1fr));gap:18px;margin-bottom:28px}
        .card{background:var(--panel);border:1px solid var(--border);border-radius:26px;padding:24px;box-shadow:var(--shadow)}
        .card p{color:var(--muted);margin-top:12px}
        .num{font-size:42px;color:var(--gold);font-weight:900}
        .button{display:inline-flex;align-items:center;gap:10px;padding:10px 18px;border-radius:14px;border:1px solid var(--border2);background:linear-gradient(135deg,var(--gold2),var(--gold),var(--gold3));color:#111;font-weight:700;text-decoration:none;transition:.25s}
        .button:hover{transform:translateY(-2px);box-shadow:0 16px 28px rgba(243,197,71,.18)}
        .table-wrap{overflow-x:auto;background:var(--panel);border:1px solid var(--border);border-radius:26px;box-shadow:var(--shadow)}
        table{width:100%;border-collapse:separate;border-spacing:0 14px}
        th,td{padding:16px;text-align:left;vertical-align:top}
        th{color:var(--gold);font-weight:700}
        td{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:16px}
        .status-pill{display:inline-flex;padding:8px 12px;border-radius:999px;background:rgba(243,197,71,.12);color:var(--gold);font-weight:700}
        .btn{padding:10px 14px;border-radius:14px;text-decoration:none;font-weight:700;transition:.25s}
        .ok{background:#123d25;color:#c8ffcc}
        .bad{background:#3d1212;color:#ffb3b3}
        .file{color:var(--gold)}
        .thumb{width:95px;height:95px;object-fit:cover;border-radius:12px;border:1px solid rgba(243,197,71,.25);margin-top:10px}
        @media(max-width:980px){.cards{grid-template-columns:1fr 1fr}}        
        @media(max-width:700px){.wrap{flex-direction:column}.side{width:100%;min-width:0}.main{padding:22px}.topbar{flex-direction:column;align-items:flex-start}}    
    </style>
</head>
<body>
    <div class="wrap">
        <aside class="side">
            <div class="brand">EventIntel Admin</div>
            <nav class="nav-menu">
                <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a class="active" href="request.php"><i class="fas fa-user-check"></i> Verification Requests</a>
            </nav>
        </aside>
        <main class="main">
            <div class="topbar">
                <div>
                    <h1>Verification Requests</h1>
                    <p>Review incoming supplier and coordinator applications, verify documentation, and approve or reject directly from the admin panel.</p>
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

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Business</th>
                            <th>Status</th>
                            <th>Documents</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($req as $u): ?>
                            <tr>
                                <td>
                                    <?= esc(trim(($u['first_name'] ?? '') . ' ' . ($u['last_name'] ?? '')) ?: ($u['full_name'] ?? $u['username'])) ?><br>
                                    <small><?= esc($u['email']) ?></small><br>
                                    <small><?= esc($u['phone'] ?? '') ?></small>
                                </td>
                                <td><?= esc($u['role']) ?></td>
                                <td>
                                    <?= esc($u['business_name']) ?><br>
                                    <small><?= esc($u['business_address']) ?></small>
                                </td>
                                <td><span class="status-pill"><?= esc($u['status']) ?></span></td>
                                <td>
                                    <?php if ($u['valid_id']): ?><a class="file" target="_blank" href="../<?= esc($u['valid_id']) ?>">Valid ID</a><br><?php endif; ?>
                                    <?php if ($u['business_permit']): ?><a class="file" target="_blank" href="../<?= esc($u['business_permit']) ?>">Permit</a><br><?php endif; ?>
                                    <?php if ($u['face_capture']): ?><a class="file" target="_blank" href="../<?= esc($u['face_capture']) ?>">Live Face Capture</a><br><img class="thumb" src="../<?= esc($u['face_capture']) ?>"><?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($u['status'] === 'pending'): ?>
                                        <a class="btn ok" href="?approve=<?= $u['user_id'] ?>">Approve</a>
                                        <a class="btn bad" href="?reject=<?= $u['user_id'] ?>">Reject</a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

