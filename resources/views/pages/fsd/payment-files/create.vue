<script>
import { ResourceForm } from "@components";

export default {
    components: {
        ResourceForm
    },
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('fsd.payment-files.store', { sfrFile: route().params.sfrFile })"
        :inputs="[
            {
                type: 'bigFile',
                name: 'upload_file_id',
                label: 'Файл',
            },
            {
                type: 'date',
                name: 'date_start',
                label: 'Дата начала',
            },
            {
                type: 'date',
                name: 'date_end',
                label: 'Дата окончания',
            },
        ]"
    />
</template>





<!-- <script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";
import BaseForm from "../../../components/forms/BaseForm.vue";
import Uploader from "simple-uploader.js/src/uploader";

export default {
    components: {
        ResourceForm,
        BaseForm
    },
    computed: {
        sfrFile: () => usePage().props.sfrFile.data,
    },

    data() {
        return {
            Uploader,
        }
    },

    methods: {
        addFilehandler(e) {
            let uploader = new Uploader({
                method: 'octet',
                target: route('fsd.payment-files.store', { sfrFile : 1 }),
                testMethod: 'POST'
            })

            uploader.addFile(e.target.files[0])
            uploader.upload()
        }
    },
    mounted(){
        console.log(btoa);
    }
};
</script>

<template>
    <BaseForm method="POST" action="./">
        <template #content>
            <input type="file" name="file" @change="addFilehandler">
            <input type="text" value="text" name="test">
            <input type="submit" value="отправить">
        </template>
    </BaseForm>

</template> -->
<!-- <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('fsd.payment-files.store', { 'sfrFile': sfrFile.id })"
        :inputs="[
            {
                type: 'file',
                name: 'file',
                label: 'Файл',
            },
        ]"
    >
    </ResourceForm> -->
