<template>
    <app-layout>
        <v-row>
            <v-col cols="12">
                <competitions :competitions_array="competitions_array"/>
            </v-col>
            <v-col cols="12" md="6">
                <score-rules/>
            </v-col>
            <v-col cols="12" md="6">
                <ranking :users_scores="users_scores"/>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import ScoreRules from './scoreRules.vue';
    import Ranking from './ranking.vue';
    import Competitions from './competitions.vue';

    export default {
        components: {
            AppLayout,
            ScoreRules,
            Ranking,
            Competitions
        },
        props: {
            users_scores: Array,
            competitions_array: Array
        },
        data: () => ({
            dialog: {
                show: false,
                title: '',
                score: null,
                content: []
            },
            rules: [{
                title: 'Acertar exatamente o placar',
                score: '3.0',
                content: [
                    'Caso o usuário acerte exatamente o placar da partida, irá ganhar 3 pontos.'
                ]
            }, {
                title: 'Acertar a circunstância do jogo',
                score: '1.0',
                content: [
                    'Caso o usuário acerte se o jogo terminar em empate, vitória para o time mandante ou  vitória para o time visitante, irá ganhar 1 ponto.',
                    'Obs.: Essa regra se aplica apenas se o usuário não fez pontuação por acertar exatamente o placar.'
                ]
            }, {
                title: 'Acertar gols',
                score: '0.5',
                content: [
                    'Para cada gol acertado, o usuário ganha 0.5 pontos.'
                ]
            }]
        }),
        methods: {
        },
    }
</script>
