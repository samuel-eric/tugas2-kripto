<?php
/*Just for your server-side code*/
header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../bootstrap.min.css">
  <script src="./../bootstrap.bundle.min.js" defer></script>
  <title><?= $title ?? 'Kriptografi Tugas 2' ?></title>
</head>

<body>
  <?php include __DIR__ . '/_navbar.php'; ?>
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">