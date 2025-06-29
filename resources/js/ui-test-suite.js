/**
 * UI/UX Enhancement Test Suite
 * Automated testing for UI components and interactions
 */

class UITestSuite {
    constructor() {
        this.tests = [];
        this.results = {
            passed: 0,
            failed: 0,
            total: 0
        };
        this.init();
    }

    init() {
        this.setupTestEnvironment();
        this.registerTests();
    }

    setupTestEnvironment() {
        // Create test results container
        const testContainer = document.createElement('div');
        testContainer.id = 'ui-test-results';
        testContainer.style.cssText = `
            position: fixed;
            top: 10px;
            left: 10px;
            background: white;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 1rem;
            max-width: 300px;
            z-index: 10000;
            font-family: monospace;
            font-size: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            display: none;
        `;
        document.body.appendChild(testContainer);

        // Add test toggle button
        const testButton = document.createElement('button');
        testButton.textContent = 'Run UI Tests';
        testButton.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 10001;
            font-size: 12px;
        `;
        testButton.onclick = () => this.runAllTests();
        document.body.appendChild(testButton);
    }

    registerTests() {
        // Test 1: Check if CSS files are loaded
        this.addTest('CSS Files Loaded', () => {
            const animationCSS = document.querySelector('link[href*="animations.css"]');
            const mobileCSS = document.querySelector('link[href*="mobile-responsive.css"]');
            return animationCSS && mobileCSS;
        });

        // Test 2: Check if JavaScript files are loaded
        this.addTest('JavaScript Files Loaded', () => {
            return typeof window.loadingStates !== 'undefined' && 
                   typeof window.feedbackSystem !== 'undefined';
        });

        // Test 3: Check Bootstrap 5 components
        this.addTest('Bootstrap 5 Components', () => {
            return typeof bootstrap !== 'undefined' && 
                   typeof bootstrap.Toast !== 'undefined';
        });

        // Test 4: Check modern navigation elements
        this.addTest('Modern Navigation', () => {
            const navbar = document.querySelector('.navbar');
            const modernBrand = document.querySelector('.modern-brand');
            const modernToggler = document.querySelector('.modern-toggler');
            return navbar && modernBrand && (modernToggler || window.innerWidth > 992);
        });

        // Test 5: Check animation classes
        this.addTest('Animation Classes Available', () => {
            const testElement = document.createElement('div');
            testElement.className = 'fade-in-up';
            document.body.appendChild(testElement);
            const hasAnimation = window.getComputedStyle(testElement).animation !== 'none';
            document.body.removeChild(testElement);
            return hasAnimation;
        });

        // Test 6: Check responsive design
        this.addTest('Responsive Design', () => {
            const viewport = document.querySelector('meta[name="viewport"]');
            return viewport && viewport.content.includes('width=device-width');
        });

        // Test 7: Check form enhancements
        this.addTest('Form Enhancements', () => {
            const forms = document.querySelectorAll('form');
            const hasModernInputs = document.querySelectorAll('.modern-input, .form-floating').length > 0;
            return forms.length > 0 && hasModernInputs;
        });

        // Test 8: Check card components
        this.addTest('Modern Card Components', () => {
            const cards = document.querySelectorAll('.card');
            const modernCards = document.querySelectorAll('.modern-dashboard-card, .modern-product-card, .modern-form-card');
            return cards.length > 0 && modernCards.length > 0;
        });

        // Test 9: Check loading states
        this.addTest('Loading States System', () => {
            if (!window.loadingStates) return false;
            
            // Test button loading
            const testBtn = document.createElement('button');
            testBtn.className = 'btn btn-primary';
            testBtn.textContent = 'Test';
            document.body.appendChild(testBtn);
            
            window.loadingStates.showButtonLoading(testBtn);
            const hasLoading = testBtn.disabled && testBtn.innerHTML.includes('spinner');
            
            document.body.removeChild(testBtn);
            return hasLoading;
        });

        // Test 10: Check feedback system
        this.addTest('Feedback System', () => {
            if (!window.feedbackSystem) return false;
            
            // Test toast creation
            const toast = window.feedbackSystem.showToast('Test message', 'info', { duration: 100 });
            const toastElement = document.querySelector('.toast');
            
            setTimeout(() => {
                if (toastElement && toastElement.parentNode) {
                    toastElement.remove();
                }
            }, 200);
            
            return toastElement !== null;
        });

        // Test 11: Check mobile responsiveness
        this.addTest('Mobile Responsiveness', () => {
            const mobileStyles = Array.from(document.styleSheets).some(sheet => {
                try {
                    return Array.from(sheet.cssRules).some(rule => 
                        rule.media && rule.media.mediaText.includes('max-width')
                    );
                } catch (e) {
                    return false;
                }
            });
            return mobileStyles;
        });

        // Test 12: Check accessibility features
        this.addTest('Accessibility Features', () => {
            const hasAriaLabels = document.querySelectorAll('[aria-label], [aria-labelledby]').length > 0;
            const hasRoles = document.querySelectorAll('[role]').length > 0;
            const hasAltTexts = Array.from(document.querySelectorAll('img')).every(img => 
                img.alt !== undefined
            );
            return hasAriaLabels && hasRoles;
        });

        // Test 13: Check icon integration
        this.addTest('Bootstrap Icons', () => {
            const icons = document.querySelectorAll('.bi, [class*="bi-"]');
            const iconCSS = document.querySelector('link[href*="bootstrap-icons"]');
            return icons.length > 0 && iconCSS;
        });

        // Test 14: Check hover effects
        this.addTest('Hover Effects', () => {
            const hoverElements = document.querySelectorAll('.hover-lift, .hover-scale, .hover-rotate');
            return hoverElements.length > 0;
        });

        // Test 15: Check page performance
        this.addTest('Page Performance', () => {
            const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
            return loadTime < 5000; // Less than 5 seconds
        });
    }

    addTest(name, testFunction) {
        this.tests.push({ name, test: testFunction });
    }

    async runAllTests() {
        const container = document.getElementById('ui-test-results');
        container.style.display = 'block';
        container.innerHTML = '<h4>Running UI Tests...</h4>';

        this.results = { passed: 0, failed: 0, total: this.tests.length };

        for (const { name, test } of this.tests) {
            try {
                const result = await test();
                if (result) {
                    this.results.passed++;
                    this.logResult(container, name, true);
                } else {
                    this.results.failed++;
                    this.logResult(container, name, false);
                }
            } catch (error) {
                this.results.failed++;
                this.logResult(container, name, false, error.message);
            }
        }

        this.showSummary(container);
    }

    logResult(container, testName, passed, error = null) {
        const resultDiv = document.createElement('div');
        resultDiv.style.cssText = `
            padding: 2px 0;
            color: ${passed ? 'green' : 'red'};
        `;
        resultDiv.innerHTML = `
            ${passed ? '✓' : '✗'} ${testName}
            ${error ? `<br>&nbsp;&nbsp;Error: ${error}` : ''}
        `;
        container.appendChild(resultDiv);
    }

    showSummary(container) {
        const summaryDiv = document.createElement('div');
        summaryDiv.style.cssText = `
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-weight: bold;
        `;
        
        const passRate = Math.round((this.results.passed / this.results.total) * 100);
        const status = passRate >= 80 ? 'GOOD' : passRate >= 60 ? 'FAIR' : 'POOR';
        const color = passRate >= 80 ? 'green' : passRate >= 60 ? 'orange' : 'red';
        
        summaryDiv.innerHTML = `
            <div style="color: ${color};">
                Status: ${status} (${passRate}%)
            </div>
            <div>
                Passed: ${this.results.passed}/${this.results.total}
            </div>
        `;
        container.appendChild(summaryDiv);

        // Auto-hide after 10 seconds
        setTimeout(() => {
            container.style.display = 'none';
        }, 10000);
    }

    // Public method to run specific test
    runTest(testName) {
        const test = this.tests.find(t => t.name === testName);
        if (test) {
            return test.test();
        }
        return false;
    }

    // Public method to get test results
    getResults() {
        return this.results;
    }
}

// Initialize test suite when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize in development/testing environment
    if (window.location.hostname === 'localhost' || 
        window.location.hostname === '127.0.0.1' ||
        window.location.search.includes('ui-test=true')) {
        window.uiTestSuite = new UITestSuite();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = UITestSuite;
}
