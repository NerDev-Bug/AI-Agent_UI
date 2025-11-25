/**
 * Chart color utilities
 * Determines colors based on labels (Control = Blue, Leads Agri = Green)
 */

export function getColorForLabel(label) {
    if (!label) return null;
    const labelLower = label.toLowerCase();
    if (labelLower.includes('control') || labelLower.includes('standard') || labelLower.includes('fp/untreated')) {
        return { start: '#3b82f6', end: '#2563eb' }; // Blue
    } else if (labelLower.includes('leads') || labelLower.includes('leadsagri') || labelLower.includes('leads agri')) {
        return { start: '#22c55e', end: '#16a34a' }; // Green
    }
    return null;
}

/**
 * Apply bar chart colors based on x-axis labels or dataset label
 * @param {Object} chartData - Chart data object
 * @param {string} type - Chart type
 */
export function applyBarChartColors(chartData, type) {
    if (!type.includes("bar")) return;

    chartData.datasets.forEach((dataset, datasetIdx) => {
        const xAxisLabels = chartData.labels || [];
        
        // If we have x-axis labels, assign colors per bar based on labels
        if (xAxisLabels.length > 0 && dataset.data && Array.isArray(dataset.data)) {
            const barColors = [];
            const barGradients = [];
            
            xAxisLabels.forEach((label, labelIdx) => {
                const colors = getColorForLabel(label);
                if (colors) {
                    barGradients.push({
                        start: colors.start,
                        end: colors.end,
                        index: labelIdx
                    });
                    barColors.push(colors.end);
                } else {
                    // Fallback: use index-based
                    const fixedPalette = [
                        { start: '#3b82f6', end: '#2563eb' }, // Blue
                        { start: '#22c55e', end: '#16a34a' }, // Green
                    ];
                    const fallbackColors = fixedPalette[labelIdx % 2];
                    barGradients.push({
                        start: fallbackColors.start,
                        end: fallbackColors.end,
                        index: labelIdx
                    });
                    barColors.push(fallbackColors.end);
                }
            });
            
            // Store gradient info per bar
            dataset._barGradients = barGradients;
            dataset.borderColor = barColors;
            dataset.borderWidth = 0;
        } else {
            // Fallback: use dataset label or index
            const datasetLabel = dataset.label || '';
            const colors = getColorForLabel(datasetLabel);
            
            if (colors) {
                dataset._gradientStart = colors.start;
                dataset._gradientEnd = colors.end;
                dataset.borderColor = colors.end;
            } else {
                // Use index-based fallback
                const fixedPalette = [
                    { start: '#3b82f6', end: '#2563eb' }, // Blue
                    { start: '#22c55e', end: '#16a34a' }, // Green
                ];
                const fallbackColors = fixedPalette[datasetIdx % 2];
                dataset._gradientStart = fallbackColors.start;
                dataset._gradientEnd = fallbackColors.end;
                dataset.borderColor = fallbackColors.end;
            }
            dataset.borderWidth = 0;
        }

        // Clear any existing backgroundColor to let plugin handle it
        dataset.backgroundColor = undefined;
    });
}

