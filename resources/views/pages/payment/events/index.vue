<script>
import Table from "@components/tables/Table.vue"
import TableRow from "@components/tables/components/TableRow.vue"
import TableTd from "@components/tables/components/TableTd.vue"

import BlueButton from "@components/buttons/BlueButton.vue"
import Ico from "@components/Ico.vue"

import Checkbox from "@components/inputs/CheckBox.vue"

import { DateTime } from "luxon";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3"
import { route } from "ziggy-js"

export default {
    components: {
        Table, TableRow, TableTd,
        Ico,
        Checkbox, BlueButton,
    },
     data() {
        return {
            toggledMonth: DateTime.now(),
        }
    },

    computed: {
        paymentEvents: () => usePage().props.events,

        visibleMonth() {
            return this.toggledMonth.setLocale('ru').toFormat('LLLL')
        },
    },

    methods: {
        prevMonth() {
            this.toggledMonth = this.toggledMonth.minus({ months: 1 })
        },
        nextMonth() {
            this.toggledMonth = this.toggledMonth.plus({ months: 1 })
        },
        getDateFormatted(date) {
            return DateTime.fromSQL(date).setLocale('ru').toFormat('dd-MM-yyyy')
        },
        toRoute(url, param) {
            router.get(route(url, param ?? null))
        }
    }
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

                        <span class="text-xl!"> {{ visibleMonth }} </span>

                        <BlueButton class="" @click="nextMonth">
                            <Ico type="faArrowRight"/>
                        </BlueButton>
                </div>

                <BlueButton class="w-[35px]! p-2!" @click="toRoute('payment.events.create')">
                    <Ico type="faPlus" />
                </BlueButton>
           </div>
        </template>

        <template #tbody>
            <template v-for="(events, date) in paymentEvents">
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
                            <BlueButton class="size-[35px]! p-2!" @click="toRoute('payment.events.edit', event.data.id)">
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
</style>
