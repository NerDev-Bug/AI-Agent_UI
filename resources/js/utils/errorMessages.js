/**
 * Error Message Utility
 * Converts technical error messages to user-friendly messages
 */

/**
 * Maps technical error patterns to user-friendly messages
 */
const ERROR_PATTERNS = [
    // File-related errors
    {
        pattern: /invalid file|file format|unsupported file|file type/i,
        message: "The file format is not supported. Please upload a PDF, JPG, JPEG, or PNG file."
    },
    {
        pattern: /file too large|file size|exceeds|maximum size/i,
        message: "The file is too large. Please upload a file smaller than 50MB."
    },
    {
        pattern: /file not found|file missing|no file|file empty/i,
        message: "No file was uploaded. Please select a file and try again."
    },
    {
        pattern: /corrupted|invalid pdf|damaged file/i,
        message: "The file appears to be corrupted or damaged. Please try a different file."
    },
    
    // Processing errors
    {
        pattern: /timeout|timed out|took too long/i,
        message: "The processing took too long. Please try again with a smaller file or check your internet connection."
    },
    {
        pattern: /processing failed|failed to process|error processing/i,
        message: "We encountered an issue while processing your file. Please try again."
    },
    {
        pattern: /extraction failed|failed to extract|could not extract/i,
        message: "We couldn't extract content from your file. Please ensure the file contains readable text."
    },
    {
        pattern: /analysis failed|failed to analyze|could not analyze/i,
        message: "We couldn't analyze your file. Please check if the file contains valid data."
    },
    
    // Network/API errors
    {
        pattern: /network|connection|fetch|request failed/i,
        message: "Connection error. Please check your internet connection and try again."
    },
    {
        pattern: /server error|500|internal error|service unavailable/i,
        message: "Our servers are experiencing issues. Please try again in a few moments."
    },
    {
        pattern: /not found|404|job not found|expired/i,
        message: "The processing job was not found or has expired. Please start a new analysis."
    },
    {
        pattern: /unauthorized|401|403|permission|api key/i,
        message: "Authentication error. Please refresh the page and try again."
    },
    
    // Content validation errors
    {
        pattern: /no text|empty content|no content|blank/i,
        message: "The file appears to be empty or contains no readable text. Please upload a file with content."
    },
    {
        pattern: /invalid content|content validation|validation failed/i,
        message: "The file content couldn't be validated. Please ensure the file contains valid agricultural data."
    },
    {
        pattern: /insufficient data|not enough data|data missing/i,
        message: "The file doesn't contain enough data for analysis. Please upload a complete file."
    },
    
    // JSON/parsing errors
    {
        pattern: /json|parse|invalid json|syntax error/i,
        message: "There was an issue processing the response. Please try again."
    },
    {
        pattern: /escape|invalid escape|malformed/i,
        message: "There was an issue with the file format. Please try a different file."
    },
    
    // Langfuse/monitoring errors (should not be shown to users)
    {
        pattern: /langfuse|trace|monitoring|observability/i,
        message: "Processing completed, but there was an issue with logging. Your results should still be available."
    },
    
    // Generic errors
    {
        pattern: /exception|error occurred|unexpected error/i,
        message: "An unexpected error occurred. Please try again or contact support if the problem persists."
    }
];

/**
 * Converts a technical error message to a user-friendly message
 * @param {string|object} error - The error message or error object
 * @returns {string} User-friendly error message
 */
export function getUserFriendlyError(error) {
    if (!error) {
        return "An error occurred. Please try again.";
    }
    
    // Extract message from error object
    let errorMessage = "";
    if (typeof error === "string") {
        errorMessage = error;
    } else if (typeof error === "object") {
        errorMessage = error.message || error.error || error.detail || JSON.stringify(error);
    } else {
        errorMessage = String(error);
    }
    
    // Check if error message is already user-friendly (short and simple)
    if (errorMessage.length < 100 && !errorMessage.includes("Exception") && !errorMessage.includes("Error:")) {
        // Check if it matches any technical pattern
        const isTechnical = ERROR_PATTERNS.some(pattern => pattern.pattern.test(errorMessage));
        if (!isTechnical) {
            // Likely already user-friendly
            return errorMessage;
        }
    }
    
    // Try to match error patterns
    for (const errorPattern of ERROR_PATTERNS) {
        if (errorPattern.pattern.test(errorMessage)) {
            return errorPattern.message;
        }
    }
    
    // If no pattern matches, return a generic friendly message
    // But include a hint if it's a known error type
    if (errorMessage.length > 200) {
        // Very long error messages are likely technical
        return "We encountered an issue processing your file. Please try again or contact support if the problem persists.";
    }
    
    // For shorter errors, try to clean them up
    let cleaned = errorMessage
        .replace(/^Error:\s*/i, "")
        .replace(/^Exception:\s*/i, "")
        .replace(/Traceback.*$/s, "")
        .replace(/File.*line.*$/gm, "")
        .trim();
    
    // If cleaned message is still technical, use generic
    if (cleaned.includes(":") && cleaned.split(":").length > 2) {
        return "We encountered an issue processing your file. Please try again.";
    }
    
    // Return cleaned message if it's reasonable
    return cleaned || "An error occurred. Please try again.";
}

/**
 * Gets a user-friendly error title based on error type
 * @param {string|object} error - The error message or error object
 * @returns {string} User-friendly error title
 */
export function getUserFriendlyErrorTitle(error) {
    if (!error) {
        return "Error";
    }
    
    let errorMessage = "";
    if (typeof error === "string") {
        errorMessage = error;
    } else if (typeof error === "object") {
        errorMessage = error.message || error.error || error.detail || "";
    } else {
        errorMessage = String(error);
    }
    
    // Determine title based on error type
    if (/file|upload|format/i.test(errorMessage)) {
        return "File Upload Error";
    } else if (/processing|analysis|extraction/i.test(errorMessage)) {
        return "Processing Error";
    } else if (/network|connection|timeout/i.test(errorMessage)) {
        return "Connection Error";
    } else if (/not found|404|expired/i.test(errorMessage)) {
        return "Not Found";
    } else if (/unauthorized|permission|401|403/i.test(errorMessage)) {
        return "Authentication Error";
    } else {
        return "Error";
    }
}

/**
 * Checks if an error should be logged for debugging (technical errors)
 * @param {string|object} error - The error message or error object
 * @returns {boolean} True if error should be logged
 */
export function shouldLogError(error) {
    // Always log errors for debugging, but show user-friendly message
    return true;
}

