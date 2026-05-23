/**
 * BALI Properties - Mobile Implementation
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Implementasi lengkap mobile design system ke dalam sistem yang ada
 */

// Mobile Implementation Class
class BaliMobileImplementation {
  constructor() {
    this.config = {
      mobileBreakpoint: 768,
      autoInit: true,
      debug: false,
      performanceMode: 'auto'
    };
    
    this.state = {
      isMobile: false,
      initialized: false,
      components: new Map(),
      observers: new Map()
    };
    
    this.init();
  }

  // Initialize mobile implementation
  init() {
    if (this.state.initialized) return;
    
    console.log('🚀 Initializing BALI Mobile Implementation...');
    
    // Check device type
    this.detectDevice();
    
    // Setup mobile detection
    this.setupMobileDetection();
    
    // Load mobile assets if needed
    if (this.state.isMobile) {
      this.loadMobileAssets()
        .then(() => {
          this.setupComponents();
          this.setupEventListeners();
          this.optimizePerformance();
          this.state.initialized = true;
          console.log('✅ Mobile implementation completed');
        })
        .catch(error => {
          console.error('❌ Mobile implementation failed:', error);
        });
    } else {
      console.log('💻 Desktop detected - mobile implementation skipped');
      this.state.initialized = true;
    }
  }

  // Detect device type
  detectDevice() {
    const width = window.innerWidth;
    const userAgent = navigator.userAgent.toLowerCase();
    
    // Check for mobile indicators
    const mobileKeywords = [
      'android', 'webos', 'iphone', 'ipad', 'ipod', 'blackberry',
      'windows phone', 'mobile', 'tablet', 'touch'
    ];
    
    const isMobileUA = mobileKeywords.some(keyword => 
      userAgent.includes(keyword)
    );
    
    this.state.isMobile = width < this.config.mobileBreakpoint || isMobileUA;
    
    if (this.config.debug) {
      console.log('📱 Device detection:', {
        width,
        userAgent,
        isMobile: this.state.isMobile,
        isMobileUA
      });
    }
  }

  // Setup mobile detection with resize handling
  setupMobileDetection() {
    const handleResize = this.debounce(() => {
      const wasMobile = this.state.isMobile;
      this.detectDevice();
      
      if (wasMobile !== this.state.isMobile) {
        console.log('📱 Device type changed:', wasMobile ? 'Mobile → Desktop' : 'Desktop → Mobile');
        
        if (this.state.isMobile) {
          this.enableMobileMode();
        } else {
          this.disableMobileMode();
        }
      }
    }, 250);
    
    window.addEventListener('resize', handleResize);
    window.addEventListener('orientationchange', handleResize);
  }

  // Load mobile assets
  async loadMobileAssets() {
    const assets = [
      {
        type: 'css',
        url: '/css/mobile-luxury.css',
        id: 'mobile-luxury-css'
      },
      {
        type: 'js',
        url: '/js/mobile-luxury.js',
        id: 'mobile-luxury-js'
      },
      {
        type: 'js',
        url: '/js/mobile-integration.js',
        id: 'mobile-integration-js'
      }
    ];
    
    const promises = assets.map(asset => this.loadAsset(asset));
    await Promise.all(promises);
    
    if (this.config.debug) {
      console.log('📦 Mobile assets loaded successfully');
    }
  }

  // Load individual asset
  loadAsset(asset) {
    return new Promise((resolve, reject) => {
      // Check if already loaded
      if (document.getElementById(asset.id)) {
        resolve();
        return;
      }
      
      let element;
      
      if (asset.type === 'css') {
        element = document.createElement('link');
        element.rel = 'stylesheet';
        element.href = asset.url;
      } else if (asset.type === 'js') {
        element = document.createElement('script');
        element.src = asset.url;
        element.async = true;
      }
      
      element.id = asset.id;
      element.onload = resolve;
      element.onerror = reject;
      
      document.head.appendChild(element);
    });
  }

  // Setup mobile components
  setupComponents() {
    // Navigation
    this.setupMobileNavigation();
    
    // Property cards
    this.setupPropertyCards();
    
    // Search forms
    this.setupSearchForms();
    
    // Footer
    this.setupMobileFooter();
    
    // Floating buttons
    this.setupFloatingButtons();
    
    // Hero section
    this.setupHeroSection();
  }

  // Setup mobile navigation
  setupMobileNavigation() {
    // Hide desktop navigation
    const desktopNav = document.querySelector('.navbar');
    const desktopTopbar = document.querySelector('.desktop-topbar');
    
    if (desktopNav) {
      desktopNav.style.display = 'none';
      desktopNav.setAttribute('data-mobile-hidden', 'true');
    }
    
    if (desktopTopbar) {
      desktopTopbar.style.display = 'none';
      desktopTopbar.setAttribute('data-mobile-hidden', 'true');
    }
    
    // Create mobile navigation if not exists
    if (!document.querySelector('.mobile-topbar')) {
      this.createMobileNavigation();
    }
  }

  // Create mobile navigation
  createMobileNavigation() {
    const navData = this.extractNavigationData();
    const mobileNavHTML = this.generateMobileNavigationHTML(navData);
    
    document.body.insertAdjacentHTML('afterbegin', mobileNavHTML);
    
    // Initialize mobile navigation functionality
    if (window.MobileLuxuryApp) {
      new MobileLuxuryApp();
    }
  }

  // Extract navigation data from existing desktop nav
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
  }

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
  }

  // Setup property cards
  setupPropertyCards() {
    const propertyCards = document.querySelectorAll('.bg-white.rounded-lg.shadow-md, .bg-white.rounded-lg.shadow-lg');
    
    propertyCards.forEach(card => {
      this.transformPropertyCard(card);
    });
  }

  // Transform individual property card
  transformPropertyCard(card) {
    // Skip if already transformed
    if (card.classList.contains('mobile-property-card')) return;
    
    // Store original classes
    this.state.components.set(card, card.className);
    
    // Get property data
    const propertyData = this.extractPropertyData(card);
    
    // Replace with mobile structure
    const mobileCardHTML = this.generateMobilePropertyCardHTML(propertyData);
    
    card.className = 'mobile-property-card mobile-animate-on-scroll';
    card.innerHTML = mobileCardHTML;
    
    // Setup lazy loading for images
    this.setupImageLazyLoading(card);
  }

  // Extract property data from existing card
  extractPropertyData(card) {
    const title = card.querySelector('h3')?.textContent?.trim() || 'Property';
    const location = this.extractLocation(card);
    const price = card.querySelector('.text-2xl')?.textContent?.trim() || 'Price on Request';
    const image = card.querySelector('img')?.src || '/images/placeholder.jpg';
    
    return {
      title,
      location,
      price,
      image,
      id: Math.random().toString(36).substr(2, 9)
    };
  }

  // Extract location from card
  extractLocation(card) {
    const locationText = card.textContent;
    const locationMatch = locationText.match(/(Seminyak|Canggu|Ubud|Uluwatu|Sanur|Berawa|Pererenan)/i);
    return locationMatch ? locationMatch[0] : 'Bali';
  }

  // Generate mobile property card HTML
  generateMobilePropertyCardHTML(data) {
    return `
      <div class="mobile-property-image-container">
        <img src="${data.image}" alt="${data.title}" 
             class="mobile-property-image mobile-lazy-image" 
             data-src="${data.image}" 
             loading="lazy">
        <div class="mobile-property-badges">
          <span class="mobile-badge mobile-badge-primary">Featured</span>
        </div>
      </div>
      <div class="mobile-property-content">
        <h3 class="mobile-property-title">${data.title}</h3>
        <div class="mobile-property-location">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          </svg>
          ${data.location}
        </div>
        <div class="mobile-property-price">
          <div class="mobile-price-display">${data.price}</div>
        </div>
        <button class="mobile-property-cta" onclick="window.location.href='${data.href || '#'}'">
          View Details
        </button>
      </div>
    `;
  }

  // Setup image lazy loading
  setupImageLazyLoading(container) {
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.classList.remove('mobile-lazy-image', 'skeleton');
              img.classList.add('loaded');
              observer.unobserve(img);
            }
          }
        });
      }, {
        rootMargin: '50px 0px',
        threshold: 0.01
      });
      
      const images = container.querySelectorAll('img[data-src]');
      images.forEach(img => {
        imageObserver.observe(img);
      });
    }
  }

  // Setup search forms
  setupSearchForms() {
    const searchSections = document.querySelectorAll('#search-properties, .bg-white.py-8');
    
    searchSections.forEach(section => {
      if (this.isSearchSection(section)) {
        this.transformSearchSection(section);
      }
    });
  }

  // Check if section is search section
  isSearchSection(section) {
    return section.querySelector('form[action*="property"]') !== null ||
           section.querySelector('select[name*="property"]') !== null ||
           section.textContent.toLowerCase().includes('search');
  }

  // Transform search section
  transformSearchSection(section) {
    // Store original content
    this.state.components.set(section, section.outerHTML);
    
    // Replace with mobile search form
    const mobileSearchHTML = this.generateMobileSearchFormHTML();
    section.outerHTML = mobileSearchHTML;
  }

  // Generate mobile search form HTML
  generateMobileSearchFormHTML() {
    return `
      <section class="mobile-search-section" id="search-properties">
        <div class="mobile-search-header">
          <h2 class="mobile-search-title">Search Properties</h2>
          <p class="mobile-search-subtitle">Find your perfect property in Bali</p>
        </div>
        
        <form class="mobile-search-form" action="/properties" method="GET">
          <div class="mobile-form-group">
            <label class="mobile-form-label">Property Type</label>
            <select class="mobile-form-control" name="property_type">
              <option value="">Select Property Type</option>
              <option value="villas">Villas & Houses</option>
              <option value="apartments">Apartments</option>
              <option value="land">Land</option>
              <option value="commercials">Commercials</option>
            </select>
          </div>
          
          <div class="mobile-form-group">
            <label class="mobile-form-label">Location</label>
            <select class="mobile-form-control" name="location">
              <option value="">Select Location</option>
              <option value="seminyak">Seminyak</option>
              <option value="canggu">Canggu</option>
              <option value="ubud">Ubud</option>
              <option value="uluwatu">Uluwatu</option>
              <option value="sanur">Sanur</option>
            </select>
          </div>
          
          <div class="mobile-form-actions">
            <button type="submit" class="mobile-btn mobile-btn-primary">Search Properties</button>
          </div>
        </form>
      </section>
    `;
  }

  // Setup mobile footer
  setupMobileFooter() {
    const footer = document.querySelector('footer');
    if (!footer || footer.classList.contains('mobile-footer')) return;
    
    // Store original footer
    this.state.components.set(footer, footer.outerHTML);
    
    // Replace with mobile footer
    const mobileFooterHTML = this.generateMobileFooterHTML();
    footer.outerHTML = mobileFooterHTML;
  }

  // Generate mobile footer HTML
  generateMobileFooterHTML() {
    return `
      <footer class="mobile-footer">
        <div class="mobile-footer-content">
          <div class="mobile-footer-section">
            <h3 class="mobile-footer-title">PROSPEDITY</h3>
            <p class="mobile-footer-subtitle">Digital Properties Bali</p>
            <p class="mobile-footer-text">
              Curating exceptional villas and investment properties in Bali's most sought-after locations.
            </p>
            <a href="/contact-us" class="mobile-footer-cta">Contact Us</a>
          </div>
          
          <div class="mobile-footer-section">
            <h4 class="mobile-footer-title">Discover</h4>
            <ul class="mobile-footer-links">
              <li><a href="/" class="mobile-footer-link">Home</a></li>
              <li><a href="/properties" class="mobile-footer-link">Properties</a></li>
              <li><a href="/featured-properties" class="mobile-footer-link">Featured</a></li>
            </ul>
          </div>
          
          <div class="mobile-footer-bottom">
            <p>&copy; 2024 Prospedity Digital Properties. All rights reserved.</p>
          </div>
        </div>
      </footer>
    `;
  }

  // Setup floating buttons
  setupFloatingButtons() {
    if (document.querySelector('.mobile-fab')) return;
    
    const fabHTML = this.generateFloatingButtonsHTML();
    document.body.insertAdjacentHTML('beforeend', fabHTML);
  }

  // Generate floating buttons HTML
  generateFloatingButtonsHTML() {
    return `
      <a href="https://wa.me/6281234567890" class="mobile-fab mobile-fab-whatsapp" target="_blank" aria-label="WhatsApp">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
      </a>
    `;
  }

  // Setup hero section
  setupHeroSection() {
    const heroSection = document.querySelector('.relative.h-96, section.bg-white.py-12.mt-8');
    if (!heroSection || heroSection.classList.contains('mobile-hero')) return;
    
    // Transform to mobile hero if applicable
    if (this.shouldTransformHero(heroSection)) {
      this.transformHeroSection(heroSection);
    }
  }

  // Check if hero section should be transformed
  shouldTransformHero(heroSection) {
    return heroSection.textContent.toLowerCase().includes('bali') ||
           heroSection.textContent.toLowerCase().includes('property') ||
           heroSection.textContent.toLowerCase().includes('villa');
  }

  // Transform hero section
  transformHeroSection(heroSection) {
    const heroData = this.extractHeroData(heroSection);
    const mobileHeroHTML = this.generateMobileHeroHTML(heroData);
    
    heroSection.outerHTML = mobileHeroHTML;
  }

  // Extract hero data
  extractHeroData(heroSection) {
    const title = heroSection.querySelector('h1')?.textContent?.trim() || 'Luxury Properties in Bali';
    const subtitle = heroSection.querySelector('p')?.textContent?.trim() || 'Discover your dream property in paradise';
    
    return { title, subtitle };
  }

  // Generate mobile hero HTML
  generateMobileHeroHTML(data) {
    return `
      <section class="mobile-hero">
        <div class="mobile-hero-content">
          <h1 class="mobile-hero-title">${data.title}</h1>
          <p class="mobile-hero-subtitle">${data.subtitle}</p>
          <a href="#search-properties" class="mobile-hero-cta">Explore Properties</a>
        </div>
      </section>
    `;
  }

  // Setup event listeners
  setupEventListeners() {
    // Scroll events
    this.setupScrollEffects();
    
    // Touch events
    this.setupTouchEvents();
    
    // Form events
    this.setupFormEvents();
    
    // Navigation events
    this.setupNavigationEvents();
  }

  // Setup scroll effects
  setupScrollEffects() {
    let lastScrollY = window.scrollY;
    let ticking = false;
    
    const updateScrollEffects = () => {
      const currentScrollY = window.scrollY;
      
      // Update navbar
      const topbar = document.querySelector('.mobile-topbar');
      if (topbar) {
        if (currentScrollY > 20) {
          topbar.classList.add('scrolled');
        } else {
          topbar.classList.remove('scrolled');
        }
      }
      
      // Update hero parallax
      const hero = document.querySelector('.mobile-hero');
      if (hero) {
        const rate = currentScrollY * -0.3;
        hero.style.transform = `translateY(${rate}px)`;
      }
      
      lastScrollY = currentScrollY;
      ticking = false;
    };
    
    const requestTick = () => {
      if (!ticking) {
        window.requestAnimationFrame(updateScrollEffects);
        ticking = true;
      }
    };
    
    window.addEventListener('scroll', requestTick, { passive: true });
  }

  // Setup touch events
  setupTouchEvents() {
    // Property card swipe gestures
    const propertyCards = document.querySelectorAll('.mobile-property-card');
    
    propertyCards.forEach(card => {
      let touchStartX = 0;
      let touchEndX = 0;
      
      card.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      
      card.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        this.handleCardSwipe(card, touchStartX, touchEndX);
      }, { passive: true });
    });
  }

  // Handle card swipe
  handleCardSwipe(card, startX, endX) {
    const swipeThreshold = 50;
    const diff = startX - endX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe left - next image
        const nextBtn = card.querySelector('.mobile-property-nav.next');
        if (nextBtn) nextBtn.click();
      } else {
        // Swipe right - previous image
        const prevBtn = card.querySelector('.mobile-property-nav.prev');
        if (prevBtn) prevBtn.click();
      }
    }
  }

  // Setup form events
  setupFormEvents() {
    const forms = document.querySelectorAll('.mobile-search-form');
    
    forms.forEach(form => {
      // Add form validation
      form.addEventListener('submit', (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault();
        }
      });
      
      // Add input animations
      const inputs = form.querySelectorAll('.mobile-form-control');
      inputs.forEach(input => {
        input.addEventListener('focus', () => {
          input.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', () => {
          if (input.value === '') {
            input.parentElement.classList.remove('focused');
          }
        });
      });
    });
  }

  // Validate form
  validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.classList.add('error');
        isValid = false;
      } else {
        field.classList.remove('error');
      }
    });
    
    return isValid;
  }

  // Setup navigation events
  setupNavigationEvents() {
    // Mobile menu toggle
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    if (menuToggle) {
      menuToggle.addEventListener('click', () => {
        this.toggleMobileMenu();
      });
    }
    
    // Overlay click to close menu
    const overlay = document.querySelector('.mobile-sidebar-overlay');
    if (overlay) {
      overlay.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }
    
    // Close button
    const closeBtn = document.querySelector('.mobile-sidebar-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }
    
    // Escape key to close menu
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeMobileMenu();
      }
    });
  }

  // Toggle mobile menu
  toggleMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    if (!sidebar) return;
    
    const isOpen = sidebar.classList.contains('open');
    
    if (isOpen) {
      this.closeMobileMenu();
    } else {
      this.openMobileMenu();
    }
  }

  // Open mobile menu
  openMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    const body = document.body;
    
    if (sidebar) {
      sidebar.classList.add('open');
      body.style.overflow = 'hidden';
    }
  }

  // Close mobile menu
  closeMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    const body = document.body;
    
    if (sidebar) {
      sidebar.classList.remove('open');
      body.style.overflow = '';
    }
  }

  // Optimize performance
  optimizePerformance() {
    // Connection-aware optimizations
    this.optimizeForConnection();
    
    // Device capability optimizations
    this.optimizeForDevice();
    
    // Battery-aware optimizations
    this.optimizeForBattery();
  }

  // Optimize based on connection
  optimizeForConnection() {
    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    
    if (connection) {
      if (connection.effectiveType === '2g' || connection.effectiveType === 'slow-2g') {
        this.enableLowBandwidthMode();
      } else if (connection.effectiveType === '3g') {
        this.enableMediumBandwidthMode();
      }
    }
  }

  // Optimize for device capabilities
  optimizeForDevice() {
    // Check device memory
    if (navigator.deviceMemory && navigator.deviceMemory < 4) {
      this.enableLowMemoryMode();
    }
    
    // Check CPU cores
    if (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4) {
      this.enableLowCPUMode();
    }
  }

  // Optimize for battery
  optimizeForBattery() {
    if ('getBattery' in navigator) {
      navigator.getBattery().then(battery => {
        if (battery.level < 0.2 && !battery.charging) {
          this.enablePowerSaveMode();
        }
        
        // Listen for battery changes
        battery.addEventListener('levelchange', () => {
          if (battery.level < 0.2 && !battery.charging) {
            this.enablePowerSaveMode();
          }
        });
      });
    }
  }

  // Low bandwidth optimizations
  enableLowBandwidthMode() {
    // Disable complex animations
    document.documentElement.style.setProperty('--transition-fast', '0ms');
    document.documentElement.style.setProperty('--transition-normal', '0ms');
    document.documentElement.style.setProperty('--transition-slow', '0ms');
    
    // Disable lazy loading for faster initial load
    const images = document.querySelectorAll('img[data-src]');
    images.forEach(img => {
      if (img.dataset.src) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      }
    });
    
    if (this.config.debug) {
      console.log('📉 Low bandwidth mode enabled');
    }
  }

  // Low memory optimizations
  enableLowMemoryMode() {
    // Reduce animation complexity
    document.body.classList.add('reduce-motion');
    
    // Limit concurrent image loading
    const images = document.querySelectorAll('img');
    images.forEach((img, index) => {
      setTimeout(() => {
        if (img.dataset.src) {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
        }
      }, index * 100);
    });
    
    if (this.config.debug) {
      console.log('💾 Low memory mode enabled');
    }
  }

  // Low CPU optimizations
  enableLowCPUMode() {
    // Reduce animation frame rate
    document.body.classList.add('low-fps-mode');
    
    if (this.config.debug) {
      console.log('⚡ Low CPU mode enabled');
    }
  }

  // Power save mode
  enablePowerSaveMode() {
    this.enableLowBandwidthMode();
    this.enableLowMemoryMode();
    this.enableLowCPUMode();
    
    // Reduce screen brightness hint (if supported)
    if ('wakeLock' in navigator) {
      // Could implement wake lock management here
    }
    
    if (this.config.debug) {
      console.log('🔋 Power save mode enabled');
    }
  }

  // Medium bandwidth optimizations
  enableMediumBandwidthMode() {
    // Reduce animation duration
    document.documentElement.style.setProperty('--transition-fast', '100ms');
    document.documentElement.style.setProperty('--transition-normal', '150ms');
    document.documentElement.style.setProperty('--transition-slow', '200ms');
    
    if (this.config.debug) {
      console.log('📊 Medium bandwidth mode enabled');
    }
  }

  // Enable mobile mode
  enableMobileMode() {
    if (!this.state.initialized) {
      this.init();
    } else {
      this.setupComponents();
      this.setupEventListeners();
      this.optimizePerformance();
    }
  }

  // Disable mobile mode
  disableMobileMode() {
    // Restore desktop elements
    const hiddenElements = document.querySelectorAll('[data-mobile-hidden="true"]');
    hiddenElements.forEach(element => {
      element.style.display = '';
      element.removeAttribute('data-mobile-hidden');
    });
    
    // Remove mobile elements
    const mobileElements = document.querySelectorAll('.mobile-topbar, .mobile-sidebar, .mobile-footer, .mobile-fab, .mobile-hero, .mobile-search-section');
    mobileElements.forEach(element => element.remove());
    
    // Restore original components
    this.state.components.forEach((originalHTML, element) => {
      if (element.parentNode) {
        element.outerHTML = originalHTML;
      }
    });
    
    // Clear state
    this.state.components.clear();
    
    if (this.config.debug) {
      console.log('💻 Mobile mode disabled');
    }
  }

  // Utility functions
  debounce(func, wait) {
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

  throttle(func, limit) {
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
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Check if mobile implementation should be enabled
  const shouldEnableMobile = window.innerWidth < 768 || 
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  
  if (shouldEnableMobile) {
    window.baliMobile = new BaliMobileImplementation();
  } else {
    console.log('💻 Desktop mode - mobile implementation will activate on resize if needed');
    
    // Setup resize listener for future mobile detection
    const resizeHandler = () => {
      if (window.innerWidth < 768) {
        window.baliMobile = new BaliMobileImplementation();
        window.removeEventListener('resize', resizeHandler);
      }
    };
    
    window.addEventListener('resize', resizeHandler);
  }
});

// Export for global use
window.BaliMobileImplementation = BaliMobileImplementation;