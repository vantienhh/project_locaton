<template>
  <div>
    <span v-if="population"><strong>{{population}}</strong> người</span>
  </div>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    name: 'ProvincePopulation',
    props: {
      item: {
        required: true,
      },
    },
    data() {
      return {
        population: undefined
      }
    },
    methods: {
      ...mapActions('province', ['getProvincePopulation']),
       getPopulation() {
        this.getProvincePopulation({
          id: this.item.id,
          cb: (data) => {
            if (data.population) {
              this.population = data.population
            }
          }
        })
      },
    },
    created () {
      this.getPopulation()
    }
  }
</script>
