<script>
import BaseForm from './BaseForm.vue';

export default {
    components: {
        BaseForm
    },
    slots: [
        'default'
    ]
}
</script>
<template>
    <BaseForm container-class="form-container vertical-form-container">
        <template v-for="(_, name) in $slots" #[name]="slotData">
            <slot :name="name" v-bind="slotData || {}" />
        </template>
    </BaseForm>
</template>

<style lang="sass" scoped>
.form-container
    padding-top: 25px
    padding-left: calc( (100% - 550px - 50px) / 2 )
    padding-right: calc( (100% - 550px - 50px) / 2 )
    padding-bottom: 25px

    max-height: 100vh
    overflow: auto

    display:  grid
    @include scroll
    :deep()
        form
            margin: auto

            width: 550px
            padding: 25px

            border-radius: $default-border-radius
            box-shadow: 2px 2px 8px 4px #eee
            .form-body-container
                display: flex
                flex-direction: column
                gap: 10px
</style>
