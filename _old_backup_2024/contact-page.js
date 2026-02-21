function validateForm() {
    // Clear previous error messages
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => element.style.display = 'none');

    // Form fields
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();

    let isValid = true;

    // Name validation
    if (name === '') {
        showError('name', 'Name is required.');
        isValid = false;
    }

    // Email validation
    if (email === '') {
        showError('email', 'Email is required.');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('email', 'Please enter a valid email address.');
        isValid = false;
    }

    // Subject validation
    if (subject === '') {
        showError('subject', 'Subject is required.');
        isValid = false;
    }

    // Message validation
    if (message === '') {
        showError('message', 'Message is required.');
        isValid = false;
    }

    return isValid;
}

// Function to display error message for a specific field
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorElement = document.createElement('div');
    errorElement.classList.add('error');
    errorElement.textContent = message;
    field.parentNode.appendChild(errorElement);
    errorElement.style.display = 'block';
}

// Function to validate email format
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}


