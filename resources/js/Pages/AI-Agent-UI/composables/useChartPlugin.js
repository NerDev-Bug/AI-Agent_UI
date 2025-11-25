/**
 * Chart.js plugin for creating gradients and data labels
 * @returns {Object} Chart.js plugin
 */
export function createChartPlugin() {
    return {
        id: 'modernChart',
        beforeDraw(chart) {
            // Create gradients for bar charts (both vertical and horizontal)
            if (chart.config.type === 'bar') {
                const { ctx, chartArea } = chart;
                if (!chartArea) return;

                const isHorizontal = chart.config.options.indexAxis === 'y';

                chart.data.datasets.forEach((dataset, datasetIndex) => {
                    // Check if we have per-bar gradients (based on x-axis labels)
                    if (dataset._barGradients && Array.isArray(dataset._barGradients)) {
                        // Create a different gradient for each bar based on label
                        const gradients = dataset._barGradients.map((barGradient) => {
                            let gradient;
                            if (isHorizontal) {
                                // Horizontal bars: gradient from left to right
                                gradient = ctx.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
                            } else {
                                // Vertical bars: gradient from bottom to top
                                gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            }
                            gradient.addColorStop(0, barGradient.end);
                            gradient.addColorStop(1, barGradient.start);
                            return gradient;
                        });
                        
                        // Apply gradients to bars
                        dataset.backgroundColor = gradients;
                    } else if (dataset._gradientStart && dataset._gradientEnd) {
                        // Fallback: single gradient for entire dataset
                        let gradient;
                        if (isHorizontal) {
                            // Horizontal bars: gradient from left to right
                            gradient = ctx.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
                        } else {
                            // Vertical bars: gradient from bottom to top
                            gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        }
                        gradient.addColorStop(0, dataset._gradientEnd);
                        gradient.addColorStop(1, dataset._gradientStart);

                        // Apply gradient to all bars in dataset
                        const dataLength = dataset.data ? dataset.data.length : 0;
                        dataset.backgroundColor = Array(dataLength).fill(gradient);
                    }
                });
            }

            // Create gradients for line chart fills
            if (chart.config.type === 'line') {
                const { ctx, chartArea } = chart;
                if (!chartArea) return;

                chart.data.datasets.forEach((dataset) => {
                    if (dataset._gradientFill && dataset.borderColor) {
                        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        const borderColor = typeof dataset.borderColor === 'string' ? dataset.borderColor : dataset.borderColor[0] || '#3b82f6';
                        gradient.addColorStop(0, borderColor.replace('rgb', 'rgba').replace(')', ', 0.3)'));
                        gradient.addColorStop(1, borderColor.replace('rgb', 'rgba').replace(')', ', 0.05)'));
                        dataset.backgroundColor = gradient;
                    }
                });
            }
        },
        afterDatasetsDraw(chart) {
            const { ctx } = chart;
            ctx.save();

            // Add data labels on top of bars
            if (chart.config.type === 'bar') {
                const isHorizontal = chart.config.options.indexAxis === 'y';
                chart.data.datasets.forEach((dataset, datasetIndex) => {
                    const meta = chart.getDatasetMeta(datasetIndex);
                    meta.data.forEach((bar, index) => {
                        const value = dataset.data[index];
                        if (value !== null && value !== undefined && typeof value === 'number') {
                            // Get label color based on the bar's color
                            let labelColor = '#f97316'; // Default orange fallback
                            
                            if (dataset._barGradients && Array.isArray(dataset._barGradients) && dataset._barGradients[index]) {
                                labelColor = dataset._barGradients[index].end;
                            } else if (dataset._gradientEnd) {
                                labelColor = dataset._gradientEnd;
                            } else if (Array.isArray(dataset.borderColor) && dataset.borderColor[index]) {
                                labelColor = dataset.borderColor[index];
                            } else if (typeof dataset.borderColor === 'string') {
                                labelColor = dataset.borderColor;
                            }

                            // Format value
                            const formattedValue = value % 1 === 0 ? value.toString() : value.toFixed(2);

                            // Position label based on bar orientation
                            let labelX, labelY;
                            if (isHorizontal) {
                                labelX = bar.x + 15;
                                labelY = bar.y;
                            } else {
                                labelX = bar.x;
                                labelY = bar.y - 15;
                            }

                            // Draw circle background with shadow
                            ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
                            ctx.shadowBlur = 6;
                            ctx.shadowOffsetX = 0;
                            ctx.shadowOffsetY = 3;
                            ctx.fillStyle = labelColor;
                            ctx.beginPath();
                            if (isHorizontal) {
                                ctx.arc(labelX, labelY, 16, 0, 2 * Math.PI);
                            } else {
                                ctx.arc(labelX, labelY - 8, 16, 0, 2 * Math.PI);
                            }
                            ctx.fill();

                            // Reset shadow
                            ctx.shadowColor = 'transparent';
                            ctx.shadowBlur = 0;

                            // Draw white border
                            ctx.strokeStyle = '#ffffff';
                            ctx.lineWidth = 3;
                            ctx.stroke();

                            // Draw text
                            ctx.fillStyle = '#ffffff';
                            ctx.font = 'bold 13px Inter, system-ui, sans-serif';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            if (isHorizontal) {
                                ctx.fillText(formattedValue, labelX, labelY);
                            } else {
                                ctx.fillText(formattedValue, labelX, labelY - 8);
                            }
                        }
                    });
                });
            }
            ctx.restore();
        }
    };
}

