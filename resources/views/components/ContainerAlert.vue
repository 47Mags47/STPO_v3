<script>
import Alert from "./Alert.vue";

export default {
    components: {
        Alert
    },
    props: {
        errors: {
            type: Array,
            default: () => []
        }
    },
}

</script>

<template>
  <div class="fixed z-50 bottom-3 right-3 w-fit pointer-events-none">
      <TransitionGroup name="list" tag="div" class="flex flex-col gap-3 justify-end">
        <Alert
          v-for="error in errors"
          :key="error.id"
          class="pointer-events-auto"
          :msg="error.msg"
          :alertType="error.type"
          @removeErrFromArray="$emit('removeErrFromArray', error.id)"
        />
      </TransitionGroup>
  </div>
</template>

<style scoped>
/* Появление: плавно выплывает снизу и проявляется */
.list-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

/* Исчезновение: плавно улетает вправо */
.list-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

/* Плавное перемещение оставшихся элементов на свободные места */
.list-move {
  transition: transform 0.5s ease;
}

/* Когда элемент удаляется, он вырывается из потока.
   Чтобы он не прыгал, position: absolute должен быть здесь */
.list-leave-active {
  position: absolute;
  width: 100%; /* Чтобы ширина карточки не схлопнулась */
}
</style>
