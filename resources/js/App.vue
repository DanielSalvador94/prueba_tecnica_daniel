<template>
  <v-app>
    <v-main>
      <v-container>
        <tarea-list :tareas="tareas" />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import TareaList from './components/demo/TareaList.vue';
import Multiselect from '@vueform/multiselect'

export default {
  components: {
    TareaList,
    Multiselect
  },
  data() {
    return {
      tareas: []
    };
  }
}
</script>

<style lang="scss">
@import './styles.scss';
</style>
