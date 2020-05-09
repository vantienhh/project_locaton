<template>
  <v-data-table
      multi-sort
      :headers='headers'
      :items="districts"
      item-key="id"
      :calculate-widths="true"
      :footer-props="{
      'items-per-page-options': itemsPerPageOptions
    }"
      :items-per-page="options.itemsPerPage"
      :server-items-length="districtsPagination.total"
      :loading="districtsLoading"
      :options.sync="options"
      class="pagination-table"
  >
    <template v-slot:top>
      <v-sheet class="pa-2">
        <filter-bar v-model="filters"/>
      </v-sheet>
    </template>
    <!-- actions -->
    <template v-slot:item.actions="{ item }">
      <action-bar :item="item"/>
    </template>
  </v-data-table>
</template>

<script>
  import {pick, isEqual} from 'lodash'
  import {mapGetters, mapActions} from 'vuex'
  import ActionBar from './ActionBar'
  import FilterBar from './FilterBar'

  export default {
    name: 'DistrictPaginateTable',
    components: {
      FilterBar,
      ActionBar,
    },
    data() {
      return {
        filters: {
          province_id: undefined,
        },
        options: {
          itemsPerPage: 10,
          page: 1,
        },
        headers: [
          {text: 'Tên quận/huyện', value: 'name', sortable: false},
          {text: 'Ngày tạo', value: 'created_at', sortable: false},
          {text: 'Hành động', value: 'actions', width: '40%', sortable: false},
        ],
      }
    },
    computed: {
      ...mapGetters('table', ['itemsPerPageOptions', 'itemsPerPage']),
      ...mapGetters('district', ['districts', 'districtsPagination', 'districtsLoading']),
    },
    methods: {
      ...mapActions('district', ['getDistricts']),
      init() {
        this.options = {
          itemsPerPage: parseInt(this.$route.query.itemsPerPage || this.itemsPerPage),
          page: parseInt(this.$route.query.page || 1),
        }

        this.filters = this.parseFilter()
      },
      parseFilter() {
        return {
          province_id: this.$route.query.province_id,
        }
      },
      buildQuery() {
        return {
          limit: this.options.itemsPerPage,
          page: this.options.page,
          province_id: this.filters.province_id,
        }
      },
      routeQuery() {
        let query   = pick(this.filters, 'province_id')
        let options = pick(this.options, 'itemsPerPage', 'page')
        return {...query, ...options}
      },
      fetchData() {
        this.getDistricts({
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
      filters: {
        handler(value) {
          !isEqual(value, this.parseFilter()) && this.fetchData()
        },
        deep: true,
      },
    },
  }
</script>
