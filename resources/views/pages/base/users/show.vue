<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceForm, ResourceTable } from "@components";
import Ico from "../../../components/Ico.vue";

export default {
    components: {
        ResourceForm,
        ResourceTable,
        Ico
    },

    computed: {
        user() {
            return usePage().props.user?.data;
        },
    },
};
</script>

<template>
    <ResourceForm
        :has-submit="false"
        :inputs="[
            {
                type: 'string',
                name: 'first_name',
                label: 'Имя',
                value: user.first_name,
                readonly: true,
            },
            {
                type: 'string',
                name: 'last_name',
                label: 'Фамилия',
                value: user.last_name,
                readonly: true,
            },
            {
                type: 'string',
                name: 'middle_name',
                label: 'Отчество',
                value: user.middle_name,
                readonly: true,
            },
            {
                type: 'string',
                name: 'email',
                label: 'Почта',
                value: user.email,
                readonly: true,
            },
            {
                type: 'string',
                name: 'phone',
                label: 'Телефон',
                value: user.phone,
                readonly: true,
            },
            {
                type: 'string',
                name: 'phone_dob',
                label: 'Доп. телефон',
                value: user.phone_dob,
                readonly: true,
            },
        ]"
    >
        <template #header>
            <div class="grid grid-cols-[auto_1fr_auto] items-center">
                <div
                    class="avatar-wrapper flex items-center justify-center"
                >
                    <img v-if="![null, undefined].includes(user.avatar?.url)" :src="user.avatar?.url" />
                    <Ico v-else class="avatar-mock-ico" type="circle-user" />
                    <input
                        ref="avatarInput"
                        type="file"
                        name="avatar"
                        accept="image/*"
                        hidden
                        @change="onAvatarChange"
                    />
                </div>

                <span class="text-2xl justify-self-center"> {{ user.full_name }} </span>

                <div class="empty"></div>
            </div>
        </template>

        <template #footer>
            <ResourceTable
                caption="Подразделения"
                :data="user.divisions"
                :columns="[
                    {
                        title: 'Наименование',
                        dataIndex: 'name',
                    },
                ]"
            />
        </template>
    </ResourceForm>
</template>

<style lang="sass" scoped>
.avatar-wrapper
    position: relative
    overflow: hidden
    width: 148px
    height: 148px

    border: var(--border)
    border-radius: 100%

.table-container
    margin-bottom: 0
    padding-bottom: 0

    :deep(td)
        border-right: var(--table-border)
</style>
