<script>
export default {
    props: {
        label: {
            type: String,
            default: "",
        },
        for: {
            type: String,
            default: "",
        },
        orientation: {
            type: String,
            default: "vertical",
            validator(value) {
                return [
                    "horizontal",
                    "vertical",
                    "vertical-reverse",
                    "horizontal-reverse",
                ].includes(value);
            },
        },
    },
    slots: ["default"],
};
</script>

<template>
    <div class="form-item-container" :data-orientation="orientation">
        <label :for>{{ label }}</label>
        <slot name="default" />
    </div>
</template>

<style lang="sass" scoped>
.form-item-container
    label
        padding-left: 7px
        color: #333
        font-weight: bold

    &[data-orientation="vertical"]
        display: flex
        flex-direction: column
        gap: 5px

    &[data-orientation="horizontal"]
        height: $input-height
        display: flex
        justify-content: flex-end
        align-items: center
        flex-direction: row
        label
            width: 100%
    &[data-orientation="vertical-reverse"]
        display: flex
        flex-direction: column-reverse
        gap: 5px

    &[data-orientation="horizontal-reverse"]
        height: $input-height
        display: flex
        justify-content: flex-end
        align-items: center
        flex-direction: row-reverse
        label
            width: 100%
</style>
