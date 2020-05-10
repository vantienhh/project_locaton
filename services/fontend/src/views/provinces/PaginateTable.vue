<template>
  <v-data-table
      multi-sort
      :headers='headers'
      :items="provinces"
      item-key="id"
      :calculate-widths="true"
      :footer-props="{
      'items-per-page-options': itemsPerPageOptions
    }"
      :items-per-page="options.itemsPerPage"
      :server-items-length="provincesPagination.total"
      :loading="provincesLoading"
      :options.sync="options"
      class="pagination-table"
  >
    <!-- population -->
    <template v-slot:item.population="{ item }">
      <population :item="item"/>
    </template>
  </v-data-table>
</template>

<script>
  import {pick} from 'lodash'
  import {mapGetters, mapActions} from 'vuex'
  import Population from './Population'

  export default {
    name: 'ProvincePaginateTable',
    components: {
      Population,
    },
    data() {
      return {
        options: {
          itemsPerPage: 10,
          page: 1,
        },
        headers: [
          {text: 'Tên thành phố', value: 'name', sortable: false},
          {text: 'Dân số', value: 'population', width: '40%', sortable: false}
        ],
      }
    },
    computed: {
      ...mapGetters('table', ['itemsPerPageOptions', 'itemsPerPage']),
      ...mapGetters('province', ['provinces', 'provincesPagination', 'provincesLoading']),
    },
    methods: {
      ...mapActions('province', ['getProvinces']),
      init() {
        this.options = {
          itemsPerPage: parseInt(this.$route.query.itemsPerPage || this.itemsPerPage),
          page: parseInt(this.$route.query.page || 1),
        }
      },
      buildQuery() {
        return {
          limit: this.options.itemsPerPage,
          page: this.options.page,
        }
      },
      routeQuery() {
        return pick(this.options, 'itemsPerPage', 'page')
      },
      fetchData() {
        this.getProvinces({
          query: this.buildQuery(),
          cb: () => {
            this.$router.replace({path: this.$route.path, query: this.routeQuery()})
          },
        })
      },
    },
    created() {
      this.init()
      this.$on('reload', () => {
        this.fetchData()
      })
    },
    watch: {
      options: {
        handler() {
          this.fetchData()
        },
        deep: true,
      },
    },
  }
</script>
