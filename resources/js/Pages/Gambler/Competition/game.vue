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
                                                        color="rgba(255, 255, 255, 0.1)"
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
                                            <v-card class="text-center pl-3">
                                                <v-row>
                                                    <v-col cols="12" md="4">
                                                        <v-img
                                                            :src="game.team_home.name_photo ? team_photo_base + game.team_home.name_photo : ''"
                                                            gradient="to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5)"
                                                            max-width="600"
                                                            max-height="600"
                                                        >
                                                            <span class="float-right mr-3 mt-3 black--text">
                                                                <v-card class="text-center" shaped>
                                                                    <v-card-text>
                                                                        Gols: {{ goalsHome.length }}
                                                                    </v-card-text>
                                                                </v-card>
                                                            </span>
                                                        </v-img>
                                                        <v-card-title> {{ game.team_home.name }} | {{ game.team_home.country.name }} </v-card-title>
                                                    </v-col>
                                                    <v-col cols="12" md="8">
                                                        <v-card class="text-center">
                                                            <v-card-text>
                                                                <v-data-table
                                                                    :headers="headers"
                                                                    :items="game.team_home.players"
                                                                    :footer-props="{
                                                                        itemsPerPageOptions: [5],
                                                                    }"
                                                                >
                                                                    <template v-slot:item="row">
                                                                        <tr>
                                                                            <td>{{row.item.name}}</td>
                                                                            <td>
                                                                                <v-chip class="ma-2" label :color="colorPosition(row.item.position)">
                                                                                    {{row.item.position}}
                                                                                </v-chip>
                                                                            </td>
                                                                            <td>
                                                                                <v-btn block v-on:click="addGoalHome(row.item)" :disabled="game.status !== 'open'">
                                                                                    <v-icon>mdi-plus</v-icon>
                                                                                </v-btn>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </v-data-table>
                                                            </v-card-text>

                                                            <v-card-title>Gols marcados </v-card-title>
                                                            <v-card-text>
                                                                <v-data-table
                                                                    :headers="headers"
                                                                    :items="goalsHome"
                                                                    :footer-props="{
                                                                        itemsPerPageOptions: [5],
                                                                    }"
                                                                    no-data-text="Nenhum jogador adicionado"
                                                                >
                                                                    <template v-slot:item="row">
                                                                        <tr>
                                                                            <td>{{row.item.name}}</td>
                                                                            <td>
                                                                                <v-chip class="ma-2" label :color="colorPosition(row.item.position)">
                                                                                    {{row.item.position}}
                                                                                </v-chip>
                                                                            </td>
                                                                            <td>
                                                                                <v-btn block v-on:click="removeGoalHome(row.item)" :disabled="game.status !== 'open'">
                                                                                    <v-icon>mdi-minus</v-icon>
                                                                                </v-btn>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </v-data-table>
                                                            </v-card-text>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </v-card>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-card class="text-center pl-3 mt-6">
                                                <v-row>
                                                    <v-col cols="12" md="4">
                                                        <v-img
                                                            :src="game.team_guest.name_photo ? team_photo_base + game.team_guest.name_photo : ''"
                                                            gradient="to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5)"
                                                            max-width="600"
                                                            max-height="600"
                                                        >
                                                            <span class="float-right mr-3 mt-3 black--text">
                                                                <v-card class="text-center" shaped>
                                                                    <v-card-text>
                                                                        Gols: {{ goalsGuest.length }}
                                                                    </v-card-text>
                                                                </v-card>
                                                            </span>
                                                        </v-img>
                                                        <v-card-title> {{ game.team_guest.name }} | {{ game.team_guest.country.name }} </v-card-title>
                                                    </v-col>
                                                    <v-col cols="12" md="8">
                                                        <v-card class="text-center">
                                                            <v-card-text>
                                                                <v-data-table
                                                                    :headers="headers"
                                                                    :items="game.team_guest.players"
                                                                    :footer-props="{
                                                                        itemsPerPageOptions: [5],
                                                                    }"
                                                                >
                                                                    <template v-slot:item="row">
                                                                        <tr>
                                                                            <td>{{row.item.name}}</td>
                                                                            <td>
                                                                                <v-chip class="ma-2" label :color="colorPosition(row.item.position)">
                                                                                    {{row.item.position}}
                                                                                </v-chip>
                                                                            </td>
                                                                            <td>
                                                                                <v-btn block v-on:click="addGoalGuest(row.item)" :disabled="game.status !== 'open'">
                                                                                    <v-icon>mdi-plus</v-icon>
                                                                                </v-btn>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </v-data-table>
                                                            </v-card-text>

                                                            <v-card-title>Gols marcados </v-card-title>
                                                            <v-card-text>
                                                                <v-data-table
                                                                    :headers="headers"
                                                                    :items="goalsGuest"
                                                                    :footer-props="{
                                                                        itemsPerPageOptions: [5],
                                                                    }"
                                                                    no-data-text="Nenhum jogador adicionado"
                                                                >
                                                                    <template v-slot:item="row">
                                                                        <tr>
                                                                            <td>{{row.item.name}}</td>
                                                                            <td>
                                                                                <v-chip class="ma-2" label :color="colorPosition(row.item.position)">
                                                                                    {{row.item.position}}
                                                                                </v-chip>
                                                                            </td>
                                                                            <td>
                                                                                <v-btn block v-on:click="removeGoalGuest(row.item)" :disabled="game.status !== 'open'">
                                                                                    <v-icon>mdi-minus</v-icon>
                                                                                </v-btn>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </v-data-table>
                                                            </v-card-text>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </v-card>
                                        </v-col>

                                    </v-row>
                                </v-card>
                            </v-col>
                            <v-col>
                                <v-btn block v-on:click="enableDialog" :disabled="diabledBet(game)">
                                    {{ disabled ? 'Jogo encerrado' : 'Apostar' }}
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                 <v-dialog v-model="dialog" max-width="500">
                    <v-card>
                        <v-card-title>
                            Confirmar aposta?
                        </v-card-title>
                        <v-card-text>
                            <div>
                                {{ game.competition.name }}
                            </div>
                            <div>
                                {{ game.stadium.name }} | {{ game.stadium.country.name }}
                            </div>
                            <v-divider class="mt-2 mb-4"/>
                            <div>
                                {{ game.team_home.name }} | {{ goalsHome.length }} X {{ goalsGuest.length }} | {{ game.team_guest.name }}
                            </div>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" text @click="dialog = false">
                                <v-icon dark>mdi-close</v-icon>
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="storeGame">
                                <v-icon dark>mdi-check</v-icon>
                            </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import moment from 'moment'
    import { differenceInMinutes, parse } from 'date-fns';

    export default {
        components: {
            AppLayout,
        },
        props: {
            game: Object,
        },
        data: () => ({
            dialog: false,
            disabled: false,
            goalsHome: [],
            goalsGuest: [],
            headers: [{
                text: 'Nome',
                value: 'name'
            }, {
                text: 'Posição',
                value: 'position'
            }, {
                sortable: false
            }],
            team_photo_base: window.location.origin + '/storage/teams/'
        }),
        mounted(){
            if(this.game.scoreboard_bet.goals){
                this.game.scoreboard_bet.goals.map(goal => {
                    if(this.game.team_home.id === goal.team_id){
                        this.addGoalHome(goal.player);
                    } else if(this.game.team_guest.id === goal.team_id){
                        this.addGoalGuest(goal.player);
                    }
                })
            }
        },
        methods: {
            diabledBet(game){
                return game.status !== 'open' || differenceInMinutes( parse(game.date + ' ' + game.time, 'yyyy-MM-dd HH:mm', new Date()),  new Date()) < 10;
            },
            enableDialog(){
                this.disabled = this.diabledBet(this.game);
                if(this.disabled){
                    return;
                }
                this.dialog = true;
            },
            storeGame(){
                this.disabled = this.diabledBet(this.game);

                if(this.disabled){
                    return;
                }

                this.$inertia.post( route('gambler.store-game'), {
                    game: this.game,
                    goalsHome: this.goalsHome,
                    goalsGuest: this.goalsGuest
                });
            },
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY')
            },
            addGoalHome(player){
                this.goalsHome.push(player)
            },
            removeGoalHome(player){
                let goalsArray = [];
                let notRemoveItem = true;
                this.goalsHome.map(goal => {
                    if(goal.id === player.id && notRemoveItem){
                        notRemoveItem = false;
                        return;
                    }
                    goalsArray.push(goal);
                })
                this.goalsHome = goalsArray;
            },
            addGoalGuest(player){
                this.goalsGuest.push(player)
            },
            removeGoalGuest(player){
                let goalsArray = [];
                let notRemoveItem = true;
                this.goalsGuest.map(goal => {
                    if(goal.id === player.id && notRemoveItem){
                        notRemoveItem = false;
                        return;
                    }
                    goalsArray.push(goal);
                })
                this.goalsGuest = goalsArray;
            },
            colorPosition(position){
                switch (position) {
                    case 'GO': return 'brown';
                    case 'ZAG': return 'primary';
                    case 'LT': return 'primary';
                    case 'VOL': return 'green';
                    case 'MEI': return 'green';
                    case 'ATA': return 'red';
                    default: return '';
                }
            }
        },
    }
</script>
