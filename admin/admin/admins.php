<?php
require_once 'auth_super.php';
require_once 'config.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE role IN ('admin','super_admin')");
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link href="css/adminstyle.css" rel="stylesheet" />
<div class="admin-wrapper">
    <div class="admin-card">

        <div class="admin-header">
            <div class="admin-title">👑 Admin Management</div>
            <a href="add_admin.php" class="btn-add">+ Add Admin</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($admins as $a): ?>
                <tr>
                    <td><?= $a['uname'] ?></td>
                    <td><?= $a['email'] ?></td>

                    <td>
                        <?php if($a['role'] == 'super_admin'): ?>
                            <span class="badge-role role-super">Super Admin</span>
                        <?php else: ?>
                            <span class="badge-role role-admin">Admin</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="edit_admin.php?id=<?= $a['id'] ?>" class="btn-action btn-edit">Edit</a>
                        <a href="delete_admin.php?id=<?= $a['id'] ?>" 
                           class="btn-action btn-delete"
                           onclick="return confirm('Are you sure?')">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
