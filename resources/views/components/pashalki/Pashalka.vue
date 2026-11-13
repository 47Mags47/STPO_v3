<script>
import Meteor from './Meteor.vue';

export default {
    components: {
        Meteor
    },

    props: {
        type: {
            type: String,
            default: null
        },

        onFinish: {
            type: Function,
            default: () => {}
        }
    }
}
</script>

<template>
    <Meteor v-if="type === 'meteor'" :on-finish />
</template>
