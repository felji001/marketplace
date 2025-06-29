/**
 * Modern Loading States and Animations
 * Enhanced user experience with smooth transitions and feedback
 */

class LoadingStates {
    constructor() {
        this.init();
    }

    init() {
        this.setupPageLoader();
        this.setupFormLoaders();
        this.setupButtonLoaders();
        this.setupProgressBars();
        this.setupIntersectionObserver();
        this.setupSmoothScrolling();
        this.setupRippleEffects();
    }

    // Page Loading
    setupPageLoader() {
        // Create page loader
        const pageLoader = document.createElement('div');
        pageLoader.id = 'page-loader';
        pageLoader.innerHTML = `
            <div class="page-loader-content">
                <div class="loader-spinner"></div>
                <div class="loader-text">Loading...</div>
            </div>
        `;
        
        // Add styles
        const loaderStyles = `
            #page-loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: opacity 0.5s ease, visibility 0.5s ease;
            }
            
            .page-loader-content {
                text-align: center;
            }
            
            .loader-spinner {
                width: 50px;
                height: 50px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #007bff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 1rem;
            }
            
            .loader-text {
                color: #6c757d;
                font-weight: 500;
            }
            
            #page-loader.hidden {
                opacity: 0;
                visibility: hidden;
            }
        `;
        
        const style = document.createElement('style');
        style.textContent = loaderStyles;
        document.head.appendChild(style);
        document.body.appendChild(pageLoader);

        // Hide loader when page is loaded
        window.addEventListener('load', () => {
            setTimeout(() => {
                pageLoader.classList.add('hidden');
                setTimeout(() => {
                    pageLoader.remove();
                }, 500);
            }, 500);
        });
    }

    // Form Loading States
    setupFormLoaders() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    this.showButtonLoading(submitBtn);
                }
            });
        });
    }

    // Button Loading States
    setupButtonLoaders() {
        const buttons = document.querySelectorAll('[data-loading]');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                if (!button.disabled) {
                    this.showButtonLoading(button);
                }
            });
        });
    }

    showButtonLoading(button) {
        const originalText = button.innerHTML;
        const loadingText = button.dataset.loadingText || 'Loading...';
        
        button.disabled = true;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            ${loadingText}
        `;
        
        // Store original text for restoration
        button.dataset.originalText = originalText;
        
        // Auto-restore after 5 seconds if not manually restored
        setTimeout(() => {
            if (button.disabled && button.dataset.originalText) {
                this.hideButtonLoading(button);
            }
        }, 5000);
    }

    hideButtonLoading(button) {
        if (button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
            button.disabled = false;
            delete button.dataset.originalText;
        }
    }

    // Progress Bars
    setupProgressBars() {
        const progressBars = document.querySelectorAll('.progress-bar[data-animate]');
        
        progressBars.forEach(bar => {
            const targetWidth = bar.style.width || bar.getAttribute('aria-valuenow') + '%';
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.transition = 'width 1s ease-in-out';
                bar.style.width = targetWidth;
            }, 100);
        });
    }

    // Intersection Observer for Animations
    setupIntersectionObserver() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    
                    // Add animation classes
                    if (element.dataset.animation) {
                        element.classList.add(element.dataset.animation);
                    }
                    
                    // Trigger stagger animations
                    if (element.classList.contains('stagger-animation')) {
                        this.triggerStaggerAnimation(element);
                    }
                    
                    observer.unobserve(element);
                }
            });
        }, observerOptions);

        // Observe elements with animation data attributes
        const animatedElements = document.querySelectorAll('[data-animation], .stagger-animation');
        animatedElements.forEach(el => observer.observe(el));
    }

    triggerStaggerAnimation(container) {
        const children = container.children;
        Array.from(children).forEach((child, index) => {
            setTimeout(() => {
                child.classList.add('fade-in-up');
            }, index * 100);
        });
    }

    // Smooth Scrolling
    setupSmoothScrolling() {
        const scrollLinks = document.querySelectorAll('a[href^="#"]');
        
        scrollLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const targetId = link.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Add highlight effect
                    targetElement.classList.add('highlight-flash');
                    setTimeout(() => {
                        targetElement.classList.remove('highlight-flash');
                    }, 2000);
                }
            });
        });
    }

    // Ripple Effects
    setupRippleEffects() {
        const rippleElements = document.querySelectorAll('.ripple-effect, .btn');
        
        rippleElements.forEach(element => {
            element.addEventListener('click', (e) => {
                this.createRipple(e, element);
            });
        });
    }

    createRipple(event, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Utility Methods
    showToast(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="bi bi-${this.getToastIcon(type)} me-2"></i>
                ${message}
            </div>
        `;
        
        const toastStyles = `
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                padding: 1rem 1.5rem;
                z-index: 1050;
                animation: slideInRight 0.3s ease;
                max-width: 350px;
            }
            
            .toast-info { border-left: 4px solid #007bff; }
            .toast-success { border-left: 4px solid #28a745; }
            .toast-warning { border-left: 4px solid #ffc107; }
            .toast-error { border-left: 4px solid #dc3545; }
            
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        
        if (!document.querySelector('#toast-styles')) {
            const style = document.createElement('style');
            style.id = 'toast-styles';
            style.textContent = toastStyles;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    getToastIcon(type) {
        const icons = {
            info: 'info-circle',
            success: 'check-circle',
            warning: 'exclamation-triangle',
            error: 'x-circle'
        };
        return icons[type] || 'info-circle';
    }

    // Loading overlay for specific elements
    showElementLoading(element, message = 'Loading...') {
        const overlay = document.createElement('div');
        overlay.className = 'element-loading-overlay';
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <div class="loading-message">${message}</div>
            </div>
        `;
        
        element.style.position = 'relative';
        element.appendChild(overlay);
        
        return overlay;
    }

    hideElementLoading(element) {
        const overlay = element.querySelector('.element-loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.loadingStates = new LoadingStates();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LoadingStates;
}
