<?php ?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <i class="fas fa-headset"></i> FeedbackPro
            </div>
            <ul class="footer-links">
                <li><a href="<?= $basePath ?? '' ?>index.php">Home</a></li>
                <li><a href="<?= $basePath ?? '' ?>submit.php">Submit</a></li>
                <li><a href="<?= $basePath ?? '' ?>track.php">Track</a></li>
            </ul>
        </div>
        <p class="footer-copy">
            &copy; <?= date('Y') ?> FeedbackPro. Built with ❤️ | All rights reserved.
        </p>
    </div>
</footer>

<script>
// ===== HAMBURGER MENU =====
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        const icon = hamburger.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
    });

    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => navLinks.classList.remove('active'));
    });
}

// ===== DARK MODE =====
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;

if (themeToggle) {
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    // Toggle theme on click
    themeToggle.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const next = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        updateThemeIcon(next);
    });
}

function updateThemeIcon(theme) {
    const icon = themeToggle?.querySelector('i');
    if (icon) {
        if (theme === 'dark') {
            icon.className = 'fas fa-sun';
        } else {
            icon.className = 'fas fa-moon';
        }
    }
}

// ===== NAVBAR SCROLL =====
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar?.classList.add('scrolled');
    } else {
        navbar?.classList.remove('scrolled');
    }
});

// ===== TOAST NOTIFICATION =====
function showToast(message, type = 'info', duration = 4000) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const icons = { success: 'check-circle', error: 'times-circle', info: 'info-circle' };
    const colors = { success: '#10b981', error: '#ef4444', info: '#06b6d4' };
    
    toast.innerHTML = `
        <i class="fas fa-${icons[type]}" style="color:${colors[type]}; font-size:1.3rem;"></i>
        <span style="flex:1; font-size:.9rem;">${message}</span>
        <button onclick="this.parentElement.remove()" 
                style="background:none; border:none; cursor:pointer; color:var(--gray); font-size:1rem;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.add('toast-exit');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// ===== SCROLL ANIMATIONS =====
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.feature-card, .stat-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all .6s ease';
    observer.observe(el);
});
</script>
</body>
</html>