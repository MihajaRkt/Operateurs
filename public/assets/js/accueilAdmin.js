document.addEventListener('DOMContentLoaded', function () {
    const users = window.__users || [];

    // Graphique distribution par genre
    const genders = {M: 0, F: 0};
    users.forEach(u => { if (u && u.genre) genders[u.genre] = (genders[u.genre] || 0) + 1; });

    const genderCtx = document.getElementById('genderChart') && document.getElementById('genderChart').getContext('2d');
    if (genderCtx && typeof Chart !== 'undefined') {
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['👨 Hommes', '👩 Femmes'],
                datasets: [{
                    data: [genders.M || 0, genders.F || 0],
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: '#999', padding: 20 } } } }
        });
    }

    // Graphique distribution du poids
    const weights = users.map(u => Number(u.poids) || 0).filter(Boolean).sort((a,b) => a-b);
    const weightRanges = ['<60kg', '60-70kg', '70-80kg', '80-90kg', '>90kg'];
    const weightCounts = [
        weights.filter(w => w < 60).length,
        weights.filter(w => w >= 60 && w < 70).length,
        weights.filter(w => w >= 70 && w < 80).length,
        weights.filter(w => w >= 80 && w < 90).length,
        weights.filter(w => w >= 90).length
    ];

    const weightCtx = document.getElementById('weightDistributionChart') && document.getElementById('weightDistributionChart').getContext('2d');
    if (weightCtx && typeof Chart !== 'undefined') {
        new Chart(weightCtx, {
            type: 'bar',
            data: { labels: weightRanges, datasets: [{ label: "Nombre d'utilisateurs", data: weightCounts, backgroundColor: '#10b981', borderRadius: 8, borderColor: '#10b981', borderWidth: 2 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { color: '#999' }, grid: { color: '#e0e0e0' } }, x: { ticks: { color: '#999' }, grid: { display: false } } } }
        });
    }

    // Graphique distribution de la taille
    const heights = users.map(u => Number(u.taille) || 0).filter(Boolean).sort((a,b) => a-b);
    const heightRanges = ['<150cm', '150-160cm', '160-170cm', '170-180cm', '>180cm'];
    const heightCounts = [
        heights.filter(h => h < 150).length,
        heights.filter(h => h >= 150 && h < 160).length,
        heights.filter(h => h >= 160 && h < 170).length,
        heights.filter(h => h >= 170 && h < 180).length,
        heights.filter(h => h >= 180).length
    ];

    const heightCtx = document.getElementById('heightDistributionChart') && document.getElementById('heightDistributionChart').getContext('2d');
    if (heightCtx && typeof Chart !== 'undefined') {
        new Chart(heightCtx, {
            type: 'bar',
            data: { labels: heightRanges, datasets: [{ label: "Nombre d'utilisateurs", data: heightCounts, backgroundColor: '#6366f1', borderRadius: 8, borderColor: '#6366f1', borderWidth: 2 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { color: '#999' }, grid: { color: '#e0e0e0' } }, x: { ticks: { color: '#999' }, grid: { display: false } } } }
        });
    }

    // Graphique IMC
    const imcData = users.map(u => ({ nom: u.nom, imc: (Number(u.poids) || 0) / (((Number(u.taille) || 0) / 100) ** 2) }));
    const imcCtx = document.getElementById('imcChart') && document.getElementById('imcChart').getContext('2d');
    if (imcCtx && typeof Chart !== 'undefined') {
        new Chart(imcCtx, {
            type: 'scatter',
            data: { datasets: [{ label: 'IMC des utilisateurs', data: imcData.map((d, i) => ({x: i+1, y: d.imc || 0})), backgroundColor: '#f59e0b', borderColor: '#f59e0b', pointRadius: 5, pointHoverRadius: 7 }] },
            options: { responsive: true, plugins: { legend: { labels: { color: '#999' } } }, scales: { y: { beginAtZero: true, max: 35, ticks: { color: '#999' }, grid: { color: '#e0e0e0' } }, x: { ticks: { color: '#999' }, grid: { color: '#e0e0e0' } } } }
        });
    }
});
