/**
 * BALI Properties - Mobile Template Helper
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Fungsi-fungsi helper untuk mobile template
 */

/**
 * Mobile Navigation Helper
 * Membuat struktur navigation untuk mobile
 */
function getMobileNavigation() {
  return `
    <!-- Mobile Header Container -->
    <header class="mobile-main-header">
      <!-- Logo Section -->
      <div class="mobile-logo-section">
        <div class="mobile-logo-container">
          <svg width="120" height="40" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg" class="mobile-logo-svg">
            <g clip-path="url(#clip0_logo)">
              <path d="M188.263 355.73L188.595 355.73C195.441 348.845 205.766 339.761 219.569 328.477C232.93 317.193 242.978 308.205 249.714 301.511C256.34 294.626 260.867 287.358 263.296 279.708C265.725 272.058 264.565 264.121 259.816 255.896C254.516 246.716 247.062 239.352 237.454 233.805C227.957 228.067 217.908 225.198 207.307 225.198C196.927 225.197 190.136 227.97 186.934 233.516C183.621 238.872 184.726 246.331 190.247 255.894L125.647 255.891C116.371 239.825 112.395 225.481 113.72 212.858C115.265 200.235 121.559 190.481 132.602 183.596C143.754 176.52 158.607 172.982 177.159 172.983C196.594 172.984 215.863 176.523 234.968 183.6C253.961 190.486 271.299 200.241 286.98 212.864C302.661 225.488 315.14 239.833 324.416 255.899C333.03 270.817 336.841 283.918 335.847 295.203C335.075 306.487 331.376 316.336 324.75 324.751C318.346 333.167 308.408 343.494 294.936 355.734L377.094 355.737L405.917 405.656L217.087 405.649L188.263 355.73Z" fill="#1B1B18"/>
              <path d="M9.11884 226.339L-13.7396 226.338L-42.7286 176.132L43.0733 176.135L175.595 405.649L112.651 405.647L9.11884 226.339Z" fill="#1B1B18"/>
              <path d="M204.592 327.449L204.923 327.449C211.769 320.564 222.094 311.479 235.897 300.196C249.258 288.912 259.306 279.923 266.042 273.23C272.668 266.345 277.195 259.077 279.624 251.427C282.053 243.777 280.893 235.839 276.145 227.615C270.844 218.435 263.39 211.071 253.782 205.524C244.285 199.786 234.236 196.917 223.635 196.916C213.255 196.916 206.464 199.689 203.262 205.235C199.949 210.59 201.054 218.049 206.575 227.612L141.975 227.61C132.699 211.544 128.723 197.2 130.048 184.577C131.593 171.954 137.887 162.2 148.93 155.315C160.083 148.239 174.935 144.701 193.487 144.702C212.922 144.703 232.192 148.242 251.296 155.319C270.289 162.205 287.627 171.96 303.308 184.583C318.989 197.207 331.468 211.552 340.745 227.618C349.358 242.536 353.169 255.637 352.175 266.921C351.403 278.205 347.704 288.055 341.078 296.47C334.674 304.885 324.736 315.213 311.264 327.453L393.422 327.456L422.246 377.375L233.415 377.368L204.592 327.449Z" fill="#1B1B18"/>
              <path d="M25.447 198.058L2.58852 198.057L-26.4005 147.851L59.4015 147.854L191.923 377.368L128.979 377.365L25.447 198.058Z" fill="#1B1B18"/>
            </g>
            <defs>
              <clipPath id="clip0_logo">
                <rect width="500" height="500" fill="white"/>
              </clipPath>
            </defs>
          </svg>
        </div>
      </div>
      
      <!-- Mobile Topbar Actions -->
      <div class="mobile-topbar-actions">
        <button class="mobile-menu-toggle" aria-label="Toggle menu">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        
        <!-- Optional: Search or Call Action -->
        <a href="#search-properties" class="mobile-topbar-search" aria-label="Search">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </a>
      </div>
    </header>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar">
      <div class="mobile-sidebar-overlay"></div>
      <div class="mobile-sidebar-content">
        <div class="mobile-sidebar-header">
          <div class="mobile-sidebar-brand">
            <div class="mobile-sidebar-brand-title">PROSPEDITY</div>
            <div class="mobile-sidebar-brand-subtitle">Digital Properties Bali</div>
          </div>
          <button class="mobile-sidebar-close" aria-label="Close menu">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <nav class="mobile-nav">
          <a href="/" class="mobile-nav-item active">Home</a>
          <div class="mobile-nav-dropdown">
            <button class="mobile-nav-item mobile-nav-dropdown-toggle">
              Properties
              <svg class="mobile-nav-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div class="mobile-nav-submenu">
              <a href="/properties/villas" class="mobile-nav-item mobile-nav-submenu-item">Villas & Houses</a>
              <a href="/properties/apartments" class="mobile-nav-item mobile-nav-submenu-item">Apartments</a>
              <a href="/properties/land" class="mobile-nav-item mobile-nav-submenu-item">Land</a>
              <a href="/properties/commercials" class="mobile-nav-item mobile-nav-submenu-item">Commercials</a>
            </div>
          </div>
          <a href="/featured-properties" class="mobile-nav-item">Featured Properties</a>
          <a href="/successful-properties" class="mobile-nav-item">Successful Properties</a>
          <a href="/advisor-guide" class="mobile-nav-item">Advisor Guide</a>
          <a href="/about-us" class="mobile-nav-item">Contact Us</a>
        </nav>
      </div>
    </div>
  `;
}

/**
 * Mobile Hero Section Helper
 */
function getMobileHero(title = "Luxury Properties in Bali", subtitle = "Discover your dream property in paradise") {
  return `
    <section class="mobile-hero">
      <div class="mobile-hero-content">
        <h1 class="mobile-hero-title">${title}</h1>
        <p class="mobile-hero-subtitle">${subtitle}</p>
        <a href="#search-properties" class="mobile-hero-cta">Explore Properties</a>
      </div>
    </section>
  `;
}

/**
 * Mobile Search Form Helper
 */
function getMobileSearchForm() {
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

        <div class="mobile-form-group">
          <label class="mobile-form-label">Price Range</label>
          <div class="mobile-grid mobile-grid-cols-2 mobile-gap-2">
            <input type="number" class="mobile-form-control" name="min_price" placeholder="Min Price">
            <input type="number" class="mobile-form-control" name="max_price" placeholder="Max Price">
          </div>
        </div>

        <div class="mobile-advanced-toggle" onclick="toggleAdvancedSearch()">
          <span>Advanced Search</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </div>

        <div class="mobile-advanced-content" id="advanced-search">
          <div class="mobile-form-group">
            <label class="mobile-form-label">Bedrooms</label>
            <select class="mobile-form-control" name="bedroom">
              <option value="">Any</option>
              <option value="1">1 Bedroom</option>
              <option value="2">2 Bedrooms</option>
              <option value="3">3 Bedrooms</option>
              <option value="4">4+ Bedrooms</option>
            </select>
          </div>

          <div class="mobile-form-group">
            <label class="mobile-form-label">Property Category</label>
            <select class="mobile-form-control" name="property_category">
              <option value="">Select Category</option>
              <option value="FREEHOLD">Freehold</option>
              <option value="LEASEHOLD">Leasehold</option>
              <option value="RENT_YEARLY">Rent Yearly</option>
              <option value="RENT_MONTHLY">Rent Monthly</option>
            </select>
          </div>
        </div>

        <div class="mobile-form-actions">
          <button type="button" class="mobile-btn mobile-btn-secondary" onclick="clearSearch()">Clear</button>
          <button type="submit" class="mobile-btn mobile-btn-primary">Search Properties</button>
        </div>
      </form>
    </section>
  `;
}

/**
 * Mobile Property Card Helper
 */
function getMobilePropertyCard(property) {
  const {
    id,
    title,
    location,
    price,
    bedroom,
    bathroom,
    land_size,
    image,
    property_number,
    status,
    tags = []
  } = property;

  return `
    <div class="mobile-property-card mobile-animate-on-scroll">
      <div class="mobile-property-image-container">
        <img 
          src="${image}" 
          alt="${title}"
          class="mobile-property-image mobile-lazy-image"
          data-src="${image}"
          loading="lazy"
        >
        
        <div class="mobile-property-badges">
          ${status ? `<span class="mobile-badge mobile-badge-${getStatusColor(status)}">${status}</span>` : ''}
          ${tags.map(tag => `<span class="mobile-badge mobile-badge-secondary">${tag}</span>`).join('')}
        </div>

        <button class="mobile-property-nav prev" onclick="prevImage(${id})" aria-label="Previous image">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>
        <button class="mobile-property-nav next" onclick="nextImage(${id})" aria-label="Next image">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>
      </div>

      <div class="mobile-property-content">
        <h3 class="mobile-property-title">${title}</h3>
        
        <div class="mobile-property-location">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          ${location}
          ${property_number ? `<span class="mobile-text-gray-600">| ${property_number}</span>` : ''}
        </div>

        <div class="mobile-property-details">
          ${bedroom ? `
            <div class="mobile-property-detail">
              <span class="mobile-property-detail-value">${bedroom}</span>
              <span class="mobile-property-detail-label">Bedrooms</span>
            </div>
          ` : ''}
          ${bathroom ? `
            <div class="mobile-property-detail">
              <span class="mobile-property-detail-value">${bathroom}</span>
              <span class="mobile-property-detail-label">Bathrooms</span>
            </div>
          ` : ''}
          ${land_size ? `
            <div class="mobile-property-detail">
              <span class="mobile-property-detail-value">${land_size}</span>
              <span class="mobile-property-detail-label">m²</span>
            </div>
          ` : ''}
        </div>

        <div class="mobile-property-price">
          <div class="mobile-price-display">${formatPrice(price)}</div>
          <div class="mobile-price-badges">
            <button class="mobile-price-badge active" onclick="updatePrice(${id}, 'freehold')">Freehold</button>
            <button class="mobile-price-badge" onclick="updatePrice(${id}, 'leasehold')">Leasehold</button>
          </div>
        </div>

        <button class="mobile-property-cta" onclick="viewProperty(${id})">View Details</button>
      </div>
    </div>
  `;
}

/**
 * Mobile Footer Helper
 */
function getMobileFooter() {
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
            <li><a href="/successful-properties" class="mobile-footer-link">Success Stories</a></li>
            <li><a href="/advisor-guide" class="mobile-footer-link">Advisor Guide</a></li>
          </ul>
        </div>

        <div class="mobile-footer-section">
          <h4 class="mobile-footer-title">Contact</h4>
          <ul class="mobile-footer-links">
            <li><a href="mailto:info@prospedity.com" class="mobile-footer-link">Email Us</a></li>
            <li><a href="https://wa.me/6281234567890" class="mobile-footer-link">WhatsApp</a></li>
            <li><a href="tel:+6281234567890" class="mobile-footer-link">Call Us</a></li>
          </ul>
          
          <div class="mobile-footer-social">
            <a href="#" class="mobile-footer-social-link" aria-label="Instagram">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a href="#" class="mobile-footer-social-link" aria-label="Facebook">
              <span class="font-bold">f</span>
            </a>
            <a href="#" class="mobile-footer-social-link" aria-label="TikTok">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
              </svg>
            </a>
          </div>
        </div>

        <div class="mobile-footer-bottom">
          <p>&copy; 2024 Prospedity Digital Properties. All rights reserved.</p>
        </div>
      </div>
    </footer>
  `;
}

/**
 * Floating Action Buttons Helper
 */
function getMobileFAB() {
  return `
    <a href="https://wa.me/6281234567890" class="mobile-fab mobile-fab-whatsapp" target="_blank" aria-label="WhatsApp">
      <svg fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
      </svg>
    </a>
    
    <button class="mobile-fab mobile-fab-chat" onclick="toggleChat()" aria-label="Live Chat">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
      </svg>
    </button>
  `;
}

/**
 * Utility Functions
 */
function getStatusColor(status) {
  const colors = {
    'SOLD': 'danger',
    'RENTED': 'primary',
    'NEW': 'success',
    'FEATURED': 'secondary'
  };
  return colors[status] || 'primary';
}

function formatPrice(price) {
  if (!price || price === 0) return 'Price on Request';
  
  // Format IDR currency
  const number = typeof price === 'string' ? parseInt(price.replace(/[^0-9]/g, '')) : price;
  return 'IDR ' + number.toLocaleString('id-ID');
}

/**
 * JavaScript Functions for Mobile Interactions
 */
function getMobileJSFunctions() {
  return `
    <script>
      // Toggle advanced search
      function toggleAdvancedSearch() {
        const content = document.getElementById('advanced-search');
        const toggle = event.currentTarget;
        const icon = toggle.querySelector('svg');
        
        content.classList.toggle('show');
        icon.classList.toggle('rotate-180');
      }
      
      // Clear search form
      function clearSearch() {
        const form = document.querySelector('.mobile-search-form');
        form.reset();
      }
      
      // Property image navigation
      function nextImage(propertyId) {
        // Implementation for next image
        console.log('Next image for property:', propertyId);
      }
      
      function prevImage(propertyId) {
        // Implementation for previous image
        console.log('Previous image for property:', propertyId);
      }
      
      // Update price display
      function updatePrice(propertyId, type) {
        // Implementation for price update
        console.log('Update price for property:', propertyId, 'type:', type);
        
        // Update active state
        const badges = document.querySelectorAll(\`[onclick*="updatePrice(\${propertyId}"]\`);
        badges.forEach(badge => badge.classList.remove('active'));
        event.currentTarget.classList.add('active');
      }
      
      // View property details
      function viewProperty(propertyId) {
        window.location.href = \`/property/\${propertyId}\`;
      }
      
      // Toggle chat widget
      function toggleChat() {
        // Implementation for chat toggle
        console.log('Toggle chat widget');
      }
      
      // Initialize mobile interactions
      document.addEventListener('DOMContentLoaded', function() {
        // Add mobile-specific interactions here
        console.log('Mobile interactions initialized');
      });
    </script>
  `;
}

/**
 * Complete Mobile Template
 */
function getCompleteMobileTemplate(content = '') {
  return `
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>BALI Properties - Luxury Real Estate</title>
      
      <!-- Mobile Luxury CSS -->
      <link rel="stylesheet" href="/css/mobile-luxury.css">
      
      <!-- Preload critical resources -->
      <link rel="preload" href="/js/mobile-luxury.js" as="script">
      <link rel="preload" href="/css/mobile-luxury.css" as="style">
      
      <!-- Meta tags for mobile optimization -->
      <meta name="theme-color" content="#96A480">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <meta name="apple-mobile-web-app-title" content="BALI Properties">
      
      <!-- PWA manifest -->
      <link rel="manifest" href="/manifest.json">
      
      <!-- Icons -->
      <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
      <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    </head>
    <body>
      ${getMobileNavigation()}
      
      <main class="mobile-main">
        ${content}
      </main>
      
      ${getMobileFooter()}
      ${getMobileFAB()}
      
      <!-- Mobile Luxury JavaScript -->
      <script src="/js/mobile-luxury.js"></script>
      ${getMobileJSFunctions()}
    </body>
    </html>
  `;
}

// Export functions for use in other files
if (typeof module !== 'undefined' && module.exports) {
  module.exports = {
    getMobileNavigation,
    getMobileHero,
    getMobileSearchForm,
    getMobilePropertyCard,
    getMobileFooter,
    getMobileFAB,
    getCompleteMobileTemplate,
    formatPrice,
    getStatusColor
  };
}