/**
 * BALI Properties - Mobile Integration Configuration
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Konfigurasi untuk mengintegrasikan mobile styling ke sistem yang ada
 */

// Mobile Detection and Integration
const MobileIntegration = {
  // Configuration
  config: {
    mobileBreakpoint: 768,
    cssPath: '/css/mobile-luxury.css',
    jsPath: '/js/mobile-luxury.js',
    helperPath: '/js/mobile-template-helper.js',
    enableLazyLoading: true,
    enableAnimations: true,
    enableTouchGestures: true,
    performanceMode: 'auto' // auto, high, low
  },

  // State
  state: {
    isMobile: false,
    mobileElements: [],
    originalElements: new Map(),
    cssLoaded: false,
    jsLoaded: false
  },

  // Initialize mobile integration
  init(options = {}) {
    this.config = { ...this.config, ...options };
    
    // Check if mobile
    this.state.isMobile = this.isMobileDevice();
    
    if (this.state.isMobile) {
      this.loadMobileAssets()
        .then(() => {
          this.transformToMobile();
          this.setupEventListeners();
          this.optimizePerformance();
        })
        .catch(error => {
          console.error('Mobile integration failed:', error);
        });
    }

    // Setup resize listener
    this.setupResizeListener();
  },

  // Check if device is mobile
  isMobileDevice() {
    const width = window.innerWidth;
    const userAgent = navigator.userAgent.toLowerCase();
    const isTouchDevice = 'ontouchstart' in window;
    
    const mobileKeywords = [
      'android', 'webos', 'iphone', 'ipad', 'ipod', 'blackberry',
      'windows phone', 'mobile', 'tablet', 'touch'
    ];
    
    const isMobileUA = mobileKeywords.some(keyword => 
      userAgent.includes(keyword)
    );
    
    return width < this.config.mobileBreakpoint || isMobileUA;
  },

  // Load mobile CSS and JS
  async loadMobileAssets() {
    const promises = [];

    // Load CSS
    if (!this.state.cssLoaded) {
      promises.push(this.loadCSS(this.config.cssPath));
    }

    // Load JavaScript
    if (!this.state.jsLoaded) {
      promises.push(this.loadJS(this.config.jsPath));
      promises.push(this.loadJS(this.config.helperPath));
    }

    await Promise.all(promises);
    
    this.state.cssLoaded = true;
    this.state.jsLoaded = true;
  },

  // Load CSS file
  loadCSS(href) {
    return new Promise((resolve, reject) => {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = href;
      link.onload = resolve;
      link.onerror = reject;
      document.head.appendChild(link);
    });
  },

  // Load JavaScript file
  loadJS(src) {
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.async = true;
      script.onload = resolve;
      script.onerror = reject;
      document.head.appendChild(script);
    });
  },

  // Transform desktop elements to mobile
  transformToMobile() {
    // Hide desktop elements
    this.hideDesktopElements();
    
    // Create mobile navigation
    this.createMobileNavigation();
    
    // Transform property cards
    this.transformPropertyCards();
    
    // Transform search forms
    this.transformSearchForms();
    
    // Transform footer
    this.transformFooter();
    
    // Add floating action buttons
    this.createFloatingButtons();
    
    // Add mobile-specific classes
    this.addMobileClasses();
  },

  // Hide desktop-specific elements
  hideDesktopElements() {
    const desktopElements = [
      '.desktop-topbar',
      '.navbar',
      '.topbar.desktop-topbar',
      '.desktop-only',
      '[class*="desktop-"]'
    ];

    desktopElements.forEach(selector => {
      const elements = document.querySelectorAll(selector);
      elements.forEach(element => {
        element.style.display = 'none';
        element.setAttribute('data-mobile-hidden', 'true');
      });
    });
  },

  // Create mobile navigation
  createMobileNavigation() {
    // Check if mobile navigation already exists
    if (document.querySelector('.mobile-topbar')) return;

    // Get navigation data from existing desktop nav
    const navData = this.extractNavigationData();
    
    // Create mobile navigation HTML
    const mobileNavHTML = this.generateMobileNavigationHTML(navData);
    
    // Insert at the beginning of body
    document.body.insertAdjacentHTML('afterbegin', mobileNavHTML);
    
    this.state.mobileElements.push('.mobile-topbar', '.mobile-sidebar');
  },

  // Extract navigation data from desktop
  extractNavigationData() {
    const navData = {
      brand: 'PROSPEDITY',
      subtitle: 'Digital Properties Bali',
      items: []
    };

    // Extract from desktop navbar
    const navbar = document.querySelector('.navbar');
    if (navbar) {
      const links = navbar.querySelectorAll('a');
      links.forEach(link => {
        navData.items.push({
          text: link.textContent.trim(),
          href: link.href,
          active: link.classList.contains('active') || window.location.href === link.href
        });
      });
    }

    return navData;
  },

  // Generate mobile navigation HTML
  generateMobileNavigationHTML(navData) {
    const navItems = navData.items.map(item => {
      const activeClass = item.active ? 'active' : '';
      return `<a href="${item.href}" class="mobile-nav-item ${activeClass}">${item.text}</a>`;
    }).join('');

    return `
      <!-- Mobile Topbar -->
      <div class="mobile-topbar">
        <div class="mobile-topbar-brand">${navData.brand}</div>
        <button class="mobile-menu-toggle" aria-label="Toggle menu">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>

      <!-- Mobile Sidebar -->
      <div class="mobile-sidebar">
        <div class="mobile-sidebar-overlay"></div>
        <div class="mobile-sidebar-content">
          <div class="mobile-sidebar-header">
            <div class="mobile-sidebar-brand">
              <div class="mobile-sidebar-brand-title">${navData.brand}</div>
              <div class="mobile-sidebar-brand-subtitle">${navData.subtitle}</div>
            </div>
            <button class="mobile-sidebar-close" aria-label="Close menu">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <nav class="mobile-nav">
            ${navItems}
          </nav>
        </div>
      </div>
    `;
  },

  // Transform property cards to mobile
  transformPropertyCards() {
    const propertyCards = document.querySelectorAll('.bg-white.rounded-lg.shadow-md, .bg-white.rounded-lg.shadow-lg');
    
    propertyCards.forEach(card => {
      // Store original classes
      this.state.originalElements.set(card, card.className);
      
      // Replace with mobile classes
      card.className = 'mobile-property-card mobile-animate-on-scroll';
      
      // Transform content
      this.transformPropertyCardContent(card);
    });
  },

  // Transform individual property card content
  transformPropertyCardContent(card) {
    // Get property data from card
    const title = card.querySelector('h3')?.textContent || '';
    const location = card.querySelector('p')?.textContent || '';
    const price = card.querySelector('.text-2xl')?.textContent || '';
    const image = card.querySelector('img')?.src || '';
    
    // Create mobile card structure
    const mobileCardHTML = `
      <div class="mobile-property-image-container">
        <img src="${image}" alt="${title}" class="mobile-property-image mobile-lazy-image" data-src="${image}" loading="lazy">
        <div class="mobile-property-badges">
          <span class="mobile-badge mobile-badge-primary">Featured</span>
        </div>
      </div>
      <div class="mobile-property-content">
        <h3 class="mobile-property-title">${title}</h3>
        <div class="mobile-property-location">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          </svg>
          ${location}
        </div>
        <div class="mobile-property-price">
          <div class="mobile-price-display">${price}</div>
        </div>
        <button class="mobile-property-cta" onclick="window.location.href='${card.href}'">View Details</button>
      </div>
    `;
    
    card.innerHTML = mobileCardHTML;
  },

  // Transform search forms
  transformSearchForms() {
    const searchSections = document.querySelectorAll('#search-properties, .bg-white.py-8');
    
    searchSections.forEach(section => {
      // Check if this is a search section
      if (section.querySelector('form[action*="property"]') || section.querySelector('select[name*="property"]')) {
        this.transformSearchSection(section);
      }
    });
  },

  // Transform search section
  transformSearchSection(section) {
    // Store original content
    this.state.originalElements.set(section, section.innerHTML);
    
    // Create mobile search form
    const mobileSearchHTML = getMobileSearchForm();
    section.innerHTML = mobileSearchHTML;
    section.className = 'mobile-search-section';
  },

  // Transform footer
  transformFooter() {
    const footer = document.querySelector('footer');
    if (!footer) return;
    
    // Store original footer
    this.state.originalElements.set(footer, footer.outerHTML);
    
    // Replace with mobile footer
    const mobileFooterHTML = getMobileFooter();
    footer.outerHTML = mobileFooterHTML;
    
    this.state.mobileElements.push('.mobile-footer');
  },

  // Create floating action buttons
  createFloatingButtons() {
    // Check if FAB already exists
    if (document.querySelector('.mobile-fab')) return;
    
    const fabHTML = getMobileFAB();
    document.body.insertAdjacentHTML('beforeend', fabHTML);
    
    this.state.mobileElements.push('.mobile-fab');
  },

  // Add mobile-specific classes to elements
  addMobileClasses() {
    // Add mobile prefix to existing classes
    const elements = document.querySelectorAll('main, section, div');
    elements.forEach(element => {
      if (element.className && !element.className.includes('mobile-')) {
        element.classList.add('mobile-element');
      }
    });
  },

  // Setup event listeners
  setupEventListeners() {
    // Handle window resize
    window.addEventListener('resize', debounce(() => {
      this.handleResize();
    }, 250));

    // Handle orientation change
    window.addEventListener('orientationchange', () => {
      setTimeout(() => {
        this.handleResize();
      }, 100);
    });

    // Handle page visibility
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        this.pauseAnimations();
      } else {
        this.resumeAnimations();
      }
    });
  },

  // Handle window resize
  handleResize() {
    const newIsMobile = this.isMobileDevice();
    
    if (newIsMobile !== this.state.isMobile) {
      this.state.isMobile = newIsMobile;
      
      if (this.state.isMobile) {
        // Switch to mobile
        this.transformToMobile();
      } else {
        // Switch to desktop
        this.restoreDesktop();
      }
    }
  },

  // Restore desktop view
  restoreDesktop() {
    // Show desktop elements
    const hiddenElements = document.querySelectorAll('[data-mobile-hidden="true"]');
    hiddenElements.forEach(element => {
      element.style.display = '';
      element.removeAttribute('data-mobile-hidden');
    });

    // Remove mobile elements
    this.state.mobileElements.forEach(selector => {
      const elements = document.querySelectorAll(selector);
      elements.forEach(element => element.remove());
    });

    // Restore original elements
    this.state.originalElements.forEach((originalHTML, element) => {
      if (element.parentNode) {
        element.outerHTML = originalHTML;
      }
    });

    // Clear state
    this.state.mobileElements = [];
    this.state.originalElements.clear();
  },

  // Performance optimizations
  optimizePerformance() {
    if (this.config.performanceMode === 'low') {
      this.disableAnimations();
    } else if (this.config.performanceMode === 'auto') {
      this.autoOptimizePerformance();
    }
  },

  // Auto optimize based on device capabilities
  autoOptimizePerformance() {
    // Check device memory
    if (navigator.deviceMemory && navigator.deviceMemory < 4) {
      this.disableComplexAnimations();
    }

    // Check connection type
    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    if (connection) {
      if (connection.effectiveType === '2g' || connection.effectiveType === 'slow-2g') {
        this.disableLazyLoading();
        this.disableAnimations();
      } else if (connection.effectiveType === '3g') {
        this.reduceAnimationQuality();
      }
    }

    // Check battery level (if available)
    if ('getBattery' in navigator) {
      navigator.getBattery().then(battery => {
        if (battery.level < 0.2 && !battery.charging) {
          this.enablePowerSaveMode();
        }
      });
    }
  },

  // Disable animations
  disableAnimations() {
    document.documentElement.style.setProperty('--transition-fast', '0ms');
    document.documentElement.style.setProperty('--transition-normal', '0ms');
    document.documentElement.style.setProperty('--transition-slow', '0ms');
  },

  // Disable complex animations
  disableComplexAnimations() {
    document.body.classList.add('reduce-motion');
  },

  // Disable lazy loading
  disableLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    images.forEach(img => {
      if (img.dataset.src) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      }
    });
  },

  // Reduce animation quality
  reduceAnimationQuality() {
    document.documentElement.style.setProperty('--transition-fast', '100ms');
    document.documentElement.style.setProperty('--transition-normal', '150ms');
    document.documentElement.style.setProperty('--transition-slow', '200ms');
  },

  // Enable power save mode
  enablePowerSaveMode() {
    this.disableAnimations();
    this.disableLazyLoading();
    
    // Reduce frame rate for animations
    document.body.classList.add('power-save-mode');
  },

  // Pause animations
  pauseAnimations() {
    document.body.classList.add('animations-paused');
  },

  // Resume animations
  resumeAnimations() {
    document.body.classList.remove('animations-paused');
  },

  // Setup resize listener with debouncing
  setupResizeListener() {
    let resizeTimeout;
    
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        this.handleResize();
      }, 250);
    });
  }
};

// Utility functions
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

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    MobileIntegration.init();
  });
} else {
  // DOM is already loaded
  MobileIntegration.init();
}

// Export for global use
window.MobileIntegration = MobileIntegration;