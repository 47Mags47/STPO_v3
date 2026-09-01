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
                event: event.id,
            }))
        },

        showButtonClickHandler(event){
            router.get(route('payment.payment-files.index', {
                event: event.id,
            }))
        },

        goToBunksButtonClickHandler(event){
            router.get(route('payment.banks.index', {
                event: event.id,
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
        :data="paymentEvents.data"
        :meta="paymentEvents.meta"
        :collumns="[
            {
                title: 'Дата',
                dataIndex: 'in_date',
                rowspan: (row, index, data) => {
                    const previous = data[index - 1]

                    if (previous?.in_date === row.in_date) {
                        return 0
                    }

                    return data.filter(item => item.in_date === row.in_date).length
                },
            },
            {
                title: 'код',
                dataIndex: 'payment.code',
            },
        ]"
        :rowLinks="[
            {
                color: 'blue',
                ico: 'pen',
                onClick: editButtonClickHandler
            },
            {
                color: 'blue',
                ico: 'file',
                onClick: showButtonClickHandler
            },
            {
                color: 'blue',
                ico: 'building-columns',
                onClick: goToBunksButtonClickHandler
            },
        ]"
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
