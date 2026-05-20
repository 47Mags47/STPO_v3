<script>
import SingleSelect from '../components/inputs/SingleSelect.vue';
import MultiSelect from '../components/inputs/MultiSelect.vue';
export default {
    components: {
        SingleSelect,
        MultiSelect,
    }
}
</script>

<template>
    <form method="GET" action>
        <SingleSelect
        name="singleSelect"
        :options="[
            { label: 'Vue', value: 'vue' },
            { label: 'React', value: 'react' },
            { label: 'Angular', value: 'angular' }
        ]"/>
        <MultiSelect
        :options="[
            { label: 'Vue', name: 'vuename' },
            { label: 'React', name: 'reactname' },
            { label: 'Angular', name: 'angularname' }
        ]"/>
        <button>send</button>
    </form>
</template>

