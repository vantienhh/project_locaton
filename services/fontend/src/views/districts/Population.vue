<template>
  <div>
    <span v-if="population"><strong>{{population}}</strong> người</span>
    <v-icon v-else>mdi-spin mdi-reload</v-icon>
  </div>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    name: 'DistrictPopulation',
    props: {
      item: {
        required: true,
      },
    },
    data() {
      return {
        population: undefined,
      }
    },
    methods: {
      ...mapActions('district', ['getDistrictPopulation']),
      getPopulation() {
        this.getDistrictPopulation({
          id: this.item.id,
          cb: (data) => {
            if (data.population) {
              this.population = data.population
            }
          },
        })
      },
    },
    created() {
      this.getPopulation()
    },
  }
</script>
