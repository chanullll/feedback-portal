<?php ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Feedback & Complaint Portal' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $cssPath ?? 'css/style.css' ?>">
</head>
<body>

<nav class="navbar" id="navbar">
    <div class="container nav-flex">
        <a href="<?= $basePath ?? '' ?>index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-headset"></i>
            </div>
            FeedbackPro
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="<?= $basePath ?? '' ?>index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="<?= $basePath ?? '' ?>submit.php"><i class="fas fa-pen"></i> Submit</a></li>
            <li><a href="<?= $basePath ?? '' ?>track.php"><i class="fas fa-search"></i> Track</a></li>
            <li><a href="<?= $basePath ?? '' ?>admin/login.php" class="btn-nav"><i class="fas fa-lock"></i> Admin</a></li>
        </ul>
        <div style="display:flex; gap:8px; align-items:center;">
            <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                <i class="fas fa-moon"></i>
            </button>
            <button class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<div class="toast-container" id="toastContainer"></div>

<main>