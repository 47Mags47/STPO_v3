<script>
import { DateTime } from "luxon";
import { router, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js"

import { Table, TableRow, TableTd, BlueButton, Ico, ResourceTable, EditButton } from "@components"

export default {
    components: {
        Table, TableRow, TableTd,
        Ico,
        BlueButton,
        EditButton,
        ResourceTable,
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
    <ResourceTable
        caption="Календарь выплат"
        id="payment-event-resource-table"
        :hasCreateButton="true"
    >
        <template #actions>
            <div class="month-picker-container">
                <BlueButton :onClick="prevMonthButtonClickHandler">
                    <Ico type="arrow-left" />
                </BlueButton>

                <span> {{  currentDate.setLocale('ru').toFormat('LLLL yyyy') }} </span>

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
                            <EditButton :onClick="() => editButtonClickHandler (event)"/>
                        </TableTd>

                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!"
                                title="Файлы на выплату"
                                @click="() => showButtonClickHandler (event)">
                                <Ico type="file" class="p-[3px]!" />
                            </BlueButton>
                        </TableTd>

                        <!-- HACK Отображать только администратору -->
                        <TableTd class="w-[56px]">
                            <BlueButton class="size-[35px]! p-2!"
                                title="Файлы в банк"
                                @click="() => goToBunksButtonClickHandler (event)">
                                <Ico type="building-columns" class="p-[3px]!" />
                            </BlueButton>
                        </TableTd>
                    </TableRow>
                </template>
            </template>
        </template>
    </ResourceTable>
</template>

<style lang="sass" scoped>
#payment-event-resource-table
    :deep()
        .table-actions-container
            flex: 1
            justify-content: space-between
            .month-picker-container
                display: flex
                align-items: center
                gap: 10px

                font-size: 1.2rem
</style>
