<script>
import Ico from '../Ico.vue';

export default {
    components: {
        Ico
    },

    props: {
        division: {
            type: Object,
            default: {}
        },
        roleName: {
            type: String,
            default: ''
        },

        clickHandler: {
            type: Function,
            default: () => {}
        }
    }
}
</script>

<template>
    <div
        class="h-[100px] w-full bg-(--item-background-color) flex gap-3 p-4! hover:bg-(--item-background-hover-color) cursor-pointer rounded-xl"
        @click="clickHandler(division.id)"
    >
        <div class="size-[74px] rounded-full bg-(--item-ico-background-color) p-4! overflow-hidden">
            <Ico type="building-user" class="text-(--item-ico-color)"/>
        </div>

        <div class="flex flex-col gap-1">
            <span class="text-[18px]! text-(--item-division-text-color)!"> {{ division.name }} </span>
            <span class="text-[16px]! text-(--item-role-text-color)!"> {{ roleName }} </span>
        </div>
    </div>
</template>
