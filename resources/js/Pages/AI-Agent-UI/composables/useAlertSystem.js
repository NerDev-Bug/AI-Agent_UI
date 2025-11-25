import { ref } from 'vue';

/**
 * Composable for alert system (success, error, warning)
 * @returns {Object} Alert state and functions
 */
export function useAlertSystem() {
    const alertVisible = ref(false);
    const alertType = ref("success");
    const alertTitle = ref("");
    const alertMessage = ref("");
    const alertIcon = ref("");
    let confirmCallback = null;

    function showAlert(type, title, message, onConfirm = null) {
        alertType.value = type;
        alertTitle.value = title;
        alertMessage.value = message;
        alertVisible.value = true;
        confirmCallback = onConfirm;
        alertIcon.value =
            type === "success" ? "✔️" : type === "error" ? "❌" : "⚠️";
    }

    function closeAlert() {
        alertVisible.value = false;
    }

    function confirmAction() {
        if (confirmCallback) confirmCallback();
        closeAlert();
    }

    return {
        alertVisible,
        alertType,
        alertTitle,
        alertMessage,
        alertIcon,
        showAlert,
        closeAlert,
        confirmAction
    };
}

