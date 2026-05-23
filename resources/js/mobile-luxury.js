/**
 * BALI Properties - Mobile Luxury JavaScript
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Features:
 * - Mobile menu interactions
 * - Lazy loading for images
 * - Smooth animations
 * - Touch gestures
 * - Performance optimizations
 */

class MobileLuxuryApp {
  constructor() {
    this.isMobile = window.innerWidth < 768;
    this.init();
  }

  init() {
    if (!this.isMobile) return;

    this.initMobileMenu();
    this.initLazyLoading();
    this.initScrollEffects();
    this.initTouchGestures();
    this.initAnimations();
    this.initPerformanceOptimizations();
  }

  /* ============================================
     MOBILE MENU SYSTEM
     ============================================ */

  initMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.mobile-sidebar');
    const overlay = document.querySelector('.mobile-sidebar-overlay');
    const closeButton = document.querySelector('.mobile-sidebar-close');
    const dropdownToggles = document.querySelectorAll('.mobile-nav-dropdown-toggle');

    if (!menuToggle || !sidebar) return;

    // Menu toggle functionality
    menuToggle.addEventListener('click', () => {
      this.toggleMobileMenu();
    });

    // Close via overlay
    if (overlay) {
      overlay.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }

    // Close via close button
    if (closeButton) {
      closeButton.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }

    // Dropdown toggles
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleDropdown(toggle);
      });
    });

    // Close menu when clicking on nav items (for navigation)
    const navItems = document.querySelectorAll('.mobile-nav-item:not(.mobile-nav-dropdown-toggle)');
    navItems.forEach(item => {
      item.addEventListener('click', () => {
        // Don't close immediately to allow for navigation
        setTimeout(() => {
          this.closeMobileMenu();
        }, 150);
      });
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768) {
        this.closeMobileMenu();
      }
    });
  }

  toggleMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;

    if (!sidebar || !menuToggle) return;

    const isOpen = sidebar.classList.contains('open');

    if (isOpen) {
      this.closeMobileMenu();
    } else {
      this.openMobileMenu();
    }
  }

  openMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;

    if (!sidebar || !menuToggle) return;

    sidebar.classList.add('open');
    menuToggle.classList.add('active');
    body.style.overflow = 'hidden';

    // Add escape key listener
    document.addEventListener('keydown', this.handleEscapeKey);

    // Animate menu items
    this.animateMenuItems();
  }

  closeMobileMenu() {
    const sidebar = document.querySelector('.mobile-sidebar');
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;

    if (!sidebar || !menuToggle) return;

    sidebar.classList.remove('open');
    menuToggle.classList.remove('active');
    body.style.overflow = '';

    // Remove escape key listener
    document.removeEventListener('keydown', this.handleEscapeKey);
  }

  handleEscapeKey = (e) => {
    if (e.key === 'Escape') {
      this.closeMobileMenu();
    }
  }

  toggleDropdown(toggle) {
    const submenu = toggle.nextElementSibling;
    const icon = toggle.querySelector('.mobile-nav-dropdown-icon');

    if (!submenu || !icon) return;

    const isOpen = submenu.classList.contains('open');

    if (isOpen) {
      submenu.classList.remove('open');
      icon.classList.remove('rotated');
    } else {
      submenu.classList.add('open');
      icon.classList.add('rotated');
    }
  }

  animateMenuItems() {
    const items = document.querySelectorAll('.mobile-nav-item');
    items.forEach((item, index) => {
      item.style.opacity = '0';
      item.style.transform = 'translateX(-20px)';
      
      setTimeout(() => {
        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        item.style.opacity = '1';
        item.style.transform = 'translateX(0)';
      }, index * 50);
    });
  }

  /* ============================================
     LAZY LOADING SYSTEM
     ============================================ */

  initLazyLoading() {
    // Use Intersection Observer for better performance
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            this.loadImage(img);
            observer.unobserve(img);
          }
        });
      }, {
        rootMargin: '50px 0px',
        threshold: 0.01
      });

      // Observe all images with data-src attribute
      const lazyImages = document.querySelectorAll('img[data-src]');
      lazyImages.forEach(img => {
        imageObserver.observe(img);
      });
    } else {
      // Fallback for browsers without Intersection Observer
      this.loadImagesFallback();
    }

    // Add skeleton loading
    this.initSkeletonLoading();
  }

  loadImage(img) {
    const src = img.dataset.src;
    const srcset = img.dataset.srcset;
    
    if (!src) return;

    // Create new image to preload
    const newImg = new Image();
    newImg.onload = () => {
      img.src = src;
      if (srcset) {
        img.srcset = srcset;
      }
      
      // Remove skeleton classes
      img.classList.remove('mobile-lazy-image', 'skeleton');
      img.classList.add('loaded');
      
      // Add fade-in animation
      img.style.opacity = '0';
      setTimeout(() => {
        img.style.transition = 'opacity 0.3s ease';
        img.style.opacity = '1';
      }, 10);
    };

    newImg.onerror = () => {
      // Handle loading error
      img.classList.remove('skeleton');
      img.classList.add('error');
      console.warn('Failed to load image:', src);
    };

    newImg.src = src;
  }

  loadImagesFallback() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const loadImages = () => {
      lazyImages.forEach(img => {
        if (this.isInViewport(img)) {
          this.loadImage(img);
        }
      });
    };

    // Load on scroll and resize
    window.addEventListener('scroll', loadImages);
    window.addEventListener('resize', loadImages);
    
    // Initial load
    loadImages();
  }

  initSkeletonLoading() {
    const images = document.querySelectorAll('img[data-src]');
    images.forEach(img => {
      if (!img.classList.contains('loaded')) {
        img.classList.add('mobile-lazy-image', 'skeleton');
      }
    });
  }

  isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  /* ============================================
     SCROLL EFFECTS
     ============================================ */

  initScrollEffects() {
    // Navbar scroll effect
    this.initNavbarScroll();
    
    // Parallax effects for hero
    this.initParallaxEffects();
    
    // Fade in animations on scroll
    this.initScrollAnimations();
  }

  initNavbarScroll() {
    const header = document.querySelector('.mobile-main-header');
    if (!header) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    const updateNavbar = () => {
      const currentScrollY = window.scrollY;
      
      if (currentScrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }

      // Parallax effect for logo if needed
      const logoSection = header.querySelector('.mobile-logo-section');
      if (logoSection && currentScrollY > 50) {
        // Optional: shrink logo or hide it on scroll
        // logoSection.style.height = '0';
        // logoSection.style.opacity = '0';
      } else if (logoSection) {
        // logoSection.style.height = 'auto';
        // logoSection.style.opacity = '1';
      }

      lastScrollY = currentScrollY;
      ticking = false;
    };

    const requestTick = () => {
      if (!ticking) {
        window.requestAnimationFrame(updateNavbar);
        ticking = true;
      }
    };

    window.addEventListener('scroll', requestTick);
  }

  initParallaxEffects() {
    const hero = document.querySelector('.mobile-hero');
    if (!hero) return;

    let ticking = false;

    const updateParallax = () => {
      const scrolled = window.pageYOffset;
      const rate = scrolled * -0.5;
      
      hero.style.transform = `translateY(${rate}px)`;
      ticking = false;
    };

    const requestTick = () => {
      if (!ticking) {
        window.requestAnimationFrame(updateParallax);
        ticking = true;
      }
    };

    window.addEventListener('scroll', requestTick);
  }

  initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.mobile-animate-on-scroll');
    if (animatedElements.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('mobile-animated');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    animatedElements.forEach(element => {
      observer.observe(element);
    });
  }

  /* ============================================
     TOUCH GESTURES
     ============================================ */

  initTouchGestures() {
    // Swipe gestures for property carousel
    this.initPropertySwipe();
    
    // Pull to refresh (if needed)
    this.initPullToRefresh();
  }

  initPropertySwipe() {
    const propertyCards = document.querySelectorAll('.mobile-property-card');
    
    propertyCards.forEach(card => {
      let touchStartX = 0;
      let touchEndX = 0;
      
      card.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      });
      
      card.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        this.handleSwipe(card, touchStartX, touchEndX);
      });
    });
  }

  handleSwipe(card, startX, endX) {
    const swipeThreshold = 50;
    const diff = startX - endX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe left - next image
        this.nextPropertyImage(card);
      } else {
        // Swipe right - previous image
        this.prevPropertyImage(card);
      }
    }
  }

  nextPropertyImage(card) {
    const nextBtn = card.querySelector('.mobile-property-nav.next');
    if (nextBtn) {
      nextBtn.click();
    }
  }

  prevPropertyImage(card) {
    const prevBtn = card.querySelector('.mobile-property-nav.prev');
    if (prevBtn) {
      prevBtn.click();
    }
  }

  initPullToRefresh() {
    // Optional: Implement pull to refresh if needed
    // This is a placeholder for future implementation
  }

  /* ============================================
     ANIMATIONS
     ============================================ */

  initAnimations() {
    // Stagger animations for property cards
    this.initPropertyCardAnimations();
    
    // Form field animations
    this.initFormAnimations();
  }

  initPropertyCardAnimations() {
    const cards = document.querySelectorAll('.mobile-property-card');
    if (cards.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, index * 100);
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1
    });

    cards.forEach(card => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(30px)';
      card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(card);
    });
  }

  initFormAnimations() {
    const formControls = document.querySelectorAll('.mobile-form-control');
    
    formControls.forEach(control => {
      control.addEventListener('focus', () => {
        control.parentElement.classList.add('focused');
      });
      
      control.addEventListener('blur', () => {
        if (control.value === '') {
          control.parentElement.classList.remove('focused');
        }
      });
    });
  }

  /* ============================================
     PERFORMANCE OPTIMIZATIONS
     ============================================ */

  initPerformanceOptimizations() {
    // Debounced scroll events
    this.debounceScrollEvents();
    
    // Throttled resize events
    this.throttleResizeEvents();
    
    // Optimize animations
    this.optimizeAnimations();
  }

  debounceScrollEvents() {
    let timeout;
    const scrollHandlers = [];
    
    window.addEventListener('scroll', () => {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        scrollHandlers.forEach(handler => handler());
      }, 10);
    });
  }

  throttleResizeEvents() {
    let timeout;
    let lastExecTime = 0;
    const throttleDelay = 100;
    
    window.addEventListener('resize', () => {
      const currentTime = Date.now();
      
      if (currentTime - lastExecTime > throttleDelay) {
        lastExecTime = currentTime;
        // Handle resize events
        this.handleResize();
      }
    });
  }

  handleResize() {
    // Recalculate mobile state
    const newIsMobile = window.innerWidth < 768;
    
    if (newIsMobile !== this.isMobile) {
      this.isMobile = newIsMobile;
      
      if (this.isMobile) {
        this.init();
      } else {
        // Clean up mobile-specific elements
        this.cleanupMobileElements();
      }
    }
  }

  cleanupMobileElements() {
    // Remove mobile menu state
    this.closeMobileMenu();
    
    // Reset any mobile-specific styles
    const mobileElements = document.querySelectorAll('[class*="mobile-"]');
    mobileElements.forEach(element => {
      // Reset transforms and other inline styles
      element.style.transform = '';
      element.style.opacity = '';
    });
  }

  optimizeAnimations() {
    // Use will-change for animated elements
    const animatedElements = document.querySelectorAll('.mobile-property-card, .mobile-hero');
    animatedElements.forEach(element => {
      element.style.willChange = 'transform, opacity';
    });
  }
}

/* ============================================
   UTILITY FUNCTIONS
   ============================================ */

// Debounce function
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

// Throttle function
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

/* ============================================
   INITIALIZATION
   ============================================ */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Check if mobile CSS is loaded
  const mobileCSS = document.querySelector('link[href*="mobile-luxury.css"]');
  if (mobileCSS) {
    mobileCSS.addEventListener('load', () => {
      new MobileLuxuryApp();
    });
  } else {
    // Fallback: initialize immediately
    new MobileLuxuryApp();
  }
});

// Handle page visibility changes for performance
document.addEventListener('visibilitychange', () => {
  if (document.hidden) {
    // Pause animations when page is hidden
    document.body.classList.add('performance-mode');
  } else {
    // Resume animations when page is visible
    document.body.classList.remove('performance-mode');
  }
});

// Export for global access
window.MobileLuxuryApp = MobileLuxuryApp;