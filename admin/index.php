<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../css/main.min.css">
    <link rel="stylesheet" href="../css/admin.min.css">
</head>
<body>
<div class="wrapper">
    <ul class="main__tabs">
        <li class="active">Users</li>
        <li>Orders</li>
    </ul>
    <div class="main__text">
        <div class="active">
            <h3>Users</h3>
            <table class="main__table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>e-mail</th>
                    <th>Phone</th>
                    <th>Orders</th>
                </tr>
                <?php
                $pdo = new PDO('sqlite:../data/burgers.sqlite');
                $stmt = $pdo->query('SELECT * FROM users');
                $result = $stmt->fetchAll();
                if ($result) {
                    foreach ($result as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['phone'] . '</td>';
                        echo '<td>' . $row['orders'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo 'Нет данных';
                }
                ?>
            </table>
        </div>
        <div>
            <h3>Orders</h3>
            <table class="main__table">
                <tr>
                    <th>ID</th>
                    <th>Address</th>
                    <th>Comment</th>
                    <th>Call back</th>
                    <th>Payment</th>
                    <th>User id</th>
                </tr>
                <?php
                $pdo = new PDO('sqlite:../data/burgers.sqlite');
                $stmt = $pdo->query('SELECT * FROM orders');
                $result = $stmt->fetchAll();
                if ($result) {
                    foreach ($result as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['address'] . '</td>';
                        echo '<td>' . $row['comment'] . '</td>';
                        echo '<td>' . $row['call_back'] . '</td>';
                        echo '<td>' . $row['payment'] . '</td>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo 'Нет данных';
                }
                ?>
            </table>
        </div>
    </div><!-- end main__text -->
</div>

<script src="../js/vendors.min.js"></script>
<script src="../js/admin.min.js"></script>
</body>
</html>