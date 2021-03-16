<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-space-between mb-6">
                        <div>
                            Total de jogos: {{ gamesView.length }}
                        </div>
                        <div>
                            <v-btn text :class="typeGames === 'showTodayGames' ? 'success mr-2' : 'mr-2'" outlined v-on:click="showTodayGames">
                                Jogos Hoje
                            </v-btn>
                            <v-btn text :class="typeGames === 'showOpenGames' ? 'success mr-2' : 'mr-2'" outlined v-on:click="showOpenGames">
                                Jogos Não Encerrados
                            </v-btn>
                            <v-btn text :class="typeGames === 'showCloseGames' ? 'success mr-2' : 'mr-2'" outlined v-on:click="showCloseGames">
                                Jogos Encerrados
                            </v-btn>
                            <v-btn text :class="typeGames === 'showAllGames' ? 'success mr-2' : 'mr-2'" outlined v-on:click="showAllGames">
                                Todos
                            </v-btn>
                        </div>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6" v-for="game in gamesView" :key="game.id">
                                <v-card color="rgba(255, 255, 255, 0.1" class="px-4 my-1" >
                                    <v-card-title class="d-flex justify-space-between" style="font-size: 25px">
                                        <div>
                                            {{ game.competition.name }}
                                        </div>
                                        <div>
                                            {{ game.stadium.name }} | {{ game.stadium.country.name }}
                                        </div>
                                    </v-card-title>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-card class="text-center" shaped>
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="game.team_home.name_photo ? team_photo_base + game.team_home.name_photo : ''"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,0.9)"
                                                    max-width="400"
                                                    max-height="400"
                                                >
                                                    <v-card-title class="d-flex justify-space-between">
                                                        <div>
                                                             {{ game.team_home.name }}
                                                        </div>
                                                        <div>
                                                            {{ game.scoreboard_official ? game.scoreboard_official.team_home_scoreboard : '--' }}
                                                        </div>
                                                    </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-card class="text-center" shaped>
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="game.team_guest.name_photo ? team_photo_base + game.team_guest.name_photo : ''"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0, 0.9)"
                                                    max-width="400"
                                                    max-height="400"
                                                >
                                                    <v-card-title class="d-flex justify-space-between">
                                                        <div>
                                                             {{ game.team_guest.name }}
                                                        </div>
                                                        <div>
                                                            {{ game.scoreboard_official ? game.scoreboard_official.team_guest_scoreboard : '--' }}
                                                        </div>
                                                    </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row>
                                                <v-col cols="6">
                                                    <v-card
                                                        color="rgba(255, 255, 255, 0.1"
                                                        outlined
                                                        style="width: 100%; text-align: center"
                                                    >
                                                        <v-card-text>
                                                            <v-icon left>mdi-calendar</v-icon> {{ dateFormat(game.date) }}
                                                        </v-card-text>
                                                    </v-card>
                                                </v-col>
                                                <v-col cols="6">
                                                     <v-card
                                                        color="rgba(255, 255, 255, 0.1"
                                                        outlined
                                                        style="width: 100%; text-align: center"
                                                    >
                                                        <v-card-text>
                                                            <v-icon left>mdi-alarm-check</v-icon> {{ game.time }}
                                                        </v-card-text>
                                                    </v-card>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-alert
                                                        outlined
                                                        style="width: 100%; text-align: center"
                                                        class="mt-2"
                                                        :color="game.status === 'open' ? 'info' : 'success'"
                                                    >
                                                        <v-icon left :color="game.status === 'open' ? 'info' : 'success'">{{ game.status === 'open' ? 'mdi-play' : 'mdi-check' }}</v-icon> {{ game.status === 'open' ? 'Aberto' : 'Encerrado' }}
                                                    </v-alert>
                                                </v-col>
                                            </v-row>


                                        </v-col>
                                        <v-col cols="12">
                                             <inertia-link
                                                :href="route('adm.official.game', { id: game.id })"
                                                style="text-decoration: none"
                                            >
                                                <v-btn block color="green darken-1">
                                                    {{ game.status === 'open' ? 'Calcular pontuação' : 'Ver informações' }}
                                                    <v-icon dark v-if="game.status === 'open'">mdi-plus</v-icon>
                                                </v-btn>
                                            </inertia-link>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import moment from 'moment'

    export default {
        components: {
            AppLayout,
        },
        props: {
            games: Array,
        },
        data: () => ({
            deleted: {},
            team_photo_base:  window.location.origin + '/storage/teams/',
            gamesView: [],
            typeGames: 'showOpenGames'
        }),
        mounted(){
            this.showOpenGames();
        },
        methods: {
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY')
            },
            showOpenGames(){
                this.gamesView = [];
                this.games.map(game => {
                    if(game.status === 'open'){
                        this.gamesView.push(game);
                    }
                })
                this.typeGames = 'showOpenGames';
            },
            showCloseGames(){
                this.gamesView = [];
                this.games.map(game => {
                    if(game.status !== 'open'){
                        this.gamesView.push(game);
                    }
                })
                this.typeGames = 'showCloseGames';
            },
            showAllGames(){
                this.gamesView = [];
                this.gamesView = [... this.games];
                this.typeGames = 'showAllGames';
            },
            showTodayGames(){
                this.gamesView = [];
                this.games.map(game => {
                    if(moment(game.date).format('DD/MM/YYYY') === moment().format('DD/MM/YYYY')){
                        this.gamesView.push(game);
                    }
                })
                this.typeGames = 'showTodayGames';
            }
        },
    }
</script>
