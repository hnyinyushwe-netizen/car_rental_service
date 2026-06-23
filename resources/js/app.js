// Vite entrypoint: utilities, UI libs and initialization

// Datepicker (existing project dependency)
import { Datepicker } from 'vanillajs-datepicker';
import 'vanillajs-datepicker/css/datepicker.css';
window.Datepicker = Datepicker;

// Utilities (axios wrapper and toast)
import { api, toast } from './utils';
window.api = api;     // optional: global for inline blade scripts
window.toast = toast; // optional: global for inline blade scripts

// jQuery (for legacy inline scripts if any)
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Chart.js (make Chart global for inline chart initializations in blade files)
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Lucide icons
import * as lucide from 'lucide';

// Initialize Lucide icons when DOM is ready
function initLucideIcons() {
    if (typeof lucide !== 'undefined') {
        // newer lucide exposes createIcons; older versions may expose replace
        if (typeof lucide.createIcons === 'function') {
            try { lucide.createIcons(); } catch (e) { /* ignore */ }
        } else if (typeof lucide.replace === 'function') {
            try { lucide.replace(); } catch (e) { /* ignore */ }
        }
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucideIcons);
} else {
    initLucideIcons();
}

// Reinitialize icons when DOM changes (dynamic content)
const observer = new MutationObserver(initLucideIcons);
observer.observe(document.body, { childList: true, subtree: true });

// Export helpers for other modules
export { api, toast, initLucideIcons };
