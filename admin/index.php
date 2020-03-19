<?php

require_once '../vendor/autoload.php';

$pdo = new PDO('sqlite:../data/burgers.sqlite');
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();

$stmt = $pdo->query('SELECT * FROM orders');
$orders = $stmt->fetchAll();

$loader = new \Twig\Loader\FilesystemLoader('../template/');
$twig = new \Twig\Environment($loader);

$data = [
    'users' => $users,
    'orders' => $orders
];

echo $twig->render('admin.twig', $data);