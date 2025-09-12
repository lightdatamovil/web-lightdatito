<?php
session_start();

if (!isset($_POST['email'], $_POST['password'])) {
    echo json_encode(["estado" => false, "mensaje" => "Faltan datos"]);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$parametros = json_encode([
    "email" => $email,
    "password" => $password
]);

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://node1.liit.com.ar/api/auth/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $parametros,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

if ($result && isset($result['success']) && $result['success']) {
    $user = $result['body'];
    $_SESSION['logeado'] = true;
    $_SESSION['user'] = json_encode($user);
    $_SESSION['userId'] = $user['id'];
    $_SESSION['userNombre'] = $user['nombre'];
    $_SESSION['tkn'] = $user['token'];

    echo json_encode([
        "estado" => true,
        "mensaje" => "Login correcto",
        "data" => $user
    ]);
} else {
    $_SESSION['logeado'] = false;
    echo json_encode([
        "estado" => false,
        "mensaje" => $result['message'] ?? "Usuario o contraseña incorrectos"
    ]);
}
