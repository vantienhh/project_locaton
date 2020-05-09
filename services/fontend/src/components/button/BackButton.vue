<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on }">
      <v-btn v-on="on" icon small @click="$emit('click')" class="mx-2">
        <v-icon>mdi-arrow-left-thick</v-icon>
      </v-btn>
    </template>
    <span>Trờ lại</span>
  </v-tooltip>
</template>
<script>
  export default {
    name: 'BackButton'
  }
</script>
