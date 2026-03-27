<?php $pageTitle = "Home | FeedbackPro"; ?>
<?php include 'includes/header.php'; ?>

<?php
// Get stats for hero
require_once 'config/database.php';
$conn = getDBConnection();
$totalComplaints = $conn->query("SELECT COUNT(*) as c FROM complaints")->fetch_assoc()['c'];
$resolvedCount   = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='resolved'")->fetch_assoc()['c'];
$conn->close();
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
    
    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            System Active — Ready to Help
        </div>
        
        <h1>
            Your Voice Matters.<br>
            <span class="gradient-text">We Listen & Resolve.</span>
        </h1>
        
        <p>Submit your complaints, track their status in real-time, 
           and get timely resolutions — all in one modern platform.</p>
        
        <div class="hero-buttons">
            <a href="submit.php" class="btn btn-lg btn-primary">
                <i class="fas fa-pen-to-square"></i> Submit Complaint
            </a>
            <a href="track.php" class="btn btn-lg btn-outline">
                <i class="fas fa-magnifying-glass"></i> Track Status
            </a>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-number"><?= $totalComplaints ?>+</div>
                <div class="hero-stat-label">Complaints Filed</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number"><?= $resolvedCount ?>+</div>
                <div class="hero-stat-label">Resolved</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number">24/7</div>
                <div class="hero-stat-label">Available</div>
            </div>
        </div>
    </div>
</section>

<!-- WAVE -->
<div class="wave-divider">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path fill="var(--bg)" d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,50 1440,40 L1440,80 L0,80 Z"/>
    </svg>
</div>

<!-- FEATURES -->
<section class="features">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-sparkles"></i> How It Works
            </div>
            <h2>Simple 4-Step Process</h2>
            <p>From complaint submission to resolution — we keep it simple and transparent.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-step">1</span>
                <div class="feature-icon">
                    <i class="fas fa-pen-to-square"></i>
                </div>
                <h3>Submit Complaint</h3>
                <p>Fill in the complaint form with details and attach supporting documents easily.</p>
            </div>
            <div class="feature-card">
                <span class="feature-step">2</span>
                <div class="feature-icon">
                    <i class="fas fa-ticket"></i>
                </div>
                <h3>Get Tracking ID</h3>
                <p>Receive a unique tracking ID instantly after submission for future reference.</p>
            </div>
            <div class="feature-card">
                <span class="feature-step">3</span>
                <div class="feature-icon">
                    <i class="fas fa-magnifying-glass-chart"></i>
                </div>
                <h3>Track Progress</h3>
                <p>Use your tracking ID to check the current status of your complaint anytime.</p>
            </div>
            <div class="feature-card">
                <span class="feature-step">4</span>
                <div class="feature-icon">
                    <i class="fas fa-circle-check"></i>
                </div>
                <h3>Get Resolution</h3>
                <p>Our team reviews and resolves your complaint promptly with email updates.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>