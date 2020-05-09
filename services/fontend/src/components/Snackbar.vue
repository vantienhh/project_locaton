<template>
  <v-snackbar
      v-model="snackbarModel"
      :bottom="y === 'bottom'"
      :color="color"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
  >
    <div v-html="text"/>
    <v-btn dark text @click="showSnackBar({snackbar: false})">
      <v-icon>close</v-icon>
    </v-btn>
  </v-snackbar>
</template>
<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: 'Snackbar',
    computed: {
      ...mapGetters('snackbar', ['color', 'mode', 'snackbar', 'text', 'timeout', 'x', 'y']),
      snackbarModel: {
        get() {
          return this.snackbar
        },
        set(value) {
          this.showSnackBar({snackbar: value})
        },
      },
    },
    methods: {
      ...mapActions('snackbar', ['showSnackBar']),
    },
  }
</script>
