<script>
export default {
    props: {
        class: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: null,
        },
        text: {
            type: String,
        },
        type: {
            type: String,
            default: "button",
            validator(value) {
                return ["button", "submit", "reset"].includes(value);
            },
        },
        onClick: {
            type: Function,
        },
    },
    slots: ["default"],
    computed: {
        getClasses() {
            let classes = {
                button: true,
            };

            if (this.color !== null) classes[`${this.color}-button`] = true;

            if (this.class !== null) classes[this.class] = true;

            return classes;
        },
    },
};
</script>

<template>
    <button :class="getClasses" :type="type" @click="onClick">
        <slot />
    </button>
</template>

<style lang="sass" scoped>
.button
    display: flex
    justify-content: center
    align-items: center
    gap: 5px
    width: 100%
    height: 100%
    min-height: $input-height

    border: none
    background: none

    padding: 5px 10px

    border-radius: $default-border-radius

    font-size: 1rem
    font-weight: 600
    color: $button-color

    cursor: pointer

    transition: .5s
</style>
