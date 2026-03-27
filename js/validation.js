document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('complaintForm');
    if (!form) return;

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', () => {
            el.closest('.form-group')?.classList.remove('error');
        });
    });

    form.addEventListener('submit', (e) => {
        let isValid = true;
        form.querySelectorAll('.form-group').forEach(g => g.classList.remove('error'));

        const name = form.querySelector('#full_name');
        if (!name.value.trim()) {
            showError(name, 'Full name is required');
            isValid = false;
        } else if (name.value.trim().length < 3) {
            showError(name, 'Name must be at least 3 characters');
            isValid = false;
        }

        const email = form.querySelector('#email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            showError(email, 'Email is required');
            isValid = false;
        } else if (!emailRegex.test(email.value.trim())) {
            showError(email, 'Enter a valid email address');
            isValid = false;
        }

        const phone = form.querySelector('#phone');
        const phoneRegex = /^[0-9]{10,15}$/;
        if (!phone.value.trim()) {
            showError(phone, 'Phone number is required');
            isValid = false;
        } else if (!phoneRegex.test(phone.value.trim())) {
            showError(phone, 'Enter a valid phone number (10-15 digits)');
            isValid = false;
        }

        const category = form.querySelector('#category');
        if (!category.value) {
            showError(category, 'Please select a category');
            isValid = false;
        }

        const priority = form.querySelector('#priority');
        if (!priority.value) {
            showError(priority, 'Please select a priority');
            isValid = false;
        }

        const subject = form.querySelector('#subject');
        if (!subject.value.trim()) {
            showError(subject, 'Subject is required');
            isValid = false;
        } else if (subject.value.trim().length < 5) {
            showError(subject, 'Subject must be at least 5 characters');
            isValid = false;
        }

        const message = form.querySelector('#message');
        if (!message.value.trim()) {
            showError(message, 'Message is required');
            isValid = false;
        } else if (message.value.trim().length < 20) {
            showError(message, 'Message must be at least 20 characters');
            isValid = false;
        }

        const fileInput = form.querySelector('#attachment');
        if (fileInput && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const allowedTypes = [
                'application/pdf',
                'image/jpeg',
                'image/png',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            const maxSize = 5 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                showError(fileInput, 'Only PDF, JPG, PNG, DOC, DOCX files are allowed');
                isValid = false;
            } else if (file.size > maxSize) {
                showError(fileInput, 'File size must be less than 5 MB');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = form.querySelector('.form-group.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    function showError(input, msg) {
        const group = input.closest('.form-group');
        group.classList.add('error');
        const errorEl = group.querySelector('.error-msg');
        if (errorEl) errorEl.textContent = msg;
    }

    const messageField = document.getElementById('message');
    const charCounter  = document.getElementById('charCount');
    if (messageField && charCounter) {
        messageField.addEventListener('input', () => {
            charCounter.textContent = messageField.value.length + ' characters';
        });
    }
});