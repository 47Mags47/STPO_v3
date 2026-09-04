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
        description="Обратитесь к администратору или вернитесь на главную страницу"
        home-url="/"
        home-description="Главная страница"
    />
</template>
