<script>
import HttpError from '../../components/HttpError.vue';

export default {
    components: {
        HttpError
    }
}
</script>

<template>
    <HttpError
        :code="403"
        title="Доступ запрещён"
        description="Вам необходимо подтвердить адрес электронной почты (email)"
        home-url="/dashboard"
        home-description="Подтвердить"
    />
</template>
