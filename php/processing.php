<?php

require_once '../vendor/autoload.php';
require_once './Email_Send.php';

$pdo = new \PDO('sqlite:../data/burgers.sqlite');

if (empty($_POST)) {
    // redirect на index.php
    header('Location: /');
    exit;
}

$email = htmlentities(trim($_POST['email']));
$phone = htmlentities(trim($_POST['phone']));
$name = htmlentities(trim($_POST['name']));
$street = htmlentities($_POST['street']);
$home = htmlentities(trim($_POST['home']));
$part = htmlentities(trim($_POST['part'])) ?: '-';
$apart = htmlentities(trim($_POST['appt']));
$floor = htmlentities(trim($_POST['floor'])) ?: '-';
$comment = htmlentities($_POST['comment']) ?: '-';
$payment = $_POST['payment'] === 'card' ? 'Оплата банковской картой' : 'Оплата наличными';
$callback = $_POST['callback'] ? '' : $phone;

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute(array($email));
$result = $stmt->fetch(\PDO::FETCH_LAZY);
$count = $result['orders'] + 1;

if (isset($result['email'])) {
    // echo 'Такой пользователь уже есть, +1 в заказы';
    $userID = $result['id'];
    $stmt = $pdo->prepare('UPDATE users SET orders=? WHERE email=?');
    $stmt->execute(array($count, $email));
} else {
    // echo 'Такого пользователя нет в базе, регистрируем';
    $stmt = $pdo->prepare('INSERT INTO users (email, phone, name, orders) VALUES (?, ?, ?, ?)');
    $stmt->execute(array($email, $phone, $name, $count));
    $userID = $pdo->lastInsertId();

    $sendMail = new Email_Send();
    $sendMail->send($email, 'Спасибо за регистрацию на сайте burgers.ru! :)');
}

// Запись заказа в БД - id?
$address = "улица $street, д.$home, корп.$part, этаж: $floor, кв.$apart";

$stmt = $pdo->prepare('INSERT INTO orders (address, comment, call_back, payment, user_id) VALUES (?, ?, ?, ?, ?)');
$stmt->execute(array($address, $comment, $callback, $payment, $userID));
$orderID = $pdo->lastInsertId();

// Запись данных заказа в файл orders/*time*.txt
$fileName = date('Y.m.d.H.i');
$text = "заказ №$orderID"
    . PHP_EOL . "Ваш заказ будет доставлен по адресу: $address"
    . PHP_EOL . 'DarkBeefBurger за 500 рублей, 1 шт'
    . PHP_EOL . 'Комментарий: ' . $comment
    . PHP_EOL . '---------------'
    . PHP_EOL . '* ' . $payment
    . PHP_EOL . $callback
    . PHP_EOL . "Спасибо, $name, это Ваш $count заказ";
file_put_contents("../orders/$fileName.txt", $text);

// redirect на index.php
header('Location: /');
exit;