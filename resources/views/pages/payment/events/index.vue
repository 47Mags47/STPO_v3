<script>
import {
    Table, TableRow, TableTd,
    BlueButton, Ico,
 } from "@components"

import { DateTime } from "luxon";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3"
import { route } from "ziggy-js"

export default {
    components: {
        Table, TableRow, TableTd,
        Ico,
        BlueButton,
    },
    data() {
        return {
            loading: false,
        }
    },

    computed: {
        paymentEvents: () => usePage().props.events,
        toggledDate: () => DateTime.fromISO(usePage().props.current_date),

        visibleToggledMonth() {
            return this.toggledDate
                .setLocale('ru')
                .toFormat('LLLL')
        },
        isPaymentDataEmpty() {
            return this.paymentEvents.length === 0
        }
    },

    methods: {
        prevMonth() {
            const prevDate = this.toggledDate.minus({ months: 1 })
            this.routeTo('payment.events.index', {
                month: prevDate.month,
                year: prevDate.year,
            })
        },
        nextMonth() {
            const nextDate = this.toggledDate.plus({ months: 1 })
            this.routeTo('payment.events.index', {
                month: nextDate.month,
                year: nextDate.year,
            })
        },

        getDateFormatted(date) {
            return DateTime
                .fromSQL(date)
                .setLocale('ru')
                .toFormat('dd.MM.yyyy')
        },

        routeTo(url, param) {
            router.get(route(url, param ?? null))
        }
    },

    mounted() {
        router.on('start', () => {
            this.loading = true
        })

        router.on('finish', () => {
            this.loading = false
        })
    },
}
</script>

<template>
    <Table :caption="'Календарь выплат'" id="event-calendar-table">
        <template #toolbar>
           <div class="w-full h-[35px] mt-4! flex justify-between items-center">
                 <div
                    class="w-fit h-full
                    grid grid-cols-[64px_100px_64px] gap-2
                    place-items-center"
                >
                        <BlueButton class="" @click="prevMonth">
                            <Ico type="faArrowLeft"/>
                        </BlueButton>

                        <span class="text-xl!"> {{ visibleToggledMonth }} </span>

                        <BlueButton class="" @click="nextMonth">
                            <Ico type="faArrowRight"/>
                        </BlueButton>
                </div>
                <BlueButton class="w-[35px]! p-2!" @click="routeTo('payment.events.create')">
                    <Ico type="faPlus" />
                </BlueButton>
           </div>
        </template>

        <template #tbody>
            <div
                v-if="loading"
                class="not-data-cell"
            >
                <Ico type="faSpinner" class="animate-spin text-4xl!" />
                <span class="text">Загрузка...</span>
            </div>
            <div v-else-if="isPaymentDataEmpty" vertical="center" horizontal="center" class="not-data-cell">
                <Ico type="faDatabase"/>
                <span class="text">Данных нет :(</span>
            </div>
            <template v-else v-for="(events, date) in paymentEvents">
                <TableRow>
                    <TableTd :rowspan="events.length + 1" class="w-[400px]">
                        {{ getDateFormatted(date) }}
                    </TableTd>
                </TableRow>
                <template v-for="event in events">
                    <TableRow>
                        <TableTd>
                            {{ event.data.payment.name }}
                        </TableTd>
                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!" @click="routeTo('payment.events.edit', event.data.id)">
                                <Ico type="faPen" class="p-[3px]!"/>
                            </BlueButton>
                        </TableTd>
                    </TableRow>
                </template>
            </template>
        </template>
    </Table>
</template>

<style lang="sass" scoped>
#event-calendar-table:deep()
    tr
        &:nth-child(even)
            background: none
        &:hover
            background: none

    .not-data-cell
        height: 250px
        padding: 35px 0px

        border-bottom: $table-border
        border-top: $table-border

        display: flex
        flex-direction: column
        align-items: center
        gap: 25px

        font-size: 1.2rem
</style>
