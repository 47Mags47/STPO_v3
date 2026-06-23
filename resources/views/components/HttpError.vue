<script>
export default {
    props: {
        code: {
            type: [String, Number],
            default: 400
        },
        title: {
            type: String,
            default: 'Доступ запрещён',
        },
        description: {
            type: String,
            default: 'Обратитесь к администратору или вернитесь на главную страницу',
        },

        homeDescription: {
            type: String,
            default: 'Домой'
        },
        homeUrl: {
            type: String,
            default: '/',
        },
    }
}
</script>

<template>
    <div class="size-full bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 flex justify-center items-center">
        <div class="flex flex-col justify-center items-center">

            <p class="text-[180px]! leading-none text-blue-200">
                <slot name="code" v-if="$slots.code"/>
                <template v-else>
                    {{ code }}
                </template>
            </p>


            <span class="text-[20px]! text-white mt-5!">
                <slot name="code" v-if="$slots.title"/>
                <template v-else>
                    {{ title }}
                </template>
            </span>

            <div class="mt-2!">
                <p class="text-slate-400">
                    <slot name="code" v-if="$slots.description"/>
                    <template v-else>
                        {{ description }}
                    </template>
                </p>
            </div>

            <button class="mt-2!">
                <a class="text-blue-300! hover:text-blue-100! cursor-pointer" :href="homeUrl">
                        {{ homeDescription }}
                </a>
            </button>

        </div>
    </div>
</template>
