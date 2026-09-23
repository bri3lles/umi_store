(() => {
    const root = document.querySelector('[data-chart]');
    if (!root) return;

    const $ = (s, c = root) => c.querySelector(s);
    const $$ = (s, c = root) => [...c.querySelectorAll(s)];
    const data = JSON.parse(root.dataset.chart);
    const plot = $('[data-chart-plot]'), labels = $('[data-chart-labels]');
    const total = $('[data-chart-total]'), growth = $('[data-chart-growth]');

    const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
    const juta = (n) => (n / 1e6).toFixed(1).replace('.', ',') + ' jt';

    // Garis melengkung (Catmull-Rom -> Bezier)
    const smooth = (pts) => {
        let d = `M${pts[0][0]},${pts[0][1]}`;
        for (let i = 0; i < pts.length - 1; i++) {
            const p0 = pts[i - 1] || pts[i], p1 = pts[i], p2 = pts[i + 1], p3 = pts[i + 2] || p2;
            d += ` C${p1[0] + (p2[0] - p0[0]) / 6},${p1[1] + (p2[1] - p0[1]) / 6} ${p2[0] - (p3[0] - p1[0]) / 6},${p2[1] - (p3[1] - p1[1]) / 6} ${p2[0]},${p2[1]}`;
        }
        return d;
    };

    function render(key) {
        const set = data[key], pts = set.points, n = pts.length;
        const max = Math.max(...pts.map((p) => p.v));
        const peak = pts.findIndex((p) => p.v === max);
        const xy = pts.map((p, i) => [((i + 0.5) / n) * 100, 96 - (p.v / (max * 1.12)) * 88]);
        const line = smooth(xy);
        const area = `${line} L${xy[n - 1][0]},100 L${xy[0][0]},100 Z`;

        plot.innerHTML =
            `<svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <defs><linearGradient id="chartFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#002D72" stop-opacity=".18"/><stop offset="1" stop-color="#002D72" stop-opacity="0"/>
                </linearGradient></defs>
                <path d="${area}" fill="url(#chartFill)"/>
                <path d="${line}" fill="none" stroke="#002D72" stroke-width="2.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
            </svg>` +
            xy.map(([x, y], i) => `<button type="button" class="chart__dot" data-i="${i}" style="left:${x}%;top:${y}%" aria-label="${pts[i].l}: ${rupiah(pts[i].v)}"></button>`).join('') +
            '<div class="chart__tip" data-tip></div>';

        labels.style.setProperty('--n', n);
        labels.innerHTML = pts.map((p, i) => `<span class="${i === peak ? 'is-peak' : ''}">${p.l}<small>${juta(p.v)}</small></span>`).join('');
        total.textContent = rupiah(pts.reduce((s, p) => s + p.v, 0));
        growth.textContent = set.growth;

        const tip = $('[data-tip]', plot), dots = $$('.chart__dot', plot);
        const show = (i) => {
            const [x, y] = xy[i];
            dots.forEach((d, j) => d.classList.toggle('is-active', j === i));
            tip.style.left = x + '%';
            tip.style.top = y + '%';
            tip.style.transform = x > 70 ? 'translate(-88%,-135%)' : x < 30 ? 'translate(-12%,-135%)' : 'translate(-50%,-135%)';
            tip.innerHTML = `<small>${i === peak ? 'Puncak: ' : ''}${pts[i].l}</small><strong>${rupiah(pts[i].v)}</strong>`;
        };
        dots.forEach((d) => {
            d.addEventListener('mouseenter', () => show(+d.dataset.i));
            d.addEventListener('focus', () => show(+d.dataset.i));
            d.addEventListener('mouseleave', () => show(peak));
            d.addEventListener('blur', () => show(peak));
        });
        show(peak);
    }

    $$('[data-chart-tab]').forEach((tab) =>
        tab.addEventListener('click', () => {
            $$('[data-chart-tab]').forEach((t) => {
                const on = t === tab;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-selected', String(on));
            });
            render(tab.dataset.chartTab);
        })
    );

    render('week');
})();