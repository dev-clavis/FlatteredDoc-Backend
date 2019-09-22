<?php
include "phpqrcode/qrlib.php";

if (isset($_GET['id'])) {
    QRcode::png($_GET['id']);
} else {
    die('Keine ID übergeben');
}