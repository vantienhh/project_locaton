<template>
  <v-app class="3t-auth-app">
    <v-navigation-drawer
        ref="nav"
        v-model="menuBar"
        app
    >
      <menu-bar/>
    </v-navigation-drawer>

    <v-content style="background: #ecebeb">
      <transition>
        <keep-alive>
          <router-view/>
        </keep-alive>
      </transition>
    </v-content>
  </v-app>
</template>

<script>
  import MenuBar from './components/MenuBar'

  export default {
    name: 'Home',
    components: {
      MenuBar,
    },
    data() {
      return {
        menuBar: true,
      }
    },
  }
</script>

