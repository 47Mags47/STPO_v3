<script>
export default {
    props: {
        name: String,
        labelText: String,
    },
};
</script>

<template>
    <label :htmlFor="name" :class="'label ' + name">
        {{ labelText }}
    </label>
</template>
