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
                        <v-card-title>Pontuações</v-card-title>
                    </v-img>

                    <v-card-text>
                        <v-card v-for="(report_item, index) in reports" :key="index">
                            <v-card-subtitle class="d-flex justify-start mt-4">
                                <div>
                                    {{ report_item.stage  }}
                                </div>
                                <div>
                                    {{ report_item.score }}
                                </div>
                            </v-card-subtitle>
                            <v-card-text v-for="(report, index) in report_item.report" :key="index">
                                {{ report }}
                            </v-card-text>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';

    export default {
        components: {
            AppLayout,
        },
        props: {
            reports: Array
        },
        data: () => ({
            score_rules_photo: window.location.origin + '/storage/geral/score-rules.jpg',
        }),
    }
</script>
