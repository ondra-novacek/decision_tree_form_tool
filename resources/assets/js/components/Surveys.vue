<template>
    <div>
        <input type="button" value="Show surveys" @click="getSurveys()">

        <survey v-for="survey in surveys" :key="survey.id" :surveyData="survey"></survey>
      
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import Survey from './survey.vue';

    export default {
        components: {
            'survey' : Survey
        },
        data() {
            return {
                surveys: [],
                // textInput: '',
            }
        }
        , methods: {
            getSurveys() {
                axios.get('/api/survey', {
                    params: {
                        user_id: this.$store.state.user.id
                    }
                }).then((r) => {
                    this.surveys = r.data;
                }).catch((e) => {
                    console.log(e);
                })
            },
            refresh() {
                this.getSurveys();
            }
        }
        , mounted() {
            // refresh
            EventBus.$on('refresh', () => {this.refresh()});
        }
    }
</script>
