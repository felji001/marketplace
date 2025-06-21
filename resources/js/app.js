import './bootstrap';

// ===== MODERN MARKETPLACE JAVASCRIPT =====

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Main App Initialization
function initializeApp() {
    initializeAnimations();
    initializeFormValidation();
    initializeInteractiveElements();
    initializeAjaxForms();
    initializeTooltips();
    initializeSearchEnhancements();
    initializeLoadingStates();
}

// Initialize Animations
function initializeAnimations() {
    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });

    // Add slide-up animation to alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.classList.add('slide-up');
    });
}

// Enhanced Form Validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            // Real-time validation
            input.addEventListener('input', function() {
                validateField(this);
            });

            input.addEventListener('blur', function() {
                validateField(this);
            });
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Please fix the errors before submitting.', 'error');
            } else {
                showLoadingState(form);
            }
        });
    });
}

// Field Validation Function
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let message = '';

    // Remove existing validation classes
    field.classList.remove('is-valid', 'is-invalid');

    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        message = `${getFieldLabel(field)} is required.`;
    }

    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            message = 'Please enter a valid email address.';
        }
    }

    // Password validation
    if (field.type === 'password' && value) {
        if (value.length < 8) {
            isValid = false;
            message = 'Password must be at least 8 characters long.';
        }
    }

    // Number validation
    if (field.type === 'number' && value) {
        if (isNaN(value) || parseFloat(value) < 0) {
            isValid = false;
            message = 'Please enter a valid positive number.';
        }
    }

    // Apply validation styling
    if (value) { // Only validate if field has content
        field.classList.add(isValid ? 'is-valid' : 'is-invalid');
        updateValidationMessage(field, message, isValid);
    }

    return isValid;
}

// Get Field Label
function getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`);
    return label ? label.textContent.replace('*', '').trim() : field.name;
}

// Update Validation Message
function updateValidationMessage(field, message, isValid) {
    let feedbackElement = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');

    if (!feedbackElement) {
        feedbackElement = document.createElement('div');
        field.parentNode.appendChild(feedbackElement);
    }

    feedbackElement.className = isValid ? 'valid-feedback' : 'invalid-feedback';
    feedbackElement.textContent = isValid ? 'Looks good!' : message;
    feedbackElement.style.display = 'block';
}

// Initialize Interactive Elements
function initializeInteractiveElements() {
    // Enhanced button interactions
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add ripple effect
            createRippleEffect(this, e);
        });
    });

    // Product card interactions
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Create Ripple Effect
function createRippleEffect(button, event) {
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;

    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');

    button.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Initialize AJAX Forms
function initializeAjaxForms() {
    const ajaxForms = document.querySelectorAll('[data-ajax="true"]');

    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitFormAjax(this);
        });
    });
}

// Submit Form via AJAX
function submitFormAjax(form) {
    const formData = new FormData(form);
    const url = form.action;
    const method = form.method || 'POST';

    showLoadingState(form);

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingState(form);

        if (data.success) {
            showNotification(data.message || 'Operation completed successfully!', 'success');
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            }
        } else {
            showNotification(data.message || 'An error occurred. Please try again.', 'error');
        }
    })
    .catch(error => {
        hideLoadingState(form);
        showNotification('An error occurred. Please try again.', 'error');
        console.error('Error:', error);
    });
}

// Initialize Tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize Search Enhancements
function initializeSearchEnhancements() {
    const searchInputs = document.querySelectorAll('input[type="search"], input[name="search"]');

    searchInputs.forEach(input => {
        let searchTimeout;

        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();

            if (searchTerm.length >= 2) {
                searchTimeout = setTimeout(() => {
                    performLiveSearch(searchTerm, this);
                }, 300);
            }
        });
    });
}

// Perform Live Search
function performLiveSearch(term, input) {
    const searchContainer = input.closest('form');
    if (!searchContainer) return;

    // Add loading indicator
    input.classList.add('loading');

    // This would typically make an AJAX call to search
    // For now, we'll just simulate the loading state
    setTimeout(() => {
        input.classList.remove('loading');
    }, 500);
}

// Loading States
function initializeLoadingStates() {
    // Add loading states to buttons that submit forms
    const submitButtons = document.querySelectorAll('button[type="submit"], input[type="submit"]');

    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form && form.checkValidity()) {
                showLoadingState(this);
            }
        });
    });
}

// Show Loading State
function showLoadingState(element) {
    if (element.tagName === 'FORM') {
        element.classList.add('loading');
        const submitBtn = element.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        }
    } else {
        element.disabled = true;
        element.classList.add('loading');
        const originalText = element.innerHTML;
        element.setAttribute('data-original-text', originalText);
        element.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
    }
}

// Hide Loading State
function hideLoadingState(element) {
    if (element.tagName === 'FORM') {
        element.classList.remove('loading');
        const submitBtn = element.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            // Restore original button text based on context
            if (submitBtn.textContent.includes('Processing')) {
                submitBtn.innerHTML = submitBtn.innerHTML.replace('<i class="bi bi-hourglass-split"></i> Processing...', 'Submit');
            }
        }
    } else {
        element.disabled = false;
        element.classList.remove('loading');
        const originalText = element.getAttribute('data-original-text');
        if (originalText) {
            element.innerHTML = originalText;
        }
    }
}

// Show Notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification-toast alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: var(--shadow-lg);
    `;

    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Enhanced Product Interactions
function initializeProductInteractions() {
    // Quantity selector enhancements
    const quantitySelectors = document.querySelectorAll('select[name="quantity"], select[id*="quantity"]');
    quantitySelectors.forEach(selector => {
        selector.addEventListener('change', function() {
            updatePriceDisplay(this);
        });
    });

    // Image hover effects (if images are added later)
    const productImages = document.querySelectorAll('.product-image');
    productImages.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });

        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// Update Price Display
function updatePriceDisplay(quantitySelector) {
    const quantity = parseInt(quantitySelector.value);
    const priceElement = document.querySelector('.product-price, .h5.text-primary');

    if (priceElement && quantity > 1) {
        const basePrice = parseFloat(priceElement.getAttribute('data-base-price') || priceElement.textContent.replace(/[^0-9.]/g, ''));
        if (basePrice) {
            const totalPrice = basePrice * quantity;
            priceElement.textContent = `$${totalPrice.toFixed(2)} (${quantity} items)`;
        }
    }
}

// Initialize Category Filtering
function initializeCategoryFiltering() {
    const categoryLinks = document.querySelectorAll('.category-sidebar a');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state to category sidebar
            const sidebar = this.closest('.category-sidebar');
            if (sidebar) {
                sidebar.classList.add('loading');
            }
        });
    });
}

// Mobile Menu Enhancements
function initializeMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Add smooth animation
            navbarCollapse.style.transition = 'all 0.3s ease-in-out';
        });
    }
}

// Initialize all product interactions when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeProductInteractions();
    initializeCategoryFiltering();
    initializeMobileMenu();
});

// Add CSS for ripple effect
const rippleCSS = `
.btn {
    position: relative;
    overflow: hidden;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;

// Inject ripple CSS
const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style);
