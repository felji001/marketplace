/**
 * Enhanced Visual Feedback System
 * Modern toast notifications, confirmation dialogs, and user feedback mechanisms
 */

class FeedbackSystem {
    constructor() {
        this.toastContainer = null;
        this.init();
    }

    init() {
        this.createToastContainer();
        this.setupGlobalErrorHandling();
        this.enhanceAlerts();
        this.setupConfirmationDialogs();
        this.addFeedbackStyles();
    }

    // Create toast container
    createToastContainer() {
        this.toastContainer = document.createElement('div');
        this.toastContainer.id = 'toast-container';
        this.toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        this.toastContainer.style.zIndex = '1055';
        document.body.appendChild(this.toastContainer);
    }

    // Enhanced toast notifications
    showToast(message, type = 'info', options = {}) {
        const defaults = {
            duration: 5000,
            closable: true,
            icon: true,
            animation: 'slide',
            position: 'top-right'
        };
        
        const config = { ...defaults, ...options };
        const toastId = 'toast-' + Date.now();
        
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast modern-toast toast-${type} ${config.animation}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        const iconMap = {
            success: 'check-circle-fill',
            error: 'x-circle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };
        
        toast.innerHTML = `
            <div class="toast-header">
                ${config.icon ? `<i class="bi bi-${iconMap[type]} me-2 toast-icon"></i>` : ''}
                <strong class="me-auto toast-title">${this.getToastTitle(type)}</strong>
                <small class="text-muted">${new Date().toLocaleTimeString()}</small>
                ${config.closable ? '<button type="button" class="btn-close" data-bs-dismiss="toast"></button>' : ''}
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        this.toastContainer.appendChild(toast);
        
        // Initialize Bootstrap toast
        const bsToast = new bootstrap.Toast(toast, {
            delay: config.duration
        });
        
        // Show toast with animation
        setTimeout(() => {
            bsToast.show();
        }, 100);
        
        // Auto-remove after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
        
        return bsToast;
    }

    getToastTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error',
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Notification';
    }

    // Enhanced confirmation dialogs
    showConfirmation(message, options = {}) {
        return new Promise((resolve) => {
            const defaults = {
                title: 'Confirm Action',
                confirmText: 'Confirm',
                cancelText: 'Cancel',
                type: 'warning',
                icon: true
            };
            
            const config = { ...defaults, ...options };
            const modalId = 'confirmation-modal-' + Date.now();
            
            const modal = document.createElement('div');
            modal.id = modalId;
            modal.className = 'modal fade';
            modal.setAttribute('tabindex', '-1');
            modal.setAttribute('aria-hidden', 'true');
            
            const iconMap = {
                warning: 'exclamation-triangle text-warning',
                danger: 'x-circle text-danger',
                info: 'info-circle text-info',
                success: 'check-circle text-success'
            };
            
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modern-modal">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">${config.title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            ${config.icon ? `<div class="confirmation-icon mb-3">
                                <i class="bi bi-${iconMap[config.type]} display-4"></i>
                            </div>` : ''}
                            <p class="confirmation-message">${message}</p>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                ${config.cancelText}
                            </button>
                            <button type="button" class="btn btn-${config.type === 'danger' ? 'danger' : 'primary'} confirm-btn">
                                ${config.confirmText}
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            const bsModal = new bootstrap.Modal(modal);
            const confirmBtn = modal.querySelector('.confirm-btn');
            
            confirmBtn.addEventListener('click', () => {
                bsModal.hide();
                resolve(true);
            });
            
            modal.addEventListener('hidden.bs.modal', () => {
                modal.remove();
                resolve(false);
            });
            
            bsModal.show();
        });
    }

    // Progress notifications
    showProgress(message, progress = 0) {
        const progressId = 'progress-toast-' + Date.now();
        
        const toast = document.createElement('div');
        toast.id = progressId;
        toast.className = 'toast modern-toast toast-info show';
        toast.setAttribute('role', 'alert');
        
        toast.innerHTML = `
            <div class="toast-header">
                <i class="bi bi-arrow-repeat spin me-2 toast-icon"></i>
                <strong class="me-auto">Processing</strong>
                <small class="text-muted">In progress</small>
            </div>
            <div class="toast-body">
                <div class="progress-message mb-2">${message}</div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         role="progressbar" style="width: ${progress}%"></div>
                </div>
            </div>
        `;
        
        this.toastContainer.appendChild(toast);
        
        return {
            update: (newMessage, newProgress) => {
                const messageEl = toast.querySelector('.progress-message');
                const progressBar = toast.querySelector('.progress-bar');
                if (messageEl) messageEl.textContent = newMessage;
                if (progressBar) progressBar.style.width = newProgress + '%';
            },
            complete: (successMessage) => {
                const icon = toast.querySelector('.toast-icon');
                const title = toast.querySelector('.me-auto');
                const messageEl = toast.querySelector('.progress-message');
                const progressBar = toast.querySelector('.progress-bar');
                
                icon.className = 'bi bi-check-circle-fill me-2 toast-icon text-success';
                title.textContent = 'Complete';
                messageEl.textContent = successMessage || 'Operation completed successfully';
                progressBar.style.width = '100%';
                progressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
                progressBar.classList.add('bg-success');
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            },
            error: (errorMessage) => {
                const icon = toast.querySelector('.toast-icon');
                const title = toast.querySelector('.me-auto');
                const messageEl = toast.querySelector('.progress-message');
                const progressBar = toast.querySelector('.progress-bar');
                
                icon.className = 'bi bi-x-circle-fill me-2 toast-icon text-danger';
                title.textContent = 'Error';
                messageEl.textContent = errorMessage || 'Operation failed';
                progressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
                progressBar.classList.add('bg-danger');
                
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            },
            remove: () => {
                toast.remove();
            }
        };
    }

    // Enhanced alert styling
    enhanceAlerts() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (!alert.classList.contains('enhanced')) {
                alert.classList.add('enhanced', 'fade-in-up');
                
                // Add close animation
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        alert.style.animation = 'fadeOut 0.3s ease forwards';
                    });
                }
            }
        });
    }

    // Global error handling
    setupGlobalErrorHandling() {
        window.addEventListener('error', (event) => {
            console.error('Global error:', event.error);
            this.showToast('An unexpected error occurred. Please try again.', 'error');
        });
        
        window.addEventListener('unhandledrejection', (event) => {
            console.error('Unhandled promise rejection:', event.reason);
            this.showToast('A network error occurred. Please check your connection.', 'error');
        });
    }

    // Setup confirmation dialogs for dangerous actions
    setupConfirmationDialogs() {
        document.addEventListener('click', async (e) => {
            const target = e.target.closest('[data-confirm]');
            if (target) {
                e.preventDefault();
                
                const message = target.dataset.confirm;
                const type = target.dataset.confirmType || 'warning';
                const title = target.dataset.confirmTitle || 'Confirm Action';
                
                const confirmed = await this.showConfirmation(message, {
                    title,
                    type,
                    confirmText: target.dataset.confirmText || 'Confirm',
                    cancelText: target.dataset.cancelText || 'Cancel'
                });
                
                if (confirmed) {
                    // If it's a form, submit it
                    if (target.tagName === 'BUTTON' && target.type === 'submit') {
                        target.closest('form').submit();
                    }
                    // If it's a link, navigate to it
                    else if (target.tagName === 'A' && target.href) {
                        window.location.href = target.href;
                    }
                    // If it has a click handler, trigger it
                    else if (target.onclick) {
                        target.onclick();
                    }
                }
            }
        });
    }

    // Add feedback styles
    addFeedbackStyles() {
        const styles = `
            .modern-toast {
                border: none;
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.12);
                backdrop-filter: blur(10px);
                margin-bottom: 1rem;
                overflow: hidden;
            }
            
            .toast-success { border-left: 4px solid #28a745; }
            .toast-error { border-left: 4px solid #dc3545; }
            .toast-warning { border-left: 4px solid #ffc107; }
            .toast-info { border-left: 4px solid #17a2b8; }
            
            .toast-icon.text-success { color: #28a745 !important; }
            .toast-icon.text-danger { color: #dc3545 !important; }
            .toast-icon.text-warning { color: #ffc107 !important; }
            .toast-icon.text-info { color: #17a2b8 !important; }
            
            .modern-modal {
                border: none;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            }
            
            .confirmation-icon {
                animation: bounceIn 0.6s ease;
            }
            
            .alert.enhanced {
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            }
            
            @keyframes fadeOut {
                to { opacity: 0; transform: translateY(-20px); }
            }
            
            @keyframes bounceIn {
                0% { transform: scale(0.3); opacity: 0; }
                50% { transform: scale(1.05); }
                70% { transform: scale(0.9); }
                100% { transform: scale(1); opacity: 1; }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);
    }

    // Utility methods
    success(message, options = {}) {
        return this.showToast(message, 'success', options);
    }
    
    error(message, options = {}) {
        return this.showToast(message, 'error', options);
    }
    
    warning(message, options = {}) {
        return this.showToast(message, 'warning', options);
    }
    
    info(message, options = {}) {
        return this.showToast(message, 'info', options);
    }
}

// Initialize feedback system
document.addEventListener('DOMContentLoaded', () => {
    window.feedbackSystem = new FeedbackSystem();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FeedbackSystem;
}
