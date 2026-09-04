<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue";
import TimePickerPopup from "./TimePickerPopup.vue";
import TimeInput from "./TimeInput.vue";

const props = defineProps({
    modelValue: [String, Date, null],
    mode: { type: String, default: "date" },
    disabled: Boolean,
    label: String,
});

const emit = defineEmits(["update:modelValue"]);

const internalValue = ref(props.modelValue);
const showPopup = ref(false);
const wrapperRef = ref(null);

watch(
    () => props.modelValue,
    (v) => (internalValue.value = v),
);

const currentPopup = computed(() =>
    props.mode === "time" ? TimePickerPopup : TimePickerPopup
);

const popupStyles = computed(() => {
    if (!showPopup.value || !wrapperRef.value) return {};
    const rect = wrapperRef.value.getBoundingClientRect();
    return {
        position: "absolute",
        left: `${rect.left}px`,
        top: `${rect.bottom + window.scrollY}px`,
        width: `${rect.width}px`,
        zIndex: 9999,
    };
});

function openPopup() {
    if (!props.disabled) showPopup.value = true;
}
function closePopup() {
    showPopup.value = false;
}
function updateValue(val) {
    internalValue.value = val;
    emit("update:modelValue", val);
}

function handleClickOutside(e) {
    const wrapper = wrapperRef.value;
    const popupEl = document.querySelector(".datetime-popup");
    if (!wrapper || !popupEl) return;
    if (wrapper.contains(e.target) || popupEl.contains(e.target)) return;
    closePopup();
}

onMounted(() => document.addEventListener("mousedown", handleClickOutside));
onBeforeUnmount(() =>
    document.removeEventListener("mousedown", handleClickOutside),
);
</script>

<template>
    <div class="datetime-picker" ref="wrapperRef">
        <TimeInput
            :label="label"
            :modelValue="internalValue"
            :mode="mode"
            :disabled="disabled"
            @update:modelValue="updateValue"
            @focus="openPopup"
        />

        <Teleport to="body">
            <component
                v-if="showPopup"
                :is="currentPopup"
                class="datetime-popup"
                :style="popupStyles"
                :modelValue="internalValue"
                :mode="mode"
                @update:modelValue="updateValue"
                @close="closePopup"
            />
        </Teleport>
    </div>
</template>

<style scoped lang="sass">
.datetime-picker
  position: relative
  display: inline-block

.datetime-popup
  background: white
  border: 1px solid #e5e7eb
  border-radius: 10px
  box-shadow: 0 8px 20px rgba(0,0,0,0.15)
  z-index: 9999
</style>
