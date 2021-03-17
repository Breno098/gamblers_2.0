<template>
    <div>
        <v-card class="rounded-br-xl">
            <v-img
                class="white--text align-end"
                :src="score_ranking_photo"
                gradient="to right, rgba(0,0,0,0.1), rgba(0,0,0,0.6)"
                max-height="300"
            >
                <v-card-title>Ranking</v-card-title>
            </v-img>

            <v-card-text>
                <v-virtual-scroll
                    :items="users_scores"
                    :item-height="70"
                    height="200"
                >
                    <template v-slot:default="{ item }">
                        <v-card>
                                <v-card-subtitle class="d-flex justify-space-between">
                                <div>
                                    {{ item.username  }}
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
                        Ranking
                        <v-icon class="ml-2">mdi-poll</v-icon>
                    </v-btn>
                </inertia-link>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    export default {
        props: {
            users_scores: Array
        },
        data: () => ({
            score_ranking_photo: window.location.origin + '/storage/geral/ranking.png',
        }),
        methods: {

        }
    }
</script>
