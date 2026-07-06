import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import { applyTheme, persistTheme } from './theme';

window.Alpine = Alpine;
window.Chart = Chart;
window.applyTheme = applyTheme;
window.persistTheme = persistTheme;

Alpine.start();
