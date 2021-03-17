<template>
    <div>
        <v-card class="rounded-bl-xl">
            <v-img
                class="white--text align-end"
                :src="score_rules_photo"
                gradient="to right, rgba(0,0,0,0.1), rgba(0,0,0,0.6)"
                max-height="300"
            >
                <v-card-title>Pontuação</v-card-title>
            </v-img>

            <v-card-text>
                <v-virtual-scroll
                    :items="rules"
                    :item-height="70"
                    height="200"
                >
                    <template v-slot:default="{ item }">
                        <v-card>
                                <v-card-subtitle class="d-flex justify-space-between">
                                <div>
                                    {{ item.title  }}
                                </div>
                                <div>
                                    {{ item.score }}
                                </div>
                            </v-card-subtitle>
                        </v-card>
                    </template>
                </v-virtual-scroll>
            </v-card-text>

            <v-card-actions>
                <v-spacer/>
                <inertia-link :href="route('gambler.score-rules')" style="text-decoration: none">
                    <v-btn color="green darken-1" text>
                        Regras
                        <v-icon class="ml-2">mdi-information-outline</v-icon>
                    </v-btn>
                </inertia-link>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data: () => ({
            score_rules_photo: window.location.origin + '/storage/geral/score-rules.jpg',
            rules: [{
                title: 'Acertar exatamente o placar',
                score: '+3.0',
            }, {
                title: 'Acertar a circunstância do jogo',
                score: '+1.0',
            }, {
                title: 'Acertar gols',
                score: '+0.5',
            }]
        }),
    }
</script>
