<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-end mb-6">
                        <inertia-link
                            :href="route('adm.game.create')"
                            style="text-decoration: none"
                        >
                            <v-btn text color="green darken-1" >
                                Cadastrar novo jogo <v-icon dark>mdi-plus</v-icon>
                            </v-btn>
                        </inertia-link>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6" v-for="game in games" :key="game.id">
                                <v-card color="rgba(255, 255, 255, 0.1" class="px-4 my-1">
                                    <v-card-title class="d-flex justify-end" style="font-size: 25px">
                                         {{ game.stadium.name }} | {{ game.stadium.country.name }}
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
                                                    <v-card-title> {{ game.team_home.name }} </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-card class="text-center" shaped>
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="game.team_guest.name_photo ? team_photo_base + game.team_guest.name_photo : ''"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0, 0.9)"
                                                >
                                                    <v-card-title> {{ game.team_guest.name }} </v-card-title>
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
                                            </v-row>

                                            <v-card
                                                class="mt-2"
                                                :color="game.status === 'open' ? 'info' : 'success'"
                                                outlined
                                                style="width: 100%; text-align: center"
                                            >
                                                <v-card-text>
                                                    <v-icon left>{{ game.status === 'open' ? 'mdi-play' : 'mdi-check' }}</v-icon> {{ game.status === 'open' ? 'Aberto' : 'Encerrado' }}
                                                </v-card-text>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-btn block color="green darken-1" outlined>
                                                Calcular pontuação <v-icon dark>mdi-plus</v-icon>
                                            </v-btn>
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
    import { format } from 'date-fns'
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
            team_photo_base: ''
        }),
        mounted(){
            this.team_photo_base = window.location.origin + '/storage/teams/';
        },
        methods: {
            _edit(id){
                this.$inertia.get( route('adm.game.edit',{ id }) );
            },
            filterOnlyCapsText (value, search, item) {
                return value != null && search != null && typeof value === 'string' && value.toString().indexOf(search) !== -1
            },
            confirmDelete(deleted){
                this.deleted = deleted;
                this.dialog = true;
            },
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY')
            },
        },
    }
</script>
