import { EventHub } from "./EventBus";

const notify = {
    success(alert) {
        EventHub.$emit("notify:success", alert);
    },

    error(alert) {
        EventHub.$emit("notify:error", alert);
    }
};

export {notify};