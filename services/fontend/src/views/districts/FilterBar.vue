<template>
  <v-row dense>
    <v-col cols="12" md="3" sm='6' xs='12'>
      <v-autocomplete
          autocomplete='off'
          :items="provinces"
          label="Thành phố"
          @input="$emit('input', value)"
          clearable
          dense
          hide-details
          item-text="name"
          item-value="id"
          outlined
          v-model="value.province_id"
      />
    </v-col>
  </v-row>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: 'DistrictFilterBar',
    props: {
      value: {
        type: Object,
        default: () => {
          return {}
        }
      }
    },
    computed: {
      ...mapGetters('province', ['provinces']),
    },
    methods: {
      ...mapActions('province', ['getProvinces']),
    },
    created () {
      !this.provinces.length && this.getProvinces()
    }
  }
</script>

