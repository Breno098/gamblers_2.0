<template>
    <app-layout>
        <v-row>
            <v-col cols="12">
                <v-card class="rounded-t-xl">
                    <v-img
                        class="white--text align-end"
                        :src="score_rules_photo"
                        gradient="to right, rgba(0,0,0,0.1), rgba(0,0,0,0.6)"
                        max-height="200"
                    >
                        <v-card-title>Pontuação</v-card-title>
                    </v-img>

                    <v-card-text>
                        <v-card v-for="rule in rules" :key="rule.title">
                            <v-card-title class="d-flex justify-space-between mt-4">
                                <div>
                                    {{ rule.title  }}
                                </div>
                                <div>
                                    {{ rule.score }}
                                </div>
                            </v-card-title>
                            <v-card-text v-for="(content, index) in rule.content" :key="index">
                                {{ content }}
                            </v-card-text>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },
        props: {
        },
        data: () => ({
            score_rules_photo: window.location.origin + '/storage/geral/score-rules.jpg',
            rules: [{
                title: 'Acertar exatamente o placar',
                score: '+3.0',
                content: [
                    'Caso o usuário acerte exatamente o placar da partida, irá ganhar 3 pontos.'
                ]
            }, {
                title: 'Acertar a circunstância do jogo',
                score: '+1.0',
                content: [
                    'Caso o usuário acerte se o jogo terminar em empate, vitória para o time mandante ou  vitória para o time visitante, irá ganhar 1 ponto.',
                    'Obs.: Essa regra se aplica apenas se o usuário não fez pontuação por acertar exatamente o placar.'
                ]
            }, {
                title: 'Acertar gols',
                score: '+0.5',
                content: [
                    'Para cada gol acertado, o usuário ganha 0.5 pontos.'
                ]
            }]
        }),
        methods: {
        },
    }
</script>
