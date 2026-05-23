/**
 * BALI Properties - Mobile Build Configuration
 * Author: Transformasi Mobile Design
 * Version: 1.0.0
 * 
 * Konfigurasi build untuk mobile assets
 */

const MobileBuildConfig = {
  // Input files
  input: {
    css: {
      main: 'resources/css/mobile-luxury.css',
      themes: [
        'resources/css/mobile-luxury.css'
      ]
    },
    js: {
      main: 'resources/js/mobile-luxury.js',
      integration: 'resources/js/mobile-integration.js',
      helpers: 'resources/js/mobile-template-helper.js',
      testing: 'resources/js/mobile-testing.js'
    }
  },

  // Output configuration
  output: {
    dir: 'public/assets/mobile/',
    css: 'public/assets/mobile/css/',
    js: 'public/assets/mobile/js/',
    images: 'public/assets/mobile/images/',
    fonts: 'public/assets/mobile/fonts/'
  },

  // Optimization settings
  optimization: {
    css: {
      minify: true,
      autoprefixer: true,
      purge: {
        enabled: true,
        content: [
          'resources/views/**/*.blade.php',
          'resources/js/**/*.js'
        ],
        safelist: [
          // Mobile component classes
          /^mobile-/,
          /mobile-.*$/,
          // Animation classes
          /animate-/,
          /fade/,
          /slide/,
          // State classes
          /active$/,
          /open$/,
          /loaded$/,
          /focused$/
        ]
      }
    },
    js: {
      minify: true,
      bundle: true,
      treeShake: true,
      targets: {
        browsers: ['> 1%', 'last 2 versions', 'iOS >= 12', 'Android >= 6']
      }
    },
    images: {
      compress: true,
      webp: true,
      responsive: true,
      sizes: [320, 640, 768, 1024, 1200]
    }
  },

  // Performance budgets
  performance: {
    css: {
      maxSize: '50KB',
      maxRequests: 2
    },
    js: {
      maxSize: '100KB',
      maxRequests: 3
    },
    images: {
      maxSize: '500KB per image',
      totalSize: '2MB'
    }
  },

  // Development settings
  development: {
    hotReload: true,
    sourceMaps: true,
    linting: true,
    testing: true
  },

  // Testing configuration
  testing: {
    devices: [
      { name: 'iPhone SE', width: 375, height: 667 },
      { name: 'iPhone 12', width: 390, height: 844 },
      { name: 'iPhone 14 Pro', width: 393, height: 852 },
      { name: 'Samsung Galaxy S20', width: 360, height: 800 },
      { name: 'iPad', width: 768, height: 1024 },
      { name: 'iPad Pro', width: 1024, height: 1366 }
    ],
    scenarios: [
      'navigation',
      'property-cards',
      'search-form',
      'image-loading',
      'animations',
      'performance'
    ],
    thresholds: {
      performance: 90,
      accessibility: 95,
      bestPractices: 90,
      seo: 90
    }
  },

  // Build tasks
  tasks: {
    // CSS build task
    buildCSS: async () => {
      console.log('📱 Building mobile CSS...');
      
      try {
        // Read source CSS
        const fs = require('fs').promises;
        const path = require('path');
        
        let css = await fs.readFile(MobileBuildConfig.input.css.main, 'utf8');
        
        // Process CSS
        css = await MobileBuildConfig.processors.css(css);
        
        // Write output
        const outputPath = path.join(MobileBuildConfig.output.css, 'mobile-luxury.min.css');
        await fs.mkdir(path.dirname(outputPath), { recursive: true });
        await fs.writeFile(outputPath, css);
        
        console.log(`✅ CSS built successfully (${css.length} bytes)`);
        return css;
      } catch (error) {
        console.error('❌ CSS build failed:', error);
        throw error;
      }
    },

    // JavaScript build task
    buildJS: async () => {
      console.log('📱 Building mobile JavaScript...');
      
      try {
        const fs = require('fs').promises;
        const path = require('path');
        
        // Read all JS files
        const files = Object.values(MobileBuildConfig.input.js);
        let combinedJS = '';
        
        for (const file of files) {
          const content = await fs.readFile(file, 'utf8');
          combinedJS += content + '\n';
        }
        
        // Process JavaScript
        combinedJS = await MobileBuildConfig.processors.js(combinedJS);
        
        // Write output
        const outputPath = path.join(MobileBuildConfig.output.js, 'mobile-luxury.bundle.min.js');
        await fs.mkdir(path.dirname(outputPath), { recursive: true });
        await fs.writeFile(outputPath, combinedJS);
        
        console.log(`✅ JavaScript built successfully (${combinedJS.length} bytes)`);
        return combinedJS;
      } catch (error) {
        console.error('❌ JavaScript build failed:', error);
        throw error;
      }
    },

    // Image optimization task
    optimizeImages: async () => {
      console.log('📱 Optimizing images...');
      
      try {
        const fs = require('fs').promises;
        const path = require('path');
        const sharp = require('sharp');
        
        const imageDir = 'public/images/properties/';
        const outputDir = MobileBuildConfig.output.images;
        
        await fs.mkdir(outputDir, { recursive: true });
        
        const images = await fs.readdir(imageDir);
        const imageFiles = images.filter(file => 
          /\.(jpg|jpeg|png|webp)$/i.test(file)
        );
        
        for (const image of imageFiles) {
          const inputPath = path.join(imageDir, image);
          const buffer = await fs.readFile(inputPath);
          
          // Generate responsive sizes
          for (const size of MobileBuildConfig.optimization.images.sizes) {
            const outputPath = path.join(outputDir, `${path.parse(image).name}-${size}w.webp`);
            
            await sharp(buffer)
              .resize(size, null, { withoutEnlargement: true })
              .webp({ quality: 85 })
              .toFile(outputPath);
          }
          
          console.log(`✅ Optimized ${image}`);
        }
        
        console.log(`✅ Image optimization completed (${imageFiles.length} images)`);
      } catch (error) {
        console.error('❌ Image optimization failed:', error);
        throw error;
      }
    },

    // Performance testing task
    testPerformance: async () => {
      console.log('📱 Testing performance...');
      
      try {
        const puppeteer = require('puppeteer');
        const lighthouse = require('lighthouse');
        const chromeLauncher = require('chrome-launcher');
        
        const chrome = await chromeLauncher.launch({ chromeFlags: ['--headless'] });
        const options = {
          logLevel: 'info',
          output: 'json',
          onlyCategories: ['performance', 'accessibility', 'best-practices', 'seo'],
          port: chrome.port
        };
        
        const runnerResult = await lighthouse('http://localhost:8000', options);
        
        await chrome.kill();
        
        const scores = runnerResult.lhr.categories;
        
        console.log('📊 Performance Scores:');
        console.log(`   Performance: ${scores.performance.score * 100}`);
        console.log(`   Accessibility: ${scores.accessibility.score * 100}`);
        console.log(`   Best Practices: ${scores.best-practices.score * 100}`);
        console.log(`   SEO: ${scores.seo.score * 100}`);
        
        return scores;
      } catch (error) {
        console.error('❌ Performance testing failed:', error);
        throw error;
      }
    }
  },

  // CSS processor
  processors: {
    css: async (css) => {
      // Add vendor prefixes
      css = css.replace(/transform:/g, '-webkit-transform: $&; transform:');
      css = css.replace(/transition:/g, '-webkit-transition: $&; transition:');
      css = css.replace(/animation:/g, '-webkit-animation: $&; animation:');
      
      // Minify (simple minification)
      css = css
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments
        .replace(/\s+/g, ' ') // Collapse whitespace
        .replace(/;\s*}/g, '}') // Remove last semicolon
        .replace(/\s*{\s*/g, '{') // Clean braces
        .replace(/;\s*/g, ';') // Clean semicolons
        .trim();
      
      return css;
    },

    js: async (js) => {
      // Simple minification (in production, use proper minifier)
      js = js
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments
        .replace(/\/\/.*$/gm, '') // Remove single-line comments
        .replace(/\s+/g, ' ') // Collapse whitespace
        .trim();
      
      return js;
    }
  },

  // Main build function
  build: async (options = {}) => {
    console.log('🚀 Starting mobile build process...');
    
    const startTime = Date.now();
    
    try {
      // Run build tasks
      const [css, js] = await Promise.all([
        MobileBuildConfig.tasks.buildCSS(),
        MobileBuildConfig.tasks.buildJS(),
        MobileBuildConfig.tasks.optimizeImages()
      ]);
      
      // Run performance tests
      if (options.test) {
        await MobileBuildConfig.tasks.testPerformance();
      }
      
      const endTime = Date.now();
      const duration = (endTime - startTime) / 1000;
      
      console.log(`\n✅ Build completed successfully in ${duration}s`);
      
      // Performance summary
      console.log('\n📊 Build Summary:');
      console.log(`   CSS: ${css.length} bytes`);
      console.log(`   JS: ${js.length} bytes`);
      
      return {
        success: true,
        duration,
        sizes: {
          css: css.length,
          js: js.length
        }
      };
      
    } catch (error) {
      console.error('❌ Build failed:', error);
      return {
        success: false,
        error: error.message
      };
    }
  },

  // Development server
  devServer: (port = 3000) => {
    const express = require('express');
    const app = express();
    const path = require('path');
    
    // Serve mobile assets
    app.use('/mobile', express.static(MobileBuildConfig.output.dir));
    
    // Hot reload endpoint
    if (MobileBuildConfig.development.hotReload) {
      const chokidar = require('chokidar');
      const watcher = chokidar.watch([
        MobileBuildConfig.input.css.main,
        MobileBuildConfig.input.js.main
      ]);
      
      watcher.on('change', async (path) => {
        console.log(`🔄 File changed: ${path}`);
        await MobileBuildConfig.build({ test: false });
      });
    }
    
    app.listen(port, () => {
      console.log(`🚀 Mobile development server running on http://localhost:${port}`);
    });
  },

  // Watch mode
  watch: () => {
    const chokidar = require('chokidar');
    const path = require('path');
    
    console.log('👀 Watching for changes...');
    
    const watcher = chokidar.watch([
      MobileBuildConfig.input.css.main,
      ...Object.values(MobileBuildConfig.input.js)
    ]);
    
    watcher.on('change', async (filePath) => {
      console.log(`📝 File changed: ${path.basename(filePath)}`);
      
      try {
        if (filePath.endsWith('.css')) {
          await MobileBuildConfig.tasks.buildCSS();
        } else if (filePath.endsWith('.js')) {
          await MobileBuildConfig.tasks.buildJS();
        }
        
        console.log('✅ Rebuild completed');
      } catch (error) {
        console.error('❌ Rebuild failed:', error);
      }
    });
  }
};

// CLI interface
if (require.main === module) {
  const args = process.argv.slice(2);
  const command = args[0];
  
  switch (command) {
    case 'build':
      MobileBuildConfig.build({ test: args.includes('--test') })
        .then(result => {
          if (result.success) {
            process.exit(0);
          } else {
            process.exit(1);
          }
        });
      break;
      
    case 'dev':
      const port = args[1] || 3000;
      MobileBuildConfig.devServer(port);
      break;
      
    case 'watch':
      MobileBuildConfig.watch();
      break;
      
    case 'test':
      MobileBuildConfig.tasks.testPerformance()
        .then(() => process.exit(0))
        .catch(() => process.exit(1));
      break;
      
    default:
      console.log(`
📱 Mobile Build Tool

Usage:
  node mobile-build.js build [--test]   Build mobile assets
  node mobile-build.js dev [port]       Start development server
  node mobile-build.js watch            Watch for changes
  node mobile-build.js test             Run performance tests

Examples:
  node mobile-build.js build --test
  node mobile-build.js dev 8080
  node mobile-build.js watch
      `);
  }
}

module.exports = MobileBuildConfig;