<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: users.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/
?>

<div class="content">
    <?php display_error_msg(); ?>
    <div class="update-users-form">
        <h3>Update User</h3>
        <form id="update-user-form" action="/action/post" method="POST">
            <label for="users">Select User:</label>
            <input type="hidden" name="action" value="update_user">
            <select id="users" name="username" onchange="populateForm()">
                <option value="">Select a user</option>
                <?php foreach ($usersData as $userData) : ?>
                    <option value="<?php echo htmlspecialchars($userData['username']); ?>" <?php echo $userData['dataAttributes']; ?>><?php echo htmlspecialchars($userData['username']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" readonly required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="admin">Admin:</label>
            <select name="admin" id="admin">
                <option value="false">No</option>
                <option value="true">Yes</option>
            </select>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" class="green" id="submit-update-user">Update User</button>
        </form>
        <form id="delete-user-form" action="/action/post" method="POST">
            <input type="hidden" name="action" value="delete-user">
            <button type="submit" class="red" id="submit-delete-user">Delete User</button>
        </form>
    </div>

    <div class="add-users-form">
        <h3>Add User</h3>
        <form id="add-user-form" action="/action/post" method="POST">
            <input type="hidden" name="action" value="add_user">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="admin">Admin:</label>
            <select name="admin" id="admin">
                <option value="false">No</option>
                <option value="true">Yes</option>
            </select>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" class="green" id="submit-add-user">Add User</button>
        </form>
    </div>
</div>
<div>