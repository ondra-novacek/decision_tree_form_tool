<template>
    <div>
        <strong>Create new question</strong>
        <form @submit.prevent="addQuestion()">
            <label for="newQuestionText">Text</label><input type="text" name="" id="newQuestionText" v-model="newQuestionText">
            <label for="parentAnswer">Parent Answer</label>
            <select name="" id="parentAnswer" v-model="parentAnswer">
                <option value="0">Root</option>
                <option :value="answer.id" v-for="answer in possibleAnswers">{{answer.text}}</option>
            </select>
            <input type="submit" value="Add">
        </form>
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    // import NewSurvey from './NewSurvey.vue';

    export default {
        components: {
            // 'new-survey' : NewSurvey
        },
        data() {
            return {
                // neco: [],
                newQuestionText: '',
                possibleAnswers: [],
                newAnswer: '',
                parentAnswer: ''
            }
        },
        props: {
            surveyData: Object
        },
        methods: {
            getPossibleAnswers() {
                axios.get('/api/possibleanswers/' + this.surveyData.id)
                .then((r) => {this.possibleAnswers = r.data;})
                .catch((e) => {console.log(e)});
            },
            addQuestion() {
                axios.post('/api/question', {
                    survey_id: this.surveyData.id,
                    is_root: this.parentAnswer == 0,
                    parent_answer: this.parentAnswer,
                    text: this.newQuestionText
                })
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Question created.');
                    EventBus.$emit('refresh-questions');
                })
                .catch((e) => {EventBus.$emit('showAlert', 'danger', 'Something went wrong.');});
            }
        }
        , mounted() {
            this.getPossibleAnswers();
        }
    }
</script>
