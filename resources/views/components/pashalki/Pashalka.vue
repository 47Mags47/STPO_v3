<script>
import Meteor from './Meteor.vue';
import Infection from './Infection.vue';
import Kitty from './Kitty.vue';

export default {
    components: {
        Meteor,
        Infection,
        Kitty,
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
    <Meteor     v-if="type === 'meteor'"        :on-finish />
    <Infection  v-if="type === 'infection'"     :on-finish />
    <Kitty      v-if="type === 'kitty'"         :on-finish />
</template>
