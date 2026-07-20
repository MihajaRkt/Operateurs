// Minimal chart rendering without external libs
document.addEventListener('DOMContentLoaded', function () {
  initCharts();
  initObjectifAjax();
  initActivitiesToggle();
});

// AJAX for objectif choice
function initObjectifAjax() {
  const form = document.getElementById('choixObj');
  if (!form) return;

  // Simple non-AJAX handler: validate then let the browser submit normally.
  form.addEventListener('submit', function(e) {
    // Ensure an objectif is selected; if not, prevent submit and alert.
    const selectedRadio = document.querySelector('input[name="objectif"]:checked');
    if (!selectedRadio) {
      e.preventDefault();
      alert('Veuillez sélectionner un objectif');
      return;
    }

    // Show loader overlay (optional) and allow normal form submit/navigation.
    const loaderOverlay = document.getElementById('loaderOverlay');
    if (loaderOverlay) loaderOverlay.classList.add('active');
    // Do not call e.preventDefault() - let the form POST to the server.
  });
}

function initActivitiesToggle() {
  const button = document.getElementById('toggleActivitiesButton');
  const extraActivities = document.getElementById('extraActivities');
  if (!button || !extraActivities) return;

  button.addEventListener('click', function () {
    const isHidden = extraActivities.classList.toggle('is-hidden');
    button.textContent = isHidden ? 'Voir plus' : 'Voir moins';
    button.setAttribute('aria-expanded', String(!isHidden));
  });
}

    function initCharts() {
  const dashboardData = window.__dashboardData || {};

  // weightChart - simple line
  const weightEl = document.getElementById('weightChart');
  if (weightEl && weightEl.getContext) {
    const ctx = weightEl.getContext('2d');
    drawLineChart(
      ctx,
      dashboardData.weightLabels || ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7'],
      dashboardData.weightValues || [68, 67.5, 67, 66.5, 66, 65.5, 65],
      { title: 'Poids sur 7 semaines', color: '#10b981', fill: true, yLabel: 'kg' }
    );
  }

  // caloriesChart - bar
  const caloriesEl = document.getElementById('caloriesChart');
  if (caloriesEl && caloriesEl.getContext) {
    const ctx2 = caloriesEl.getContext('2d');
    drawBarChart(
      ctx2,
      dashboardData.caloriesLabels || ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
      dashboardData.caloriesValues || [2150, 2300, 2100, 2250, 2200, 2400, 2100],
      { color: '#10b981', title: 'Calories consommées', yLabel: 'kcal' }
    );
  }

  // nutritionChart - doughnut (approx)
  const nutritionEl = document.getElementById('nutritionChart');
  if (nutritionEl && nutritionEl.getContext) {
    const ctx3 = nutritionEl.getContext('2d');
    drawDoughnut(
      ctx3,
      dashboardData.nutritionValues || [50, 30, 20],
      dashboardData.nutritionColors || ['#10b981', '#059669', '#d1fae5'],
      dashboardData.nutritionLabels || ['Glucides', 'Protéines', 'Lipides'],
      { title: 'Répartition nutritionnelle' }
    );
  }

  // hydrationChart - radar simplified as area
  const hydrationEl = document.getElementById('hydrationChart');
  if (hydrationEl && hydrationEl.getContext) {
    const ctx4 = hydrationEl.getContext('2d');
    drawLineChart(
      ctx4,
      dashboardData.hydrationLabels || ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
      dashboardData.hydrationValues || [2.2, 2.5, 2.1, 2.4, 2.6, 2.3, 2.1],
      { fill: true, color: '#10b981', title: 'Hydratation quotidienne', yLabel: 'L' }
    );
  }

  // Admin charts (if present)
  const genderEl = document.getElementById('genderChart');
  if (genderEl && genderEl.getContext) {
    const ctx5 = genderEl.getContext('2d');
    // read counts from data attribute if provided, else dummy
    const dataset = window.__genderData || [3, 4];
    drawDoughnut(ctx5, dataset, ['#10b981', '#059669']);
  }

  const weightDistEl = document.getElementById('weightDistributionChart');
  if (weightDistEl && weightDistEl.getContext) {
    const ctx6 = weightDistEl.getContext('2d');
    const data = window.__weightDist || [1, 3, 2, 0, 0];
    drawBarChart(ctx6, ['<60', '60-70', '70-80', '80-90', '>90'], data, '#10b981');
  }

  const heightEl = document.getElementById('heightDistributionChart');
  if (heightEl && heightEl.getContext) {
    drawBarChart(heightEl.getContext('2d'), ['<150', '150-160', '160-170', '170-180', '>180'], window.__heightDist || [0, 2, 4, 1, 0], '#6366f1');
  }

  const imcEl = document.getElementById('imcChart');
  if (imcEl && imcEl.getContext) {
    const list = window.__imcData || [22, 24, 26, 23, 28];
    drawScatter(imcEl.getContext('2d'), list);
  }
    }

    function clearCanvas(ctx) {
  const c = ctx.canvas; ctx.clearRect(0, 0, c.width, c.height);
    }

    function fitCanvas(canvas) {
  const ratio = window.devicePixelRatio || 1;
  const w = canvas.clientWidth || 300;
  const h = canvas.clientHeight || 200;
  canvas.width = w * ratio;
  canvas.height = h * ratio;
  const ctx = canvas.getContext('2d'); ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
  return ctx;
    }

    function drawLineChart(ctx, labels, data, opts) {
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const w = ctx.canvas.clientWidth || 300; const h = ctx.canvas.clientHeight || 200;
  const padding = 34;
  const max = Math.max.apply(null, data);
  const min = Math.min.apply(null, data);
  const range = (max - min) || 1;
  const color = opts && opts.color ? opts.color : '#10b981';

  if (opts && opts.title) {
    canvasCtx.fillStyle = '#14532d';
    canvasCtx.font = '600 12px sans-serif';
    canvasCtx.fillText(opts.title, padding, 16);
  }

  // draw grid
  canvasCtx.strokeStyle = '#e6f0ea'; canvasCtx.lineWidth = 1;
  for (let i = 0; i <= 4; i++) { let y = padding + (h - 2 * padding) * (i / 4); canvasCtx.beginPath(); canvasCtx.moveTo(padding, y); canvasCtx.lineTo(w - padding, y); canvasCtx.stroke(); }
  // plot
  canvasCtx.strokeStyle = color;
  canvasCtx.lineWidth = 2; canvasCtx.beginPath();
  data.forEach((v, i) => {
    const x = padding + (i / (data.length - 1 || 1)) * (w - 2 * padding);
    const y = padding + (1 - (v - min) / range) * (h - 2 * padding);
    if (i === 0) canvasCtx.moveTo(x, y); else canvasCtx.lineTo(x, y);
  });
  canvasCtx.stroke();
  if (opts && opts.fill) { canvasCtx.globalAlpha = 0.12; canvasCtx.lineTo(w - padding, h - padding); canvasCtx.lineTo(padding, h - padding); canvasCtx.closePath(); canvasCtx.fillStyle = color; canvasCtx.fill(); canvasCtx.globalAlpha = 1; }

  canvasCtx.fillStyle = '#6b7280';
  canvasCtx.font = '11px sans-serif';
  labels.forEach((label, i) => {
    const x = padding + (i / (labels.length - 1 || 1)) * (w - 2 * padding);
    canvasCtx.fillText(String(label), x - 12, h - 8);
  });
    }

    function drawBarChart(ctx, labels, data, options) {
  const canvasCtx = fitCanvas(ctx.canvas || ctx);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w = c.clientWidth || 300; const h = c.clientHeight || 200; const padding = 30;
  const max = Math.max.apply(null, data);
  const bw = (w - 2 * padding) / data.length * 0.7;
  const color = typeof options === 'string' ? options : (options && options.color ? options.color : '#10b981');

  if (options && options.title) {
    canvasCtx.fillStyle = '#14532d';
    canvasCtx.font = '600 12px sans-serif';
    canvasCtx.fillText(options.title, padding, 16);
  }

  canvasCtx.fillStyle = '#6b7280';
  canvasCtx.font = '11px sans-serif';
  data.forEach((v, i) => {
    const x = padding + i * ((w - 2 * padding) / data.length) + ((w - 2 * padding) / data.length - bw) / 2;
    const height = (v / max) * (h - 2 * padding);
    canvasCtx.fillStyle = color;
    canvasCtx.fillRect(x, h - padding - height, bw, height);
    canvasCtx.fillText(String(labels[i] || ''), x, h - 8);
  });
    }

    function drawDoughnut(ctx, values, colors, labels, options) {
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w = c.clientWidth || 200; const h = c.clientHeight || 200; const cx = w / 2; const cy = h / 2; const r = Math.min(w, h) / 3;
  const total = values.reduce((a, b) => a + b, 0) || 1; let start = -Math.PI / 2;
  if (options && options.title) {
    canvasCtx.fillStyle = '#14532d';
    canvasCtx.font = '600 12px sans-serif';
    canvasCtx.fillText(options.title, 20, 16);
  }

  values.forEach((v, i) => { const ang = (v / total) * Math.PI * 2; canvasCtx.beginPath(); canvasCtx.moveTo(cx, cy); canvasCtx.fillStyle = colors[i] || '#ccc'; canvasCtx.arc(cx, cy, r, start, start + ang); canvasCtx.lineTo(cx, cy); canvasCtx.fill(); start += ang; });
  // inner cutout
  canvasCtx.beginPath(); canvasCtx.fillStyle = '#fff'; canvasCtx.arc(cx, cy, r * 0.55, 0, Math.PI * 2); canvasCtx.fill();

  canvasCtx.fillStyle = '#4b5563';
  canvasCtx.font = '11px sans-serif';
  const legendX = w - 110;
  const legendY = 26;
  labels.forEach((label, i) => {
    const y = legendY + i * 18;
    canvasCtx.fillStyle = colors[i] || '#ccc';
    canvasCtx.fillRect(legendX, y - 9, 10, 10);
    canvasCtx.fillStyle = '#4b5563';
    canvasCtx.fillText(label, legendX + 16, y);
  });
    }

    function drawScatter(ctx, values) {
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w = c.clientWidth || 300; const h = c.clientHeight || 200; const padding = 30;
  const max = Math.max.apply(null, values);
  values.forEach((v, i) => { const x = padding + (i / (values.length - 1 || 1)) * (w - 2 * padding); const y = padding + (1 - (v / max)) * (h - 2 * padding); canvasCtx.fillStyle = '#f59e0b'; canvasCtx.beginPath(); canvasCtx.arc(x, y, 4, 0, Math.PI * 2); canvasCtx.fill(); });
    }

    function afficherObjectif(){
      const obj= document.getElementById("objectif-enable");
      const objectif = obj.dataset.objectif; 
    
      console.log(objectif);
    }