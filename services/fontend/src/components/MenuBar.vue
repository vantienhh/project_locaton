<template>
  <v-list subheader dense class="pa-0">
    <v-list-item link :to="{path: '/profile'}">
      <!--      <v-list-item-avatar>-->
      <!--        <v-avatar>-->
      <!--          <img-->
      <!--              :src="user.avatar_path"-->
      <!--              :alt="user.name"-->
      <!--          >-->
      <!--        </v-avatar>-->
      <!--      </v-list-item-avatar>-->

      <!--      <v-list-item-content>-->
      <!--        <v-list-item-title>{{user.name}}</v-list-item-title>-->
      <!--        <v-list-item-subtitle>{{user.email}}</v-list-item-subtitle>-->
      <!--        <v-list-item-subtitle>{{user.phone}}</v-list-item-subtitle>-->
      <!--      </v-list-item-content>-->

      <v-list-item-action @click.prevent.stop="logout">
        <v-tooltip left>
          <template v-slot:activator="{ on }">
            <v-icon v-on="on">exit_to_app</v-icon>
          </template>
          <span>Logout</span>
        </v-tooltip>
      </v-list-item-action>
    </v-list-item>

    <v-divider/>
    <template v-for="(item, key) in mainMenu">
      <v-list-item
          v-if="!item.group"
          :key="key"
          link
          :to="item.route"
      >
        <v-list-item-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            {{ item.text }}
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-subheader :key="key" v-else>{{item.group}}</v-subheader>
    </template>
  </v-list>
</template>
<script>

  export default {
    name: 'MenuBar',
    data() {
      return {
        mainMenu: [
          {
            group: 'Tỉnh thành',
          },
          {
            group: 'Huyện',
          },
        ],
      }
    },
    methods: {
      logout() {

      },
    },
  }
</script>
