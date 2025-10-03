<?php
require_once __DIR__ . '/../includes/config.php';
// session_start();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . BASE_URL . "/index.php?page=admin");
    exit;
}

// Login check
if (!isset($_SESSION['is_admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Look up the user in the DB
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if (strtolower($user['role']) === 'admin') {
                $_SESSION['is_admin'] = true;
                $_SESSION['username'] = $user['username'];

                // Update last_login
                $update = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $update->execute([$user['id']]);

                header("Location: " . BASE_URL . "/index.php?page=admin");
                exit;
            } else {
                $error = "You do not have permission to access this page.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
    ?>
    <div class="admin-login-wrapper">
        <div class="admin-login">
            <h1>Admin Login</h1>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="post">
                <label>Username: <input type="text" name="username" required></label><br><br>
                <label>Password: <input type="password" name="password" required></label><br><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    <?php
    return; // stop here so layout footer still loads
}

// Logged in: show dashboard
?>
<h1>Admin Dashboard</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

<h2>📊 Site Visit Stats</h2>
<?php
$stmt = $pdo->query("SELECT COUNT(*) FROM site_visits");
$total = $stmt->fetchColumn();

$stmt = $pdo->query("
    SELECT page, COUNT(*) AS hits
    FROM site_visits
    GROUP BY page
    ORDER BY hits DESC
");
$pages = $stmt->fetchAll();
?>
<p>Total visits: <?= htmlspecialchars($total) ?></p>
<table border="1" cellpadding="5">
    <tr><th>Page</th><th>Visits</th></tr>
    <?php foreach ($pages as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['page']) ?></td>
            <td><?= htmlspecialchars($row['hits']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="<?= BASE_URL ?>/index.php?page=admin&logout=1">Logout</a></p>