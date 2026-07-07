import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import { applyTheme, getStoredTheme, persistTheme, storeTheme } from './theme';

window.Alpine = Alpine;
window.Chart = Chart;
window.applyTheme = applyTheme;
window.getStoredTheme = getStoredTheme;
window.storeTheme = storeTheme;
window.persistTheme = persistTheme;

Alpine.start();
