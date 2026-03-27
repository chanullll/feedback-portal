<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Feedback & Complaint Portal' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $cssPath ?? 'css/style.css' ?>">
</head>
<body>

<nav class="navbar">
    <div class="container nav-flex">
        <a href="<?= $basePath ?? '' ?>index.php" class="logo">
            <i class="fas fa-headset"></i> Feedback Portal
        </a>
        <ul class="nav-links">
            <li><a href="<?= $basePath ?? '' ?>index.php">Home</a></li>
            <li><a href="<?= $basePath ?? '' ?>submit.php">Submit Complaint</a></li>
            <li><a href="<?= $basePath ?? '' ?>track.php">Track Status</a></li>
            <li><a href="<?= $basePath ?? '' ?>admin/login.php" class="btn-nav">Admin</a></li>
        </ul>
        <button class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>

<main>