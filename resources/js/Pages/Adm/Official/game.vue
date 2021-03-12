<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-space-between mb-6">
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" >
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
                                        <v-col cols="6" md="3">
                                            <v-card class="text-center" shaped>
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="game.team_home.name_photo ? team_photo_base + game.team_home.name_photo : ''"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,0.9)"
                                                    max-width="500"
                                                    max-height="500"
                                                >
                                                    <v-card-title> {{ game.team_home.name }} </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6" md="3">
                                            <v-card class="text-center" shaped>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6" md="3">
                                            <v-card class="text-center" shaped>
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="game.team_guest.name_photo ? team_photo_base + game.team_guest.name_photo : ''"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0, 0.9)"
                                                    max-width="500"
                                                    max-height="500"
                                                >
                                                    <v-card-title> {{ game.team_guest.name }} </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6" md="3">
                                            <v-card class="text-center" shaped>
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
                                        </v-col>
                                        <v-col cols="12">
                                            <v-btn block color="green darken-1" :disabled="game.status === 'open' ? false : true">
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
    import moment from 'moment'

    export default {
        components: {
            AppLayout,
        },
        props: {
            game: Object,
        },
        data: () => ({
            team_photo_base: window.location.origin + '/storage/teams/'
        }),
        mounted(){
        },
        methods: {
            _edit(id){
                this.$inertia.get( route('adm.game.edit',{ id }) );
            },
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY')
            },
        },
    }
</script>
