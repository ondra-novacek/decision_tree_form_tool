<template>
    <div>
       
        <!-- <strong>Create new question</strong> -->
        <form @submit.prevent="addQuestion()">
            <strong>New question:</strong>
            <div class="form-row align-items-center">

                <div class="col-auto">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Question</div>
                      </div>
                      <input type="text" class="form-control" name="" id="newQuestionText" v-model="newQuestionText" placeholder="Enter text here..">
                    </div>
                </div>
    
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Parent answer</div>
                        </div>
                        <select name="" class="form-control" id="parentAnswer" v-model="parentAnswer">
                            <option value="0" :disabled="!rootAvailable">Root</option>
                            <option :value="answer.id" v-for="answer in possibleAnswers">{{answer.text}}</option>
                        </select>
                    </div>
                </div>
                <br><br><br><br>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                </div>
            </div>
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
                parentAnswer: '',
                id: this.$route.params['id'],
            }
        },
        props: {
            surveyData: Object,
            rootAvailable: Boolean
        },
        methods: {
            getPossibleAnswers() {
                axios.get('/api/possibleanswers/' + this.id)
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
                    if (r.data) {
                        EventBus.$emit('showAlert', 'danger', r.data);
                    } else {
                        EventBus.$emit('showAlert', 'success', 'Question created.');
                        EventBus.$emit('refresh-questions');
                        this.newQuestionText = '';
                    }
                })
                .catch((e) => {EventBus.$emit('showAlert', 'danger', 'Something went wrong.');});
            },
            refresh() {
                this.getPossibleAnswers();
            }
        }
        , mounted() {
            this.getPossibleAnswers();
            // refresh
            EventBus.$on('refresh-questions', () => {this.refresh()});
        }
    }
</script>
