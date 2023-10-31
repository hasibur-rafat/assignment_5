<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
function createRole($roleName) {
    $roleName = htmlspecialchars($roleName);
    if (!empty($roleName)) {
        $rolesFile = fopen('roles.txt', 'a');
        fwrite($rolesFile, $roleName . "\n");
        fclose($rolesFile);
    }
    header('Location: admin.php');
    exit;
}

function editRole($roleId, $newRoleName) {
    $newRoleName = htmlspecialchars($newRoleName);
    if (!empty($newRoleName)) {
        $roles = file('roles.txt', FILE_IGNORE_NEW_LINES);
            $roles[$roleId] = $newRoleName;
            $rolesFile = fopen('roles.txt', 'w');
            foreach ($roles as $role) {
                fwrite($rolesFile, $role . "\n");
            }
            fclose($rolesFile);
        }
        header('Location: admin.php');
        exit;
    }

function deleteRole($roleId) {
    $roles = file('roles.txt', FILE_IGNORE_NEW_LINES);
    if (isset($roles[$roleId])) {
        unset($roles[$roleId]);
        $rolesFile = fopen('roles.txt', 'w');
        foreach ($roles as $role) {
            fwrite($rolesFile, $role . "\n");
        }
        fclose($rolesFile);
    }
    header('Location: admin.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_role'])) {
        createRole($_POST['new_role']);
    } elseif (isset($_POST['edit_role'])) {
        $roleId = $_POST['edit_role'];
        $newRoleName = $_POST['edited_role_name'];
        editRole($roleId, $newRoleName);
    } elseif (isset($_POST['delete_role'])) {
        $roleId = $_POST['delete_role'];
        deleteRole($roleId);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Role Management</title>
</head>
<body>
    <h2>Admin Panel - Role Management</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?></p>
    <h3>Create Role</h3>
    <form action="admin.php" method="post">
        <input type="text" name="new_role" placeholder="Enter new role name">
        <input type="submit" name="create_role" value="Create Role">
    </form>
    <h3>Existing Roles</h3>
    <ul>
        <li>Admin (You cannot edit or delete the admin role)</li>
    </ul>
    <h3>Edit/Delete Roles</h3>
    <form action="admin.php" method="post">
        <select name="edit_role">
            <option value="1">User</option>
        </select>
        <input type="text" name="edited_role_name" placeholder="New role name">
        <input type="submit" name="edit_role" value="Edit Role">
        <input type="submit" name="delete_role" value="Delete Role">
    </form>
</body>
</html>