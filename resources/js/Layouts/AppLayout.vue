<template>
  <v-app id="inspire">
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
                title: 'Home',
                items: [
                    { title: 'Dashboard',   icon: 'mdi-team', route: 'dashboard' },
                ]
            }, {
                title: 'Registros',
                items: [
                    { title: 'Times',       icon: 'mdi-team', route: 'adm.team.index' },
                    { title: 'País',        icon: 'mdi-team', route: 'adm.country.index' },
                    { title: 'Competição',  icon: 'mdi-team', route: 'adm.competition.index' },
                    { title: 'Jogador',     icon: 'mdi-team', route: 'adm.player.index' },
                    { title: 'Estádio',     icon: 'mdi-team', route: 'adm.stadium.index' },
                    { title: 'Jogo',        icon: 'mdi-user', route: 'adm.game.index' },
                ]
            }, {
                title: 'Jogos',
                items: [
                    { title: 'Oficiais',  icon: 'mdi-user', route: 'adm.official.competitions' },
                ]
            }, {
                title: 'Perfil',
                items: [
                    { title: 'Perfil',  icon: 'mdi-user', route: 'profile.show' },
                ]
            }, {
                title: '-- Apostador --',
                items: [
                    { title: 'Dashboard',  icon: 'mdi-user', route: 'gambler.dashboard' },
                    { title: 'Competições',  icon: 'mdi-user', route: 'gambler.competitions' },
                    { title: 'Pontuações',  icon: 'mdi-user', route: 'gambler.score-report' },
                    { title: 'Regras',  icon: 'mdi-user', route: 'gambler.score-rules' },
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
@import url('https://fonts.googleapis.com/css2?family=Akaya+Telivigala&family=RocknRoll+One&display=swap');

* {
    font-family: 'RocknRoll One', sans-serif;
}

.v-application ::-webkit-scrollbar {
    height: 8px;
    width: 13px;
}

.v-application ::-webkit-scrollbar-corner {
    background: transparent;
}

.v-application ::-webkit-scrollbar-thumb {
    background: #43A047;
    border-radius: 8px;
}
</style>
