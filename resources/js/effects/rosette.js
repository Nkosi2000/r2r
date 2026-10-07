/**
 * Line-art illustrations, one per programme pillar.
 * Each returns a list of [x, y] points in a -1..1 space (y points down); null starts a new stroke.
 */
const figures = {
    /* Careers: a crossroads signpost pointing down different career paths, topped with a graduation cap */
    signpost: () => [
        ...line([0, 0.9], [0, -0.78]),
        ...line([-0.95, 0.9], [0.95, 0.9]),
        ...line([-0.24, -0.86], [0, -0.97], [0.24, -0.86], [0, -0.75], [-0.24, -0.86]),
        ...line([0.24, -0.86], [0.24, -0.68]),
        ...line([0, -0.66], [0.62, -0.66], [0.78, -0.54], [0.62, -0.42], [0, -0.42]),
        ...line([0, -0.32], [-0.62, -0.32], [-0.78, -0.2], [-0.62, -0.08], [0, -0.08]),
        ...line([0, 0.02], [0.5, 0.02], [0.64, 0.14], [0.5, 0.26], [0, 0.26]),
        ...line([0.12, -0.54], [0.48, -0.54]),
        ...line([-0.12, -0.2], [-0.5, -0.2]),
        ...line([0.12, 0.14], [0.36, 0.14]),
        ...[-0.7, -0.45, 0.4, 0.68].flatMap((x) => line([x - 0.05, 0.9], [x, 0.8], [x + 0.05, 0.9])),
    ],

    /* Skills: two meshing gears with a spark of a new idea */
    gears: () => [
        ...gear(-0.3, 0.25, 0.45, 10, 0.1),
        ...circle(-0.3, 0.25, 0.14),
        ...[0, 1, 2, 3, 4, 5].flatMap((index) => {
            const angle = (index * Math.PI) / 3;

            return line([-0.3 + 0.14 * Math.cos(angle), 0.25 + 0.14 * Math.sin(angle)], [-0.3 + 0.32 * Math.cos(angle), 0.25 + 0.32 * Math.sin(angle)]);
        }),
        ...gear(0.42, -0.38, 0.32, 8, 0.09),
        ...circle(0.42, -0.38, 0.1),
        ...circle(0.42, -0.38, 0.2),
        ...[0, 1, 2, 3, 4, 5, 6, 7].flatMap((index) => {
            const angle = (index * Math.PI) / 4;

            return line([-0.68 + 0.1 * Math.cos(angle), -0.62 + 0.1 * Math.sin(angle)], [-0.68 + (index % 2 ? 0.2 : 0.3) * Math.cos(angle), -0.62 + (index % 2 ? 0.2 : 0.3) * Math.sin(angle)]);
        }),
    ],

    /* Enterprise: a spaza-shop market stall with goods on the counter and a rising growth arrow */
    stall: () => [
        ...line([-0.7, 0.2], [0.7, 0.2], [0.7, 0.9], [-0.7, 0.9], [-0.7, 0.2]),
        ...line([-0.7, 0.45], [0.7, 0.45]),
        ...line([-0.7, 0.2], [-0.7, -0.35]),
        ...line([0.7, 0.2], [0.7, -0.35]),
        ...line([-0.82, -0.35], [-0.6, -0.6], [0.6, -0.6], [0.82, -0.35]),
        ...sample(140, 1.64, (t) => [t - 0.82, -0.35 + 0.1 * Math.abs(Math.sin((t / 1.64) * 7 * Math.PI))]),
        null,
        ...[-2, -1, 0, 1, 2].flatMap((index) => line([index * 0.24, -0.6], [index * 0.33, -0.35])),
        ...[-0.45, -0.25, -0.05].flatMap((x) => circle(x, 0.11, 0.09)),
        ...line([0.18, 0.2], [0.18, -0.02], [0.52, -0.02], [0.52, 0.2]),
        ...line([0.18, 0.09], [0.52, 0.09]),
        ...line([-0.55, -0.72], [-0.22, -0.82], [0.05, -0.74], [0.45, -0.96]),
        ...line([0.28, -0.97], [0.45, -0.96], [0.39, -0.8]),
    ],

    /* Teachers: a chalkboard on an easel with a lesson written on it */
    chalkboard: () => [
        ...line([-0.82, -0.78], [0.82, -0.78], [0.82, 0.36], [-0.82, 0.36], [-0.82, -0.78]),
        ...line([-0.74, -0.7], [0.74, -0.7], [0.74, 0.28], [-0.74, 0.28], [-0.74, -0.7]),
        ...line([-0.86, 0.44], [0.86, 0.44]),
        ...line([-0.55, 0.36], [-0.76, 0.96]),
        ...line([0.55, 0.36], [0.76, 0.96]),
        ...line([0, 0.44], [0, 0.96]),
        ...line([0, -0.78], [0, -0.92]),
        ...sample(120, 0.8, (t) => [t - 0.6, -0.46 + 0.06 * Math.sin(t * 22)]),
        null,
        ...sample(80, 0.5, (t) => [t - 0.6, -0.22 + 0.06 * Math.sin(t * 22)]),
        null,
        ...line([-0.6, 0.04], [0.32, 0.04]),
        ...line([0.3, -0.36], [0.4, -0.24], [0.6, -0.54]),
        ...line([0.4, 0.4], [0.62, 0.4]),
    ],
};

function sample(steps, span, fn) {
    return Array.from({ length: steps + 1 }, (_, index) => fn((index / steps) * span));
}

function line(...points) {
    return [...points, null];
}

function circle(cx, cy, radius) {
    return [...sample(64, Math.PI * 2, (t) => [cx + radius * Math.cos(t), cy + radius * Math.sin(t)]), null];
}

/**
 * A cog outline with flat-topped teeth.
 */
function gear(cx, cy, radius, teeth, depth) {
    return [
        ...sample(teeth * 24, Math.PI * 2, (t) => {
            const toothRadius = radius + (depth / 2) * Math.max(-1, Math.min(1, 3 * Math.sin(teeth * t)));

            return [cx + toothRadius * Math.cos(t), cy + toothRadius * Math.sin(t)];
        }),
        null,
    ];
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
 * Fill every <svg data-rosette="signpost"> with its figure.
 */
export function drawRosettes() {
    document.querySelectorAll('svg[data-rosette]').forEach((svg) => {
        const figure = figures[svg.dataset.rosette];

        if (!figure) {
            return;
        }

        svg.setAttribute('viewBox', '0 0 100 100');
        svg.innerHTML = `<path d="${toPath(figure())}" pathLength="1" fill="none" stroke="currentColor" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" />`;
    });
}
