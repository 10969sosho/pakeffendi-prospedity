/**
 * BALI Properties - Mobile Testing Suite
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Testing untuk cross-device compatibility dan responsive design
 */

class MobileTestingSuite {
  constructor() {
    this.devices = [
      { name: 'iPhone SE', width: 375, height: 667, userAgent: 'iPhone' },
      { name: 'iPhone 12', width: 390, height: 844, userAgent: 'iPhone' },
      { name: 'iPhone 14 Pro', width: 393, height: 852, userAgent: 'iPhone' },
      { name: 'Samsung Galaxy S20', width: 360, height: 800, userAgent: 'Android' },
      { name: 'iPad', width: 768, height: 1024, userAgent: 'iPad' },
      { name: 'iPad Pro', width: 1024, height: 1366, userAgent: 'iPad' }
    ];
    
    this.testResults = [];
    this.currentDevice = null;
  }

  // Run all tests
  async runAllTests() {
    console.log('🚀 Starting Mobile Testing Suite...');
    
    this.testResults = [];
    
    // Test each device
    for (const device of this.devices) {
      console.log(`📱 Testing ${device.name}...`);
      this.currentDevice = device;
      
      await this.simulateDevice(device);
      await this.runDeviceTests(device);
    }
    
    // Generate report
    this.generateTestReport();
    
    console.log('✅ Testing completed!');
  }

  // Simulate device environment
  async simulateDevice(device) {
    // Set viewport
    this.setViewport(device.width, device.height);
    
    // Set user agent
    this.setUserAgent(device.userAgent);
    
    // Wait for rendering
    await this.delay(500);
  }

  // Run tests for specific device
  async runDeviceTests(device) {
    const deviceResults = {
      device: device.name,
      width: device.width,
      height: device.height,
      tests: []
    };

    // Test 1: Responsive Breakpoints
    deviceResults.tests.push(this.testResponsiveBreakpoints(device));
    
    // Test 2: Font Scaling
    deviceResults.tests.push(this.testFontScaling(device));
    
    // Test 3: Layout Integrity
    deviceResults.tests.push(this.testLayoutIntegrity(device));
    
    // Test 4: Touch Targets
    deviceResults.tests.push(this.testTouchTargets(device));
    
    // Test 5: Image Loading
    deviceResults.tests.push(this.testImageLoading(device));
    
    // Test 6: Navigation
    deviceResults.tests.push(this.testNavigation(device));
    
    // Test 7: Performance
    deviceResults.tests.push(await this.testPerformance(device));
    
    // Test 8: Accessibility
    deviceResults.tests.push(this.testAccessibility(device));
    
    this.testResults.push(deviceResults);
  }

  // Test responsive breakpoints
  testResponsiveBreakpoints(device) {
    const test = {
      name: 'Responsive Breakpoints',
      status: 'passed',
      details: []
    };

    // Check if mobile styles are applied
    const mobileElements = document.querySelectorAll('.mobile-topbar, .mobile-sidebar, .mobile-property-card');
    
    if (device.width < 768) {
      if (mobileElements.length === 0) {
        test.status = 'failed';
        test.details.push('Mobile elements not found on mobile device');
      } else {
        test.details.push(`Found ${mobileElements.length} mobile elements`);
      }
    } else {
      if (mobileElements.length > 0) {
        test.status = 'failed';
        test.details.push('Mobile elements found on desktop device');
      } else {
        test.details.push('Correctly hidden on desktop');
      }
    }

    return test;
  }

  // Test font scaling
  testFontScaling(device) {
    const test = {
      name: 'Font Scaling',
      status: 'passed',
      details: []
    };

    // Test minimum font sizes
    const bodyText = document.querySelector('body');
    const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    
    if (bodyText) {
      const bodyFontSize = parseInt(window.getComputedStyle(bodyText).fontSize);
      if (bodyFontSize < 14) {
        test.status = 'failed';
        test.details.push(`Body font size too small: ${bodyFontSize}px (minimum: 14px)`);
      } else {
        test.details.push(`Body font size: ${bodyFontSize}px ✓`);
      }
    }

    headings.forEach((heading, index) => {
      const fontSize = parseInt(window.getComputedStyle(heading).fontSize);
      if (fontSize < 16) {
        test.status = 'failed';
        test.details.push(`Heading ${index + 1} font size too small: ${fontSize}px (minimum: 16px)`);
      }
    });

    return test;
  }

  // Test layout integrity
  testLayoutIntegrity(device) {
    const test = {
      name: 'Layout Integrity',
      status: 'passed',
      details: []
    };

    // Check for horizontal overflow
    const body = document.body;
    const hasOverflow = body.scrollWidth > body.clientWidth;
    
    if (hasOverflow) {
      test.status = 'warning';
      test.details.push('Horizontal overflow detected');
    } else {
      test.details.push('No horizontal overflow ✓');
    }

    // Check for overlapping elements
    const elements = document.querySelectorAll('.mobile-property-card, .mobile-topbar, .mobile-sidebar');
    let overlapFound = false;
    
    for (let i = 0; i < elements.length; i++) {
      for (let j = i + 1; j < elements.length; j++) {
        if (this.elementsOverlap(elements[i], elements[j])) {
          overlapFound = true;
          test.status = 'failed';
          test.details.push(`Overlapping elements detected: ${elements[i].className} and ${elements[j].className}`);
        }
      }
    }

    if (!overlapFound) {
      test.details.push('No overlapping elements ✓');
    }

    return test;
  }

  // Test touch targets
  testTouchTargets(device) {
    const test = {
      name: 'Touch Targets',
      status: 'passed',
      details: []
    };

    const interactiveElements = document.querySelectorAll(
      'button, a, input, select, .mobile-menu-toggle, .mobile-property-nav, .mobile-price-badge'
    );

    let smallTargets = 0;
    
    interactiveElements.forEach(element => {
      const rect = element.getBoundingClientRect();
      const width = rect.width;
      const height = rect.height;
      
      // Minimum touch target size: 44x44 pixels (iOS guidelines)
      if (width < 44 || height < 44) {
        smallTargets++;
        test.status = 'warning';
        test.details.push(`Small touch target: ${width}x${height}px (${element.tagName})`);
      }
    });

    if (smallTargets === 0) {
      test.details.push('All touch targets meet minimum size ✓');
    } else {
      test.details.push(`${smallTargets} touch targets below minimum size`);
    }

    return test;
  }

  // Test image loading
  testImageLoading(device) {
    const test = {
      name: 'Image Loading',
      status: 'passed',
      details: []
    };

    const images = document.querySelectorAll('img');
    let lazyImages = 0;
    let imagesWithoutAlt = 0;
    
    images.forEach(img => {
      // Check for lazy loading
      if (img.hasAttribute('data-src') || img.hasAttribute('loading')) {
        lazyImages++;
      }
      
      // Check for alt text
      if (!img.hasAttribute('alt') || img.getAttribute('alt') === '') {
        imagesWithoutAlt++;
        test.status = 'warning';
      }
    });

    test.details.push(`${lazyImages} images with lazy loading`);
    
    if (imagesWithoutAlt > 0) {
      test.details.push(`${imagesWithoutAlt} images missing alt text`);
    } else {
      test.details.push('All images have alt text ✓');
    }

    return test;
  }

  // Test navigation
  testNavigation(device) {
    const test = {
      name: 'Navigation',
      status: 'passed',
      details: []
    };

    // Test mobile menu
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.mobile-sidebar');
    
    if (device.width < 768) {
      if (!menuToggle || !sidebar) {
        test.status = 'failed';
        test.details.push('Mobile navigation elements missing');
      } else {
        test.details.push('Mobile navigation present ✓');
      }
    }

    // Test navigation links
    const navLinks = document.querySelectorAll('.mobile-nav-item, .mobile-footer-link');
    let brokenLinks = 0;
    
    navLinks.forEach(link => {
      if (!link.href || link.href === '#' || link.href === '') {
        brokenLinks++;
        test.status = 'warning';
      }
    });

    if (brokenLinks === 0) {
      test.details.push('All navigation links valid ✓');
    } else {
      test.details.push(`${brokenLinks} navigation links need attention`);
    }

    return test;
  }

  // Test performance
  async testPerformance(device) {
    const test = {
      name: 'Performance',
      status: 'passed',
      details: []
    };

    // Measure load time
    const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
    
    if (loadTime > 3000) {
      test.status = 'warning';
      test.details.push(`Load time: ${loadTime}ms (target: <3000ms)`);
    } else {
      test.details.push(`Load time: ${loadTime}ms ✓`);
    }

    // Check for large images
    const images = document.querySelectorAll('img');
    let largeImages = 0;
    
    images.forEach(img => {
      if (img.naturalWidth > 1200 || img.naturalHeight > 1200) {
        largeImages++;
        test.status = 'warning';
      }
    });

    if (largeImages > 0) {
      test.details.push(`${largeImages} images may be oversized for mobile`);
    }

    // Check for unused CSS
    const mobileCSS = document.querySelector('link[href*="mobile-luxury"]');
    if (mobileCSS) {
      test.details.push('Mobile CSS loaded ✓');
    } else {
      test.status = 'warning';
      test.details.push('Mobile CSS not detected');
    }

    return test;
  }

  // Test accessibility
  testAccessibility(device) {
    const test = {
      name: 'Accessibility',
      status: 'passed',
      details: []
    };

    // Test color contrast
    const elements = document.querySelectorAll('.mobile-badge, .mobile-btn, .mobile-nav-item');
    let contrastIssues = 0;
    
    elements.forEach(element => {
      const bgColor = this.getBackgroundColor(element);
      const textColor = this.getTextColor(element);
      
      if (bgColor && textColor) {
        const contrastRatio = this.getContrastRatio(bgColor, textColor);
        if (contrastRatio < 4.5) { // WCAG AA standard
          contrastIssues++;
          test.status = 'warning';
        }
      }
    });

    if (contrastIssues === 0) {
      test.details.push('Color contrast meets WCAG standards ✓');
    } else {
      test.details.push(`${contrastIssues} elements with low contrast`);
    }

    // Test ARIA labels
    const interactiveElements = document.querySelectorAll('button, a');
    let missingLabels = 0;
    
    interactiveElements.forEach(element => {
      if (!element.hasAttribute('aria-label') && !element.textContent.trim()) {
        missingLabels++;
        test.status = 'warning';
      }
    });

    if (missingLabels === 0) {
      test.details.push('All interactive elements have labels ✓');
    } else {
      test.details.push(`${missingLabels} elements missing labels`);
    }

    // Test keyboard navigation
    const focusableElements = document.querySelectorAll('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])');
    test.details.push(`${focusableElements.length} focusable elements`);

    return test;
  }

  // Helper methods
  setViewport(width, height) {
    // Simulate viewport (in real browser testing)
    Object.defineProperty(window, 'innerWidth', {
      writable: true,
      configurable: true,
      value: width,
    });
    Object.defineProperty(window, 'innerHeight', {
      writable: true,
      configurable: true,
      value: height,
    });
  }

  setUserAgent(userAgent) {
    // Simulate user agent (in real browser testing)
    Object.defineProperty(navigator, 'userAgent', {
      writable: true,
      configurable: true,
      value: userAgent,
    });
  }

  delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  elementsOverlap(el1, el2) {
    const rect1 = el1.getBoundingClientRect();
    const rect2 = el2.getBoundingClientRect();
    
    return !(rect1.right < rect2.left || 
             rect1.left > rect2.right || 
             rect1.bottom < rect2.top || 
             rect1.top > rect2.bottom);
  }

  getBackgroundColor(element) {
    const bg = window.getComputedStyle(element).backgroundColor;
    return this.parseColor(bg);
  }

  getTextColor(element) {
    const color = window.getComputedStyle(element).color;
    return this.parseColor(color);
  }

  parseColor(color) {
    // Simple color parsing (would need more robust implementation)
    const match = color.match(/rgb\((\d+), (\d+), (\d+)\)/);
    if (match) {
      return {
        r: parseInt(match[1]),
        g: parseInt(match[2]),
        b: parseInt(match[3])
      };
    }
    return null;
  }

  getContrastRatio(color1, color2) {
    const l1 = this.getLuminance(color1);
    const l2 = this.getLuminance(color2);
    const lighter = Math.max(l1, l2);
    const darker = Math.min(l1, l2);
    return (lighter + 0.05) / (darker + 0.05);
  }

  getLuminance(color) {
    const { r, g, b } = color;
    const [rs, gs, bs] = [r, g, b].map(c => {
      c = c / 255;
      return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
    });
    return 0.2126 * rs + 0.7152 * gs + 0.0722 * bs;
  }

  // Generate test report
  generateTestReport() {
    console.log('\n📊 MOBILE TESTING REPORT');
    console.log('=' .repeat(50));
    
    let totalTests = 0;
    let passedTests = 0;
    let failedTests = 0;
    let warningTests = 0;
    
    this.testResults.forEach(deviceResult => {
      console.log(`\n📱 ${deviceResult.device} (${deviceResult.width}x${deviceResult.height})`);
      console.log('-'.repeat(40));
      
      deviceResult.tests.forEach(test => {
        totalTests++;
        
        const statusIcon = {
          passed: '✅',
          failed: '❌',
          warning: '⚠️'
        }[test.status];
        
        console.log(`${statusIcon} ${test.name}`);
        
        if (test.details.length > 0) {
          test.details.forEach(detail => {
            console.log(`   ${detail}`);
          });
        }
        
        if (test.status === 'passed') passedTests++;
        else if (test.status === 'failed') failedTests++;
        else if (test.status === 'warning') warningTests++;
      });
    });
    
    console.log('\n📈 SUMMARY');
    console.log('=' .repeat(50));
    console.log(`Total Tests: ${totalTests}`);
    console.log(`✅ Passed: ${passedTests} (${((passedTests/totalTests)*100).toFixed(1)}%)`);
    console.log(`❌ Failed: ${failedTests} (${((failedTests/totalTests)*100).toFixed(1)}%)`);
    console.log(`⚠️  Warnings: ${warningTests} (${((warningTests/totalTests)*100).toFixed(1)}%)`);
    
    const successRate = ((passedTests + warningTests) / totalTests * 100).toFixed(1);
    console.log(`\n🎯 Success Rate: ${successRate}%`);
    
    if (successRate >= 90) {
      console.log('🎉 Excellent mobile compatibility!');
    } else if (successRate >= 80) {
      console.log('👍 Good mobile compatibility with minor issues');
    } else if (successRate >= 70) {
      console.log('⚠️  Fair mobile compatibility - needs improvement');
    } else {
      console.log('❌ Poor mobile compatibility - major issues found');
    }
  }

  // Run specific test
  async runTest(testName, device = null) {
    if (device) {
      await this.simulateDevice(device);
    }
    
    const testMethod = `test${testName.charAt(0).toUpperCase() + testName.slice(1)}`;
    if (typeof this[testMethod] === 'function') {
      return this[testMethod](device || this.currentDevice);
    }
    
    throw new Error(`Test ${testName} not found`);
  }

  // Quick validation
  quickValidate() {
    console.log('🔍 Running quick validation...');
    
    const issues = [];
    
    // Check for common mobile issues
    if (document.body.scrollWidth > window.innerWidth) {
      issues.push('Horizontal overflow detected');
    }
    
    const smallText = Array.from(document.querySelectorAll('*')).filter(el => {
      const fontSize = parseInt(window.getComputedStyle(el).fontSize);
      return fontSize < 14 && el.textContent.trim().length > 0;
    });
    
    if (smallText.length > 0) {
      issues.push(`${smallText.length} elements with small font size (<14px)`);
    }
    
    const smallButtons = Array.from(document.querySelectorAll('button, a')).filter(el => {
      const rect = el.getBoundingClientRect();
      return rect.width < 44 || rect.height < 44;
    });
    
    if (smallButtons.length > 0) {
      issues.push(`${smallButtons.length} buttons with small touch targets`);
    }
    
    if (issues.length === 0) {
      console.log('✅ No major mobile issues detected!');
    } else {
      console.log('⚠️  Issues found:');
      issues.forEach(issue => console.log(`   - ${issue}`));
    }
    
    return issues;
  }
}

// Auto-run tests if in development mode
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
  document.addEventListener('DOMContentLoaded', () => {
    console.log('🧪 Mobile Testing Suite loaded. Run window.runMobileTests() to start testing.');
  });
}

// Export for global use
window.MobileTestingSuite = MobileTestingSuite;
window.runMobileTests = () => {
  const tester = new MobileTestingSuite();
  tester.runAllTests();
};

window.quickMobileValidation = () => {
  const tester = new MobileTestingSuite();
  return tester.quickValidate();
};