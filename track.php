<?php $pageTitle = "Track Complaint | FeedbackPro"; ?>
<?php include 'includes/header.php'; ?>

<section class="form-section">
    <div class="track-container">
        <div class="track-icon">
            <i class="fas fa-magnifying-glass"></i>
        </div>
        <h2>Track Your Complaint</h2>
        <p style="color:var(--text-2); margin-bottom:28px;">
            Enter your tracking ID to check current status.
        </p>

        <form action="track-result.php" method="GET">
            <div class="form-group" style="text-align:left;">
                <label for="tid">
                    <i class="fas fa-ticket"></i> Tracking ID <span class="required">*</span>
                </label>
                <input type="text" id="tid" name="tid" 
                       placeholder="e.g. CMP-A1B2C3D4" required
                       style="text-transform: uppercase; letter-spacing:1px; font-weight:600;">
            </div>
            <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center;">
                <i class="fas fa-search"></i> Track Now
            </button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>