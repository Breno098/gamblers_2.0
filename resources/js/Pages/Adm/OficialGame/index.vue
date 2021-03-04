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
                                <v-card color="rgba(255, 255, 255, 0.1" class="px-4">
                                    <v-row>
                                        <v-col cols="12">
                                        </v-col>
                                        <v-col cols="4">
                                            <v-card class="text-center">
                                                <v-img
                                                    class="white--text align-end"
                                                    :src="origin + '/storage/app/public/teams/20210304003317real.jpg'"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                                >
                                                    <v-card-title> {{ game.team_home.name }} </v-card-title>
                                                </v-img>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-card class="text-center">
                                                <v-img
                                                    class="white--text align-end"
                                                    src="https://www.kindpng.com/picc/m/251-2519524_soccer-cone-clipart-ball-bola-de-futebol-com.png"
                                                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                                >
                                                    <v-card-title> {{ game.team_guest.name }} </v-card-title>
                                                </v-img>
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
            origin: ''
        }),
        mounted(){
            this.origin = window.location.origin;
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
