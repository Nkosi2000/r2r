/**
 * Parametric line-art figures, one per programme pillar.
 * Each returns a list of [x, y] points in a -1..1 space.
 */
const figures = {
    /* Eight-petal rose with a hollow centre */
    bloom: () =>
        sample(720, Math.PI * 2, (t) => {
            const radius = 0.18 + 0.82 * Math.abs(Math.cos(4 * t));

            return [radius * Math.cos(t), radius * Math.sin(t)];
        }),

    /* Four interlocking orbits */
    orbit: () =>
        [0, 1, 2, 3].flatMap((index) => {
            const angle = (index * Math.PI) / 4;

            return [
                ...sample(180, Math.PI * 2, (t) => {
                    const x = Math.cos(t);
                    const y = 0.32 * Math.sin(t);

                    return [x * Math.cos(angle) - y * Math.sin(angle), x * Math.sin(angle) + y * Math.cos(angle)];
                }),
                null,
            ];
        }),

    /* Dense spirograph starburst */
    burst: () =>
        sample(2400, Math.PI * 2 * 11, (t) => {
            const outer = 1;
            const inner = 0.31;
            const pen = 0.62;
            const x = (outer - inner) * Math.cos(t) + pen * Math.cos(((outer - inner) / inner) * t);
            const y = (outer - inner) * Math.sin(t) - pen * Math.sin(((outer - inner) / inner) * t);

            return [x / 1.31, y / 1.31];
        }),

    /* Concentric rings joined by spokes, like a growing seed */
    seed: () => [
        ...[0.25, 0.5, 0.75, 1].flatMap((radius) => [...sample(160, Math.PI * 2, (t) => [radius * Math.cos(t), radius * Math.sin(t)]), null]),
        ...Array.from({ length: 12 }, (_, index) => {
            const angle = (index * Math.PI) / 6;

            return [[0.25 * Math.cos(angle), 0.25 * Math.sin(angle)], [Math.cos(angle), Math.sin(angle)], null];
        }).flat(),
    ],
};

function sample(steps, span, fn) {
    return Array.from({ length: steps + 1 }, (_, index) => fn((index / steps) * span));
}

function toPath(points) {
    let path = '';
    let isNewSegment = true;

    for (const point of points) {
        if (point === null) {
            isNewSegment = true;
            continue;
        }

        path += `${isNewSegment ? 'M' : 'L'}${(point[0] * 48 + 50).toFixed(2)} ${(point[1] * 48 + 50).toFixed(2)}`;
        isNewSegment = false;
    }

    return path;
}

/**
 * Fill every <svg data-rosette="bloom"> with its figure.
 */
export function drawRosettes() {
    document.querySelectorAll('svg[data-rosette]').forEach((svg) => {
        const figure = figures[svg.dataset.rosette];

        if (!figure) {
            return;
        }

        svg.setAttribute('viewBox', '0 0 100 100');
        svg.innerHTML = `<path d="${toPath(figure())}" pathLength="1" fill="none" stroke="currentColor" stroke-width="0.6" />`;
    });
}
