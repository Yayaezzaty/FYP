document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotForm');
    const emailInput = document.getElementById('resetEmail');
    const emailError = document.getElementById('email-error');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate email
        if (!validateEmail(emailInput.value)) {
            emailError.textContent = 'Please enter a valid email address';
            return;
        } else {
            emailError.textContent = '';
        }
        
        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(new FormData(form))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                form.classList.add('hidden');
                successMessage.classList.remove('hidden');
            } else {
                emailError.textContent = data.error || 'Failed to send reset link';
            }
        })
        .catch(error => {
            emailError.textContent = 'Network error. Please try again.';
        })
        .finally(() => {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
        });
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});