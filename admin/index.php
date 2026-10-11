<?php
require '../config.php';require '../includes/functions.php';require_admin();
$products=(int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();$orders=(int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();$users=(int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();$revenue=(float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status!='Cancelled'")->fetchColumn();$pageTitle='Admin dashboard';require '../includes/header.php';
?>
<div class="page-title"><span class="eyebrow">Store tools</span><h1>Admin dashboard</h1><p>Manage products and keep an eye on orders.</p></div>
<div class="info-grid"><div class="info-card"><h3>Products</h3><h2><?= $products ?></h2><a class="text-link" href="<?= BASE_URL ?>/admin/products.php">Manage products →</a></div><div class="info-card"><h3>Orders</h3><h2><?= $orders ?></h2><a class="text-link" href="<?= BASE_URL ?>/admin/orders.php">Manage orders →</a></div><div class="info-card"><h3>Customers</h3><h2><?= $users ?></h2><p class="muted">Recorded accounts</p></div></div><section class="section"><div class="info-card"><h3>Order value recorded</h3><h2><?= money($revenue) ?></h2><p class="muted">Includes non-cancelled orders; not a profit calculation.</p></div></section>
<?php require '../includes/footer.php'; ?>
