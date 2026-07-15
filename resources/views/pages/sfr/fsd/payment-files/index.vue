<script>
import { FileResourceTable } from "@components";

export default {
    components: {
        FileResourceTable,
    },
}
</script>

<template>
    <FileResourceTable
        caption="Федеральная социальная доплата (Файлы выплат)"
        fileChannel="sfr.fsd.payment-files"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :collumns="[
            {
                title: 'Месяц',
                dataIndex: 'in_date',
                width: '125px',
            },
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Загружено',
                dataIndex: 'payments.count',
                width: '100px',
                position: 'center-left'
            },
        ]"
    />
</template>
