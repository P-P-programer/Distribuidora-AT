import {
  Chart,
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

document.addEventListener('DOMContentLoaded', () => {
  const data = window.analyticsData || { topSold: [], lowStock: [] };

  const makeBar = (canvasId, labels, values, color, label) => {
    const el = document.getElementById(canvasId);
    if (!el) return;
    if (!labels.length) {
      el.parentElement.innerHTML += '<p class="muted" style="margin-top:.5rem;">Sin datos</p>';
      return;
    }
    new Chart(el, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label,
          data: values,
          backgroundColor: color,
          borderRadius: 8,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { precision: 0 } }
        }
      }
    });
  };

  makeBar(
    'chartTopSold',
    data.topSold.map(x => x.label),
    data.topSold.map(x => x.value),
    '#2563eb',
    'Unidades vendidas'
  );

  makeBar(
    'chartLowStock',
    data.lowStock.map(x => x.label),
    data.lowStock.map(x => x.value),
    '#f59e0b',
    'Stock'
  );
});