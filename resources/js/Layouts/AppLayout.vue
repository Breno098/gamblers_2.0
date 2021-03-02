<template>
  <v-app id="inspire">
    <!-- <v-system-bar app>
      <v-spacer></v-spacer>

      <v-icon>mdi-square</v-icon>

      <v-icon>mdi-circle</v-icon>

      <v-icon>mdi-triangle</v-icon>
    </v-system-bar> -->

    <v-app-bar app>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title> Gamblers </v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
        <v-list shaped>
                <div v-for="menuItem in menu"  :key="menuItem.title">
                    <v-subheader>{{menuItem.title}}</v-subheader>

                    <inertia-link
                        v-for="item in menuItem.items"
                        :key="item.title"
                        :href="route(item.route)"
                        style="text-decoration: none"
                    >
                        <v-list-item :class="route().current().replace('.index', '').replace('.create', '') == item.route.replace('.index', '').replace('.create', '') ? 'success' : ''">
                            <v-list-item-icon>
                                <v-icon :v-text="item.icon"></v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </inertia-link>
                </div>

                <!-- <form method="POST" @submit.prevent="logout">
                    <v-btn type="submit" block>
                        <v-list-item>
                                Logout
                        </v-list-item>
                    </v-btn>
                </form> -->
            </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container  class="mt-6">
        <slot></slot>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
        drawer: null,
        menu: [{
                title: 'Registros',
                items: [
                    { title: 'Times',   icon: 'mdi-team', route: 'adm.team.index' },
                    { title: 'País',    icon: 'mdi-team', route: 'adm.country.index' },
                    { title: 'Liga',    icon: 'mdi-team', route: 'adm.league.index' },
                    { title: 'Jogador', icon: 'mdi-team', route: 'adm.player.index' },
                    { title: 'Estádio', icon: 'mdi-team', route: 'adm.stadium.index' },
                    { title: 'Jogo',    icon: 'mdi-user', route: 'adm.game.index' },
                ]
            }, {
                title: 'Jogos',
                items: [
                    { title: 'Oficiais',  icon: 'mdi-user', route: 'adm.oficial-game.index' },
                ]
            }, {
                title: 'Perfil',
                items: [
                    { title: 'Perfil',  icon: 'mdi-user', route: 'profile.show' },
                ]
            }
        ],
        right: null,
    }),
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    },
    mounted(){
        this.$vuetify.theme.dark = true;
    },
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
</style>
