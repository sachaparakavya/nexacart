<?php
require '../config.php';require '../includes/functions.php';require_admin();
$allowed=['Pending','Processing','Shipped','Delivered','Cancelled'];$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){$id=(int)($_POST['order_id']??0);$status=$_POST['status']??'';if(in_array($status,$allowed,true)){$stmt=$pdo->prepare('UPDATE orders SET status=? WHERE id=?');$stmt->execute([$status,$id]);$_SESSION['flash']='Order status updated.';redirect('admin/orders.php');}else{$error='Invalid status.';}}
$orders=$pdo->query('SELECT o.*,u.name AS customer_name FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC')->fetchAll();$pageTitle='Manage orders';require '../includes/header.php';
?>
<div class="page-title"><span class="eyebrow">Store administration</span><h1>Manage orders</h1><p>Update order progress for customers.</p></div><?php if($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<div class="table-wrap"><table><thead><tr><th>Order</th><th>Customer</th><th>Date</th><th>Total</th><th>Status</th><th>Update</th></tr></thead><tbody><?php foreach($orders as $o): ?><tr><td>#<?= (int)$o['id'] ?></td><td><?= e($o['customer_name']) ?><br><small><?= e($o['email']) ?></small></td><td><?= e(date('d M Y',strtotime($o['created_at']))) ?></td><td><?= money($o['total']) ?></td><td><?= e($o['status']) ?></td><td><form method="post" class="inline-form"><input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>"><select name="status"><?php foreach($allowed as $status): ?><option <?= $o['status']===$status?'selected':'' ?>><?= e($status) ?></option><?php endforeach; ?></select><button class="btn">Save</button></form></td></tr><?php endforeach; ?></tbody></table></div>
<?php require '../includes/footer.php'; ?>
