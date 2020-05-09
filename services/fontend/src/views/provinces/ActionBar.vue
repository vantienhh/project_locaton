<template>
  <div>
    <icon-tooltip-button
        v-if="!population"
        @click="actionGetPopulation"
        icon="mdi-account-question-outline"
        :loading="loadingApi"
        :tooltip="`Lấy dân số thành phố ${item.name}` "
    />
    <span v-else>Dân số {{item.name}} là: <strong>{{population}}</strong> người</span>
  </div>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    name: 'DistrictActionBar',
    props: {
      item: {
        required: true,
      },
    },
    data() {
      return {
        loadingApi: false,
        population: undefined
      }
    },
    methods: {
      ...mapActions('province', ['getProvincePopulation']),
      async actionGetPopulation() {
        this.loadingApi = true
        await this.getProvincePopulation({
          id: this.item.id,
          cb: (data) => {
            if (data.population) {
              this.population = data.population
            }
          }
        })
        this.loadingApi = false
      },
    },
  }
</script>
