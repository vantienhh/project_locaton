<template>
  <v-app>
    <snackbar/>
    <v-content>
      <transition>
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </transition>
    </v-content>
  </v-app>
</template>

<script>
  import Snackbar from '@/components/Snackbar.vue'

  export default {
    components: {
      Snackbar,
    },
  }
</script>
