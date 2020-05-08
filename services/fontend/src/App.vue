<template>
  <section id="app">
    <transition>
      <keep-alive>
        <router-view />
      </keep-alive>
    </transition>
  </section>
</template>

<script>
  export default {
    name: 'app',
  }
</script>
