<script>
import { Form } from '@inertiajs/vue3';

export default {
    components: {
        Form
    },
    slots: [
        'header',
        'content',
        'footer',
    ],
    props: {
        classes: {
            type: [String, Array, Object],
            default: null
        },
        containerClasses: {
            type: [String, Array, Object],
            default: 'form-container'
        },
        header: {
            type: String,
            default: null
        },

        action: {
            type: Function | String,
        },
        method: {
            type: String,
            default: 'POST',
            validator(value) {
                return ['GET', 'POST', 'PUT', 'DELETE'].includes(value.toUpperCase())
            }
        }
    },
    methods: {
        transform(data) {
            if (method.toUpperCase() !== 'GET')
                data._method = method.toUpperCase()
        }
    },
}
</script>

<template>
    <div :class="containerClasses">
        <Form
            :class="classes"
            :method="method.toUpperCase() === 'GET' ? 'GET' : 'POST'"
            :transform
        >
            <div class="form-header-container">
                <template v-if="'header' in $slots">
                    <slot name="header" />
                </template>
                <template v-else>
                    <h3>{{ header }}</h3>
                </template>
            </div>
            <div class="form-body-container">
                <slot name="content" />
            </div>
            <div class="form-footer-container">
                <slot name="footer" />
            </div>
        </Form>
    </div>
</template>

<style lang="sass" scoped>
.form-container
    width: 100%
    height: 100%
    :deep()
        form
            .form-header-container
                text-align: center
                font-weight: bold
</style>
