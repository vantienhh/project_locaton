<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on }">
      <v-btn
          v-on="on"
          icon
          small
          :loading="loading || false"
          :disabled="disabled"
          :color="color"
          @click="$emit('click')"
      >
        <v-icon>{{icon}}</v-icon>
      </v-btn>
    </template>
    <span>{{tooltip}}</span>
  </v-tooltip>
</template>
<script>
  export default {
    name: 'BackButton',
    props: [
      'icon', 'tooltip', 'color', 'disabled', 'loading'
    ]
  }
</script>
