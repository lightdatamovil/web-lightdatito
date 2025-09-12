<?php
session_start();

if (isset($_SESSION["logeado"])) {
    if ($_SESSION["logeado"] === true) {
        include("home.php"); // Usuario logueado correctamente
    } else {
        include("homebloqueada.php"); // Usuario bloqueado
    }
} else {
    include("login.php"); // No inició sesión o faltan datos
}
