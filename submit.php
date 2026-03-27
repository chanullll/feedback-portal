<?php $pageTitle = "Submit Complaint | FeedbackPro"; ?>
<?php include 'includes/header.php'; ?>

<section class="form-section">
    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-pen-to-square"></i> Submit Your Complaint</h2>
            <p class="subtitle">Fill in all required fields carefully. Attach documents if needed.</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form id="complaintForm" action="process.php" method="POST" 
              enctype="multipart/form-data" novalidate>

            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">
                        <i class="fas fa-user"></i> Full Name <span class="required">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name" placeholder="John Doe">
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Full name is required</p>
                </div>
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                    </label>
                    <input type="email" id="email" name="email" placeholder="john@example.com">
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Valid email is required</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">
                        <i class="fas fa-phone"></i> Phone Number <span class="required">*</span>
                    </label>
                    <input type="text" id="phone" name="phone" placeholder="0771234567">
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Valid phone required</p>
                </div>
                <div class="form-group">
                    <label for="category">
                        <i class="fas fa-tag"></i> Category <span class="required">*</span>
                    </label>
                    <select id="category" name="category">
                        <option value="">-- Select Category --</option>
                        <option value="product">🛍️ Product Issue</option>
                        <option value="service">🛠️ Service Complaint</option>
                        <option value="billing">💳 Billing Problem</option>
                        <option value="delivery">🚚 Delivery Issue</option>
                        <option value="staff">👤 Staff Behavior</option>
                        <option value="website">🌐 Website Issue</option>
                        <option value="other">📋 Other</option>
                    </select>
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Select a category</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="subject">
                        <i class="fas fa-heading"></i> Subject <span class="required">*</span>
                    </label>
                    <input type="text" id="subject" name="subject" placeholder="Brief subject">
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Subject is required</p>
                </div>
                <div class="form-group">
                    <label for="priority">
                        <i class="fas fa-flag"></i> Priority <span class="required">*</span>
                    </label>
                    <select id="priority" name="priority">
                        <option value="">-- Select Priority --</option>
                        <option value="low">🟢 Low</option>
                        <option value="medium" selected>🟡 Medium</option>
                        <option value="high">🔴 High</option>
                    </select>
                    <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Select priority</p>
                </div>
            </div>

            <div class="form-group">
                <label for="message">
                    <i class="fas fa-message"></i> Complaint Details <span class="required">*</span>
                </label>
                <textarea id="message" name="message" rows="6" 
                          placeholder="Describe your complaint in detail (min 20 characters)..."></textarea>
                <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Min 20 characters required</p>
                <span id="charCount" class="file-info">0 characters</span>
            </div>

            <div class="form-group">
                <label><i class="fas fa-paperclip"></i> Attach Document (optional)</label>
                <div class="file-upload-area" id="dropZone">
                    <i class="fas fa-cloud-arrow-up"></i>
                    <p><strong>Click to upload</strong> or drag & drop</p>
                    <p class="file-info">PDF, JPG, PNG, DOC, DOCX — Max 5 MB</p>
                    <input type="file" id="attachment" name="attachment" 
                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <div class="file-name" id="fileName"></div>
                </div>
                <p class="error-msg"><i class="fas fa-exclamation-circle"></i> Invalid file</p>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center;">
                <i class="fas fa-paper-plane"></i> Submit Complaint
            </button>
        </form>
    </div>
</section>

<script src="js/validation.js"></script>
<?php include 'includes/footer.php'; ?>