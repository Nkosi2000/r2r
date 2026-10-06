import { CanvasSurface } from './canvas-surface';

/**
 * Simplified outline of South Africa as [longitude, latitude] pairs,
 * with Lesotho cut out. Accurate enough for a stylised dot map.
 */
const SOUTH_AFRICA = [
    [16.45, -28.63], [17.4, -28.7], [18.2, -28.9], [19.0, -28.9], [20.0, -28.4], [20.0, -24.8],
    [20.7, -25.9], [20.8, -26.8], [22.0, -26.0], [23.0, -25.4], [24.0, -25.7], [25.5, -25.7],
    [25.9, -24.7], [26.9, -24.6], [27.5, -23.8], [28.0, -22.6], [29.0, -22.2], [30.0, -22.3],
    [31.3, -22.4], [32.0, -24.5], [31.97, -25.95], [31.0, -25.7], [30.8, -26.4], [31.1, -27.2],
    [32.1, -26.85], [32.9, -26.85], [32.6, -27.6], [32.4, -28.6], [31.4, -29.4], [30.9, -29.9],
    [30.3, -30.9], [29.9, -31.4], [28.8, -32.2], [27.9, -33.0], [26.5, -33.75], [25.6, -34.0],
    [25.0, -33.98], [24.0, -34.1], [22.5, -34.0], [21.0, -34.4], [20.0, -34.83], [19.3, -34.6],
    [18.8, -34.4], [18.4, -34.3], [18.4, -33.9], [18.0, -33.0], [18.2, -32.3], [17.9, -31.5],
    [17.3, -30.3], [16.9, -29.4],
];

const LESOTHO = [
    [27.0, -29.6], [27.5, -28.9], [28.3, -28.6], [29.2, -29.0], [29.4, -29.8], [28.8, -30.4],
    [28.0, -30.6], [27.4, -30.2],
];

export const MAP_BOUNDS = { west: 16.3, east: 33.0, north: -22.0, south: -35.0 };

/**
 * Convert a coordinate into 0–1 positions within the map frame.
 */
export function project(longitude, latitude) {
    return {
        x: (longitude - MAP_BOUNDS.west) / (MAP_BOUNDS.east - MAP_BOUNDS.west),
        y: (MAP_BOUNDS.north - latitude) / (MAP_BOUNDS.north - MAP_BOUNDS.south),
    };
}

const isInside = (point, polygon) => {
    let inside = false;

    for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
        const [xi, yi] = polygon[i];
        const [xj, yj] = polygon[j];

        if (yi > point[1] !== yj > point[1] && point[0] < ((xj - xi) * (point[1] - yi)) / (yj - yi) + xi) {
            inside = !inside;
        }
    }

    return inside;
};

/**
 * Dot-matrix map of South Africa with glowing routes between R2R stops.
 * Nodes are read from [data-map-node] siblings (data-lon / data-lat).
 */
export class DotMap extends CanvasSurface {
    constructor(canvas) {
        super(canvas);
        this.nodes = [...canvas.parentElement.querySelectorAll('[data-map-node]')].map((element) => {
            const position = project(Number(element.dataset.lon), Number(element.dataset.lat));
            element.style.left = `${position.x * 100}%`;
            element.style.top = `${position.y * 100}%`;

            return { id: element.dataset.mapNode, ...position };
        });
        this.routes = (canvas.dataset.routes ?? '')
            .split(' ')
            .filter(Boolean)
            .map((pair) => pair.split('-').map((id) => this.nodes.find((node) => node.id === id)))
            .filter(([from, to]) => from && to);
    }

    onResize() {
        const gap = Math.max(5, this.width / 110);
        this.dots = [];

        for (let y = gap / 2; y < this.height; y += gap) {
            for (let x = gap / 2; x < this.width; x += gap) {
                const longitude = MAP_BOUNDS.west + (x / this.width) * (MAP_BOUNDS.east - MAP_BOUNDS.west);
                const latitude = MAP_BOUNDS.north - (y / this.height) * (MAP_BOUNDS.north - MAP_BOUNDS.south);

                if (isInside([longitude, latitude], SOUTH_AFRICA) && !isInside([longitude, latitude], LESOTHO)) {
                    const nearest = Math.min(...this.nodes.map((node) => Math.hypot(node.x * this.width - x, node.y * this.height - y)));
                    this.dots.push({ x, y, seed: Math.random(), glow: Math.max(0, 1 - nearest / 70) });
                }
            }
        }

        this.dotSize = gap * 0.42;
    }

    draw(elapsed) {
        const { ctx, width, height } = this;
        const time = elapsed * 0.001;
        const reveal = this.reducedMotion ? 1 : Math.min(1, elapsed / 1600);

        ctx.clearRect(0, 0, width, height);

        ctx.fillStyle = '#ffffff';

        for (const dot of this.dots ?? []) {
            if (dot.seed > reveal) {
                continue;
            }

            ctx.globalAlpha = 0.16 + dot.glow * 0.5 + 0.06 * Math.sin(time * 1.5 + dot.seed * 12);
            ctx.fillRect(dot.x - this.dotSize / 2, dot.y - this.dotSize / 2, this.dotSize, this.dotSize);
        }

        ctx.globalAlpha = 0.55;
        ctx.strokeStyle = '#a6d77a';
        ctx.lineWidth = 1;

        this.routes.forEach(([from, to], index) => {
            const drawn = Math.min(1, Math.max(0, reveal * 1.6 - index * 0.12));
            const fromX = from.x * width;
            const fromY = from.y * height;
            const toX = fromX + (to.x * width - fromX) * drawn;
            const toY = fromY + (to.y * height - fromY) * drawn;

            ctx.beginPath();
            ctx.moveTo(fromX, fromY);
            ctx.lineTo(toX, toY);
            ctx.stroke();

            if (drawn === 1) {
                const travel = (time * 0.35 + index * 0.27) % 1;
                ctx.save();
                ctx.globalAlpha = 1;
                ctx.fillStyle = '#7dbf45';
                ctx.shadowColor = '#7dbf45';
                ctx.shadowBlur = 10;
                ctx.beginPath();
                ctx.arc(fromX + (to.x * width - fromX) * travel, fromY + (to.y * height - fromY) * travel, 2.4, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        });

        ctx.globalAlpha = 1;

        return true;
    }
}
