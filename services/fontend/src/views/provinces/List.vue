<template>
  <v-container fluid>
    <v-row dense>
      <v-col cols="12">
        <v-card>
          <v-toolbar dense flat style="border-bottom: 1px solid #c2c2c2;">
            <back-button @click="() => { $router.back() }" />
            <v-toolbar-title>Thành phố</v-toolbar-title>
            <v-spacer/>
          </v-toolbar>

          <v-card-text>
            <paginate-table ref="table"/>
          </v-card-text>
        </v-card>

      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import PaginateTable from './PaginateTable.vue'

  export default {
    name: 'ProvinceList',
    components: {
      PaginateTable,
    },
    beforeRouteEnter(to, from, next) {
      next(async vm => {
        vm.$refs.table.$emit('reload')
      })
    },
  }
</script>
