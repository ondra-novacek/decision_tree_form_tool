<template>
    <div class="container">
        <h3>{{surveyData.name}}</h3>
        <button @click="deleteSurvey()">Delete</button>
        <br>

        <new-question :surveyData="surveyData"></new-question>
        
        <strong>List of questions</strong>
        <question v-for="question in questions" :surveyData="surveyData" :question="question"></question>
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import NewQuestion from './NewQuestion.vue';
    import Question from './Question.vue';

    export default {
        components: {
            'new-question' : NewQuestion,
            'question' : Question
        },
        props: {
            surveyData: Object
        },
        data() {
            return {
                questions: [],
                newQuestionText: '',
            }
        }
        , methods: {
            getQuestions() {
                axios.get('/api/question', {
                    params: {
                        'survey_id': this.surveyData.id
                    }
                })
                .then((r) => {this.questions = r.data})
                .catch((e) => {console.log(e)});
            },
            refresh(){
                this.getQuestions();
            }
        }
        , mounted() {
            this.getQuestions();
            // refresh
            EventBus.$on('refresh-questions', () => {this.refresh()});
        }
    }
</script>
