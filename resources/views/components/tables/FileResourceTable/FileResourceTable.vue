<script>
import { router, usePage } from '@inertiajs/vue3';
import ResourceTable from '../ResourceTable/ResourceTable.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        ResourceTable
    },
    props: {
        collumns: {
            type: Array,
            default: () => []
        },
        fileChannel: {
            type: String,
            default: null
        },

        rowLinks: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        files: () => usePage().props.files,
        newCollumns() {
            let statusCollumns = [
                {
                    title: '',
                    type: 'render',
                    width: '25px',
                    position: 'center-center',
                    class: 'table-file-status-cell',
                    render: (row) => {
                        return {
                            component: Ico,
                            props: {
                                type: 'circle',
                                title: this.getFileTitle(row.file),
                                style: `color: ${this.getStatusColor(row.file)}`
                            }
                        }
                    },
                }
            ]

            return statusCollumns.concat(this.collumns)
        },
        newRowLinks(){
            let links = this.rowLinks

            links.push({
                visible: (file) => file.file.errors > 0,
                ico: 'bug',
                color: 'red',
                onClick: (file) => router.get(route('files.errors', {file: file.file.id}))
            })

            return links
        }
    },

    methods: {
        getStatusColor(file) {
            if (file.status.code === 'ok' && file.errors > 0)
                return 'red'

            return {
                'ok': 'green',
                'creating': 'orange',
                'reading': 'orange',
                'moving': 'orange',
            }[file.status.code] ?? 'black'
        },

        getFileTitle(file) {
            if(file.status.code === 'ok')
                return file.errors > 0
                    ? 'Содержит ошибки'
                    : file.status.name
            else
                return file.status.name
        }
    },

    mounted() {
        if (this.fileChannel !== null){
            // HACK додумать логику, что бы при быстрой смене статуса флажок не мигал
            Echo.private(this.fileChannel)
                .listen('.update', (data) => {
                    if(this.files === undefined)
                        return

                    let index = this.files.data.findIndex((file) => file.id === data.file.id)

                    if (index >= 0)
                        this.files.data[index] = data.file
                })
        }
    }
}
</script>

<template>
    <ResourceTable
        :data="files.data"
        :meta="files.meta"
        :collumns="newCollumns"
        :rowLinks="newRowLinks"
    />
</template>
