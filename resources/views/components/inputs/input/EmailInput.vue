<script>
import Baseinput from './Baseinput.vue';

export default {
    components: {
        Baseinput
    }
}
</script>

<template>
    <Baseinput
        type="email"
        pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z0-9]{2,}$"
    />
</template>
