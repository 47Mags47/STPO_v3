<script>
import TableRow from '../../components/TableRow.vue';
import TableTh from '../../components/TableTh.vue';
import Ico from '../../../Ico.vue';
import { router, Form } from '@inertiajs/vue3';

export default {
    components: {
        TableRow,
        TableTh,
        Form,
        Ico,
    },

    props: {
        tableHeadValues: {
            type: Array,
            default: () => []
        }
    },

    methods: {
        getCurrentSort(name) {
            return new URLSearchParams(window.location.search)
                .get(`sort[${name}]`) ?? null;
        },

        sortClickHandler(name) {
            if (!name)
                return;

            const currentSort = this.getCurrentSort(name);

            router.get(window.location.pathname, {
                sort: {
                    [name]: currentSort === 'asc' ? 'desc' : 'asc'
                }
            }, {
                preserveState: true,
                preserveScroll: true,
            });
        }
    },
}
</script>


<template>
    <TableRow>
        <TableTh
            v-for="thValue in tableHeadValues"
            :class="{ 'column-filtered': thValue.isFiltered }"
            v-tooltip="thValue.isFiltered ? 'К таблице применён фильтр по этой колонке' : null"
        >
            <div
                v-if="![undefined, null, ''].includes(thValue.title)"
                class="size-full flex items-center justify-between cursor-pointer"
                @click="sortClickHandler(thValue.sortName)"
            >
                <span>
                    {{ thValue.title }}
                </span>

                <div class="column-indicators">
                    <Ico
                        v-if="thValue.isFiltered"
                        type="funnel"
                    />
                    <Ico
                        v-if="thValue.sortName"
                        :type="getCurrentSort(thValue.sortName) === 'asc' ? 'arrow-up-a-z' : 'arrow-down-z-a'"
                    />
                </div>
            </div>
        </TableTh>
    </TableRow>
</template>

<style lang="sass" scoped>
.column-indicators
    display: flex
    gap: 5px

    .ico-container
        flex-shrink: 0
        width: fit-content
        color: var(--color-amber-600)
</style>
