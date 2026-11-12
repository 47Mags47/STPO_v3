<script>
import { ResourceForm } from "@components"
export default {
    components: {
        ResourceForm
    }
}
</script>

<template>
    <ResourceForm
        class="w-[100px]!"
        :inputs="[
            {
                type: 'string',
                name: 'string',
                value: 'string-value',
                label: 'string'
            },
            {
                type: 'number',
                name: 'number',
                value: '123',
                label: 'number'
            },
            {
                type: 'email',
                name: 'email',
                value: 'email-value',
                label: 'email'
            },
            {
                type: 'phone',
                name: 'phone',
                value: 'phone-value',
                label: 'phone',
                hasDob: true
            },
            {
                type: 'password',
                name: 'password',
                value: 'password-value',
                label: 'password'
            },
            {
                type: 'text',
                name: 'text',
                value: 'text-value',
                label: 'text'
            },
            {
                type: 'select',
                name: 'select',
                label: 'select',
                options: [
                    {
                        id: 1,
                        name: 'test1'
                    }
                ]
            },
            {
                type: 'selectPopup',
                name: 'select',
                label: 'select'
            },
        ]"
    />
</template>
