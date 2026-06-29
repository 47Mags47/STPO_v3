<script setup>
import { ref, watch, onMounted } from "vue";

const props = defineProps({ modelValue: String });
const emit = defineEmits(["update:modelValue", "close"]);

const hoursRef = ref(null);
const minutesRef = ref(null);
const tempHour = ref(0);
const tempMinute = ref(0);

const pad = (v) => String(v).padStart(2, "0");

function updateFromModel() {
    const [h, m] = props.modelValue?.split(":").map(Number) || [];
    if (!isNaN(h)) tempHour.value = Math.min(Math.max(h, 0), 23);
    if (!isNaN(m)) tempMinute.value = Math.min(Math.max(m, 0), 59);
    scrollToSelected();
}

watch(
    () => props.modelValue,
    () => updateFromModel(),
);
onMounted(() => updateFromModel());

const selectHour = (h) => {
    tempHour.value = h;
    emit("update:modelValue", `${pad(h)}:${pad(tempMinute.value)}`);
};

const selectMinute = (m) => {
    tempMinute.value = m;
    emit("update:modelValue", `${pad(tempHour.value)}:${pad(m)}`);
    emit("close");
};

function scrollToSelected() {
    const scrollTo = (refEl, idx) => {
        const el = refEl.value?.children[idx];
        if (el) {
            refEl.value.scrollTo({
                top:
                    el.offsetTop -
                    refEl.value.clientHeight / 2 +
                    el.clientHeight / 2,
                behavior: "smooth",
            });
        }
    };
    scrollTo(hoursRef, tempHour.value);
    scrollTo(minutesRef, tempMinute.value);
}
</script>

<template>
    <div class="timepicker-popup">
        <div class="columns">
            <div class="col" ref="hoursRef">
                <div
                    v-for="h in 24"
                    :key="h"
                    class="item"
                    :class="{ selected: tempHour === h - 1 }"
                    @click="selectHour(h - 1)"
                >
                    {{ pad(h - 1) }}
                </div>
            </div>
            <div class="col" ref="minutesRef">
                <div
                    v-for="m in 60"
                    :key="m"
                    class="item"
                    :class="{ selected: tempMinute === m - 1 }"
                    @click="selectMinute(m - 1)"
                >
                    {{ pad(m - 1) }}
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="sass">
.timepicker-popup
  background: #fff
  border: 1px solid #e5e7eb
  border-radius: 10px
  box-shadow: 0 8px 20px rgba(0,0,0,0.15)
  width: 240px
  height: 220px
  display: flex
  padding: 6px

.columns
  display: flex
  flex: 1
  gap: 6px

.col
  flex: 1
  overflow-y: auto
  @include scroll()
  border-right: 1px solid #f3f4f6
  &:last-child
    border-right: none

.item
  text-align: center
  height: 36px
  line-height: 36px
  cursor: pointer
  border-radius: 6px
  font-size: 14px
  font-weight: 500
  transition: 0.15s background, 0.15s color
  &:hover
    background: var(--blue-button-background-color)
    color: white
  &.selected
    background: var(--blue-button-background-color-hover)
    color: white
</style>
