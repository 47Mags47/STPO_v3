<script>
import Input from '../../../inputs/input/Input.vue';
import BlueButton from '../../../buttons/BlueButton.vue';
import RedButton from '../../../buttons/RedButton.vue';
import CreateButton from '../../buttons/CreateButton.vue';
import Ico from '../../../Ico.vue';

export default {
    components: {
        Input,
        BlueButton, RedButton, CreateButton,
        Ico,
    },
    props: {
        actions: {
            type: Array,
            default: [],
        },
        hasCreateButton: {
            type: Boolean,
            default: false,
        },

        // HANDLERS
        onCreate: {
            type: Function,
            default: () => {}
        }
    }
};
</script>

<template>
    <div class="toolbar-right-wrapper">
        <div class="table-actions-container">
            <slot name="actions" />
            <div class="resource-table-actions-container">
                <template v-for="action in actions">
                    <BlueButton v-if="action.color === undefined || action.color === 'blue'" :onClick="action.onClick">
                        <Ico :type="action.ico" />
                    </BlueButton>
                    <RedButton v-if="action.color === 'red'" :onClick="action.onClick">
                        <Ico :type="action.ico" />
                    </RedButton>
                </template>
                <CreateButton v-if="hasCreateButton" @click="onCreate" />
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.toolbar-right-wrapper
    width: 100%
    height: 100%
    display: flex
    align-items: center
    justify-content: end

    .table-actions-container
        display: flex
        gap: 10px
        .button
            padding: 9px
            width: 35px
            height: 35px
</style>
