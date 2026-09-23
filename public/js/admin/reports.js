(() => {
    const root = document.querySelector('[data-report-chart]');
    if (!root) return;
    const $ = (s, c = root) => c.querySelector(s);
    const $$ = (s, c = root) => [...c.querySelectorAll(s)];
    const data = JSON.parse(root.dataset.reportChart);
    const plot = $('[data-chart-plot]'), labels = $('[data-chart-labels]');
    const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');

    const smooth = (pts) => {
        let d = `M${pts[0][0]},${pts[0][1]}`;
        for (let i = 0; i < pts.length - 1; i++) {
            const p0 = pts[i - 1] || pts[i], p1 = pts[i], p2 = pts[i + 1], p3 = pts[i + 2] || p2;
            d += ` C${p1[0] + (p2[0] - p0[0]) / 6},${p1[1] + (p2[1] - p0[1]) / 6} ${p2[0] - (p3[0] - p1[0]) / 6},${p2[1] - (p3[1] - p1[1]) / 6} ${p2[0]},${p2[1]}`;
        }
        return d;
    };

    function render() {
        const n = data.label.length;
        const max = Math.max(...data.omzet);
        const toXY = (arr) => arr.map((v, i) => [((i + 0.5) / n) * 100, 96 - (v / (max * 1.12)) * 88]);
        const omzetXY = toXY(data.omzet), labaXY = toXY(data.laba);
        const peak = data.omzet.indexOf(max);
        const area = `${smooth(omzetXY)} L${omzetXY[n - 1][0]},100 L${omzetXY[0][0]},100 Z`;

        plot.innerHTML =
            `<svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <defs><linearGradient id="reportFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#1D4ED8" stop-opacity=".16"/><stop offset="1" stop-color="#1D4ED8" stop-opacity="0"/>
                </linearGradient></defs>
                <path d="${area}" fill="url(#reportFill)"/>
                <path d="${smooth(omzetXY)}" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
                <path d="${smooth(labaXY)}" fill="none" stroke="#12B76A" stroke-width="2.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
            </svg>` +
            omzetXY.map(([x, y], i) => `<button type="button" class="chart__dot" data-i="${i}" style="left:${x}%;top:${y}%" aria-label="${data.label[i]}: ${rupiah(data.omzet[i])}"></button>`).join('') +
            '<div class="chart__tip" data-tip></div>';

        labels.style.setProperty('--n', n);
        labels.innerHTML = data.label.map((l, i) => `<span class="${i === peak ? 'is-peak' : ''}">${l}</span>`).join('');

        const tip = $('[data-tip]', plot), dots = $$('.chart__dot', plot);
        const show = (i) => {
            const [x, y] = omzetXY[i];
            dots.forEach((d, j) => d.classList.toggle('is-active', j === i));
            tip.style.left = x + '%';
            tip.style.top = y + '%';
            tip.style.transform = x > 70 ? 'translate(-88%,-135%)' : x < 30 ? 'translate(-12%,-135%)' : 'translate(-50%,-135%)';
            tip.innerHTML = `<small>${i === peak ? 'Puncak: ' : ''}${data.label[i]}</small><strong>${rupiah(data.omzet[i])}</strong>`;
        };
        dots.forEach((d) => {
            d.addEventListener('mouseenter', () => show(+d.dataset.i));
            d.addEventListener('focus', () => show(+d.dataset.i));
            d.addEventListener('mouseleave', () => show(peak));
            d.addEventListener('blur', () => show(peak));
        });
        show(peak);
    }
    render();

    document.querySelector('[data-print]')?.addEventListener('click', () => window.print());
})();