import { ref } from 'vue';

/**
 * Composable for PDF export functionality
 * @param {Ref} currentReport - Current report ref
 * @param {Ref} chartMap - Chart map ref
 * @param {Ref} isExporting - Exporting state ref
 * @param {Function} showAlert - Alert function
 * @returns {Object} Export functions and state
 */
export function usePDFExport(currentReport, chartMap, isExporting, showAlert) {
    const exportToPDF = async () => {
        if (!currentReport.value) {
            showAlert(
                "error",
                "Export Failed",
                "No report data available to export."
            );
            return;
        }

        isExporting.value = true;
        try {
            const chartImages = [];
            const chartsData = chartMap.value[currentReport.value.form_id] || [];
            const canvases = document.querySelectorAll("canvas");

            const targetWidth = 1200;
            const targetHeight = 700;
            const exportScale = 2.5;

            canvases.forEach((canvas, index) => {
                const tmpCanvas = document.createElement("canvas");
                tmpCanvas.width = targetWidth * exportScale;
                tmpCanvas.height = targetHeight * exportScale;
                const ctx = tmpCanvas.getContext("2d");
                ctx.fillStyle = "#fff";
                ctx.fillRect(0, 0, tmpCanvas.width, tmpCanvas.height);
                ctx.drawImage(canvas, 0, 0, tmpCanvas.width, tmpCanvas.height);

                chartImages.push({
                    title: chartsData[index]?.title || `Chart ${index + 1}`,
                    description: chartsData[index]?.description || "",
                    data: tmpCanvas.toDataURL("image/png"),
                });
            });

            const payload = { report: currentReport.value, charts: chartImages };
            const csrf = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            const response = await fetch("/export-report-pdf", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                    Accept: "application/pdf",
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    const errorData = await response.json();
                    throw new Error(
                        errorData.error ||
                        errorData.message ||
                        "Failed to export PDF"
                    );
                }
                throw new Error(
                    `Failed to export PDF: ${response.status} ${response.statusText}`
                );
            }

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;
            link.download = `Report-${new Date().toISOString().slice(0, 10)}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            setTimeout(() => URL.revokeObjectURL(url), 1000);
            showAlert(
                "success",
                "Export Successful",
                "Analyze Report was successfully exported to PDF!"
            );
        } catch (error) {
            console.error("PDF Export Error:", error);
            showAlert(
                "error",
                "Error exporting PDF: " + (error.message || "Please try again.")
            );
        } finally {
            isExporting.value = false;
        }
    };

    const handleExportClick = () => {
        if (!currentReport.value) {
            showAlert(
                "warning",
                "⚠️ Please select a valid report before exporting to PDF."
            );
            return;
        }
        exportToPDF();
    };

    return {
        exportToPDF,
        handleExportClick
    };
}

