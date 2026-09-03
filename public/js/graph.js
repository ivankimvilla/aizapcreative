document.addEventListener('DOMContentLoaded', function () {
    var chart = document.querySelector('.chart-svg-wrap svg');
    if (!chart) return;

    var chartW = 720;
    var chartH = 280;
    var padL = 40;
    var padR = 20;
    var padT = 20;
    var padB = 40;
    var plotW = chartW - padL - padR;
    var plotH = chartH - padT - padB;
    var endpoint = chart.dataset.trafficEndpoint;

    function smoothPath(points) {
        if (points.length < 2) return points.length ? 'M' + points[0].x + ',' + points[0].y : '';
        var path = 'M' + points[0].x + ',' + points[0].y + ' ';
        for (var i = 0; i < points.length - 1; i++) {
            var p0 = points[i - 1] || points[i];
            var p1 = points[i];
            var p2 = points[i + 1];
            var p3 = points[i + 2] || p2;
            path += 'C' + (p1.x + (p2.x - p0.x) / 6) + ',' + (p1.y + (p2.y - p0.y) / 6) + ' ';
            path += (p2.x - (p3.x - p1.x) / 6) + ',' + (p2.y - (p3.y - p1.y) / 6) + ' ' + p2.x + ',' + p2.y + ' ';
        }
        return path.trim();
    }

    function renderTraffic(data) {
        var count = Math.max(1, data.points.length - 1);
        var points = data.points.map(function (point, index) {
            return {
                x: padL + (index / count) * plotW,
                y: padT + plotH - (point.count / data.chartMax) * plotH,
                date: point.date
            };
        });
        var linePath = smoothPath(points);
        var areaPath = linePath;
        if (points.length) areaPath += ' L' + points[points.length - 1].x + ',' + (padT + plotH) + ' L' + points[0].x + ',' + (padT + plotH) + ' Z';

        document.getElementById('chartLine').setAttribute('d', linePath);
        document.getElementById('chartArea').setAttribute('d', areaPath);

        var dots = document.getElementById('chartDots');
        dots.replaceChildren.apply(dots, points.map(function (point) {
            var dot = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            dot.setAttribute('class', 'chart-dot');
            dot.setAttribute('cx', point.x);
            dot.setAttribute('cy', point.y);
            dot.setAttribute('r', '3.5');
            return dot;
        }));

        var axisLabels = document.querySelectorAll('#chartAxisLabels text');
        [data.chartMax, Math.round(data.chartMax * .66), Math.round(data.chartMax * .33), 0].forEach(function (value, index) {
            axisLabels[index].textContent = value.toLocaleString();
        });

        var xLabels = document.getElementById('chartXLabels');
        xLabels.replaceChildren.apply(xLabels, points.filter(function (_, index) {
            return index % Math.max(1, Math.floor(points.length / 8)) === 0;
        }).map(function (point) {
            var label = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            label.setAttribute('x', point.x);
            label.setAttribute('y', chartH - 12);
            label.setAttribute('text-anchor', 'middle');
            label.textContent = new Date(point.date + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            return label;
        }));

        if (data.stats) {
            Object.keys(data.stats).forEach(function (key) {
                var stat = data.stats[key];
                var value = document.querySelector('[data-stat-value="' + key + '"]');
                var trend = document.querySelector('[data-stat-trend="' + key + '"]');

                if (value) value.textContent = Number(stat.value).toLocaleString();
                if (trend) trend.textContent = stat.trend;
            });
        }
    }

    function refreshTraffic() {
        fetch(endpoint, { headers: { Accept: 'application/json' } })
            .then(function (response) { return response.ok ? response.json() : Promise.reject(response); })
            .then(renderTraffic)
            .catch(function () { });
    }

    refreshTraffic();
    window.setInterval(refreshTraffic, 30000);
});
