// Axios will be loaded via CDN if needed
// For now, using vanilla fetch API
if (typeof window.axios === 'undefined') {
    // Load axios from CDN if needed
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
    script.onload = function() {
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    };
    document.head.appendChild(script);
}
