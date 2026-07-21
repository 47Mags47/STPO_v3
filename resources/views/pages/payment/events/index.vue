<script>
import { DateTime } from "luxon";
import { router, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js"

import { Table, TableRow, TableTd, BlueButton, Ico } from "@components"

export default {
    components: {
        Table, TableRow, TableTd,
        Ico,
        BlueButton,
    },

    computed: {
        paymentEvents: () => usePage().props.events,
        currentDate: () => DateTime.fromISO(usePage().props.current_date),
    },

    methods: {
        prevMonthButtonClickHandler() {
            const prevDate = this.currentDate.minus({ months: 1 })
            router.get(route('payment.events.index'), {
                month: prevDate.month,
                year: prevDate.year,
            })
        },
        nextMonthButtonClickHandler() {
            const nextDate = this.currentDate.plus({ months: 1 })
            router.get(route('payment.events.index'), {
                month: nextDate.month,
                year: nextDate.year,
            })
        },

        editButtonClickHandler(event){
            router.get(route('payment.events.edit', {
                event: event.data.id,
            }))
        },

        showButtonClickHandler(event){
            router.get(route('payment.payment-files.index', {
                event: event.data.id,
            }))
        },

        goToBunksButtonClickHandler(event){
            router.get(route('payment.banks.index', {
                event: event.data.id,
            }))
        },

        getDateFormatted(date) {
            return DateTime
                .fromSQL(date)
                .setLocale('ru')
                .toFormat('dd.MM.yyyy')
        },
    },
}
</script>

<template>
    <Table :caption="'Календарь выплат'" id="event-calendar-table">
        <template #toolbar>
            <div class="month-picker-container">
                <BlueButton :onClick="prevMonthButtonClickHandler">
                    <Ico type="arrow-left" />
                </BlueButton>

                <span> {{ currentDate.toFormat('dd.MM.yyyy') }} </span>

                <BlueButton :onClick="nextMonthButtonClickHandler">
                    <Ico type="arrow-right" />
                </BlueButton>
            </div>
        </template>

        <template #colgroup>
            <col width="100px">
            <col width="auto">
        </template>

        <template #tbody>
            <template v-for="(events, date) in paymentEvents">
                <TableRow>
                    <TableTd :rowspan="events.length + 1">
                        {{ getDateFormatted(date) }}
                    </TableTd>
                </TableRow>
                <template v-for="event in events">
                    <TableRow>
                        <TableTd>
                            {{ event.data.payment.name }}
                        </TableTd>
                        <!-- HACK Отображать только администратору -->
                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!"
                                @click="() => editButtonClickHandler (event)">
                                <Ico type="pen" class="p-[3px]!" />
                            </BlueButton>
                        </TableTd>

                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!"
                                @click="() => showButtonClickHandler (event)">
                                <Ico type="file" class="p-[3px]!" />
                            </BlueButton>
                        </TableTd>

                        <!-- HACK Отображать только администратору -->
                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!"
                                @click="() => goToBunksButtonClickHandler (event)">
                                <Ico type="building-columns" class="p-[3px]!" />
                            </BlueButton>
                        </TableTd>
                    </TableRow>
                </template>
            </template>
        </template>
    </Table>
</template>

<style lang="sass" scoped>
#event-calendar-table
    .month-picker-container
        display: flex
        gap: 10px

        align-items: center

        font-size: 1.2rem
        .button
            width: 35px
            height: 25px
</style>
