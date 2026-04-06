<script>
import ErrorPopUpMsg from "../components/ErrorPopUpMsg.vue";

export default {
    components: {
        ErrorPopUpMsg
    },
    props: {
        errors: {
            type: Array,
            default: () => []
        }
    },
}

</script>

<template>
    <div class="fixed w-fit h-full flex flex-col justify-end bottom-3 right-3">
        <TransitionGroup name="list" tag="div" class="flex flex-col-reverse gap-3 items-end ">
            <ErrorPopUpMsg
                v-for="(error) in errors"
                :key="error.id"
                :msg="error.msg"
                :alertType="error.type"
                @removeErrFromArray="$emit('removeErrFromArray', error.id);"
            />
        </TransitionGroup>
    </div>
</template>

<style scoped>
.list-move {
  transition: transform 0.5s ease;
}
.list-leave-active {
  position: absolute;
}
</style>

