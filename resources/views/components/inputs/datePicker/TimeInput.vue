<script setup>
import { ref, computed, watch, nextTick } from "vue";
import Label from "../../Label.vue";

const props = defineProps({
    modelValue: [String, null],
    mode: { type: String, default: "time" },
    label: String,
    disabled: Boolean,
});

const emit = defineEmits(["update:modelValue", "focus"]);

const inputRef = ref(null);
const digits = ref(["0", "0", "0", "0"]);
const placeholderText = computed(() => "чч:мм");
const visibleLength = computed(() => 5);

function isSeparatorAt(pos) {
    return pos === 2;
}
function caretPosToDigitIndex(pos) {
    if (pos <= 1) return pos;
    if (pos === 2) return 1;
    return pos - 1;
}
function indexToCaretPos(idx, after = false) {
    if (idx < 2) return after ? idx + 1 : idx;
    return after ? idx + 2 : idx + 1;
}
function emitUpdated() {
    const h = digits.value.slice(0, 2).join("");
    const m = digits.value.slice(2, 4).join("");
    emit("update:modelValue", `${h}:${m}`);
}
const displayValue = computed(() => {
    const h = digits.value.slice(0, 2).join("");
    const m = digits.value.slice(2, 4).join("");
    return `${h}:${m}`;
});

function onKeyDown(e) {
    if (props.disabled) return;
    const el = inputRef.value;
    if (!el) return;

    if (e.key === "ArrowLeft" || e.key === "ArrowRight") {
        e.preventDefault();
        let pos = el.selectionStart ?? 0;
        const dir = e.key === "ArrowLeft" ? -1 : 1;
        pos += dir;
        if (isSeparatorAt(pos)) pos += dir;
        pos = Math.max(0, Math.min(visibleLength.value, pos));
        nextTick(() => el.setSelectionRange(pos, pos));
        return;
    }

    if (e.key === "Backspace") {
        e.preventDefault();
        let pos = el.selectionStart ?? 0;
        if (isSeparatorAt(pos - 1)) pos--;
        const idx = caretPosToDigitIndex(pos - 1);
        if (idx >= 0) digits.value[idx] = "0";
        emitUpdated();
        const newPos = indexToCaretPos(idx, false);
        nextTick(() => el.setSelectionRange(newPos, newPos));
        return;
    }
    if (/^\d$/.test(e.key)) {
        e.preventDefault();
        const pos = el.selectionStart ?? 0;
        const idx = caretPosToDigitIndex(pos);
        digits.value[idx] = e.key;
        emitUpdated();
        let nextPos = indexToCaretPos(idx, true);
        if (idx === 1) nextPos = 3;
        if (nextPos > visibleLength.value) nextPos = visibleLength.value;

        nextTick(() => el.setSelectionRange(nextPos, nextPos));
        return;
    }

    if (!["Tab", "Home", "End"].includes(e.key)) e.preventDefault();
}

function onBeforeInput(e) {
    if (e.data && !/^\d$/.test(e.data)) e.preventDefault();
}

function onFocus() {
    emit("focus");
    nextTick(() => inputRef.value?.setSelectionRange(0, 0));
}

function onClick() {
    nextTick(() => {
        const el = inputRef.value;
        if (!el) return;
        let pos = el.selectionStart ?? 0;
        if (isSeparatorAt(pos)) pos++;
        el.setSelectionRange(pos, pos);
    });
}

function onBlur() {
    emitUpdated();
}

watch(
    () => props.modelValue,
    (val) => {
        if (!val) {
            digits.value = ["0", "0", "0", "0"];
            return;
        }
        const [h, m] = val.split(":").map(Number);
        digits.value = [
            isNaN(h) ? "0" : Math.floor(h / 10).toString(),
            isNaN(h) ? "0" : (h % 10).toString(),
            isNaN(m) ? "0" : Math.floor(m / 10).toString(),
            isNaN(m) ? "0" : (m % 10).toString(),
        ];
    },
    { immediate: true },
);
</script>

<template>
    <div class="datepicker-input" :class="{ disabled }">
        <Label :labelText="label" />
        <input
            ref="inputRef"
            type="text"
            class="input-text"
            :placeholder="placeholderText"
            :value="displayValue"
            @keydown.prevent="onKeyDown"
            @beforeinput="onBeforeInput"
            @focus="onFocus"
            @click="onClick"
            @blur="onBlur"
            :disabled="disabled"
            autocomplete="off"
            inputmode="numeric"
        />
    </div>
</template>

<style scoped lang="sass">
.datepicker-input
    width: auto
    .input-text
        width: 150px
</style>
