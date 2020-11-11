<template>
    <div>
      {{question.text}}
      <button @click="deleteQuestion()">Delete</button>
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    // import NewSurvey from './NewSurvey.vue';

    export default {
        components: {
            // 'new-survey' : NewSurvey
        },
        props: {
            surveyData: Object,
            question: Object
        },
        data() {
            return {
                // neco: [],
                // textInput: '',
            }
        }
        , methods: {
            deleteQuestion(){
                axios.delete('/api/question/' + this.question.id)
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Question deleted.');
                    EventBus.$emit('refresh-questions');
                })
                .catch((e) => {console.log(e)});
            }
        }
        , mounted() {
            console.log('Component mounted.');
        }
    }
</script>
