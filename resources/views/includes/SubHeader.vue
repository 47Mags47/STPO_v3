```vue
<script>
import Appeal from "./Appeal.vue";

export default {
    components: {
        Appeal,
    },

    props: {
        classWrapper: {
            type: [String, Function, Object],
            default: ''
        }
    },

    data() {
        return {
            scrollTop: 0,
        };
    },


    methods: {

    },

    computed: {
        classValue() {
            if(typeof this.classWrapper === 'string')
                return this.classWrapper

            if(typeof this.classWrapper === 'object')
                return this.classWrapper

            if(typeof this.classWrapper === 'function') {
                const funcClassResult = this.classWrapper()
                if (typeof funcClassResult === 'string')
                    return funcClassResult

                console.warn('Значение функции должно быть типа string')
            }
        }
    },
};
</script>

<template>
    <div
        class="sub-header transition-all"
        :class="classValue"
    >
        <div class="sub-header-content">
            <Appeal />
        </div>
    </div>
</template>

<style lang="sass" scoped>
.sub-header
    top: 60px
    left: 0

    width: 100%
    height: 40px
    overflow: hidden
    z-index: 10

.sub-header-content
    width: 100%
    height: 100%

    padding: 0 15px
    display: flex
    justify-content: flex-end

    background: var(--sub-header-background-color)
</style>

