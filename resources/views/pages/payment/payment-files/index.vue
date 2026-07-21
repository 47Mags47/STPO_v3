<script>
import { FileResourceTable } from "@components";
import { router, usePage } from "@inertiajs/vue3";

export default {
    components: {
        FileResourceTable,
    },
    computed: {
        event: () => usePage().props.event.data,
    },
    methods: {
        goToRecipientsButtonClickHandler(file){
            router.visit(route('payment.recipients.index', {
                'event': this.event.id,
                'paymentFile': file.id
            }))
        }
    }
}
</script>

<template>
    <FileResourceTable
        caption="Выплаты (Файлы на выплату)"
        fileChannel="payment.payment-files"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :rowLinks="[
            {
                'ico': 'user',
                'onClick': (file) => goToRecipientsButtonClickHandler(file)
            }
        ]"
        :collumns="[
            {
                // HACK показывать только адмиинистратору
                title: 'Организация',
                dataIndex: 'division.name',
            },
            {
                title: 'Выплата',
                dataIndex: 'payment.name',
                width: '350px',
            },
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Банк',
                dataIndex: 'bank.name',
                width: '200px',
            },
            {
                title: 'Выплата',
                dataIndex: 'payment.name',
                width: '350px',
            },
            {
                title: 'Записей',
                dataIndex: 'recipients_count',
                width: '100px',
            },
            {
                title: 'Сумма',
                dataIndex: 'amount',
                width: '100px',
            },
        ]"
    />
</template>
