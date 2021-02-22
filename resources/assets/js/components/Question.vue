<template>
    <div class="questionBox">
        <div class="form-style-5">
        <form @submit.prevent="updateQuestion()">
            <div class="form-group row">
                <label for="questionid" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="questionid" placeholder="" v-model="newQuestion">
                </div>
            </div>

            <div class="form-group row">
                <label for="parent" class="col-sm-2 col-form-label">Parent answer</label>
                <div class="col-sm-10">
                    <select v-if="parent.id != 'root'" class="form-control" id="parentId">
                        <option :value="parent.id">{{parent.text}}</option>
                        <option v-for="answer in possibleAnswers" v-bind:value="answer.id" :key="answer.id">{{answer.text}}</option>
                    </select>
                    <select class="form-control" id="root" v-else>
                        <option disabled selected>Root (cannot be changed)</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-sm btn-primary mb-2">Update</button>

        </form>
    </div>


    <div class="form-style-5">
        <form @submit.prevent="addAnswer()">
            <div class="form-group row">
                <label for="newAnswer" class="col-sm-2 col-form-label">New answer</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="newAnswer" placeholder="" v-model="newAnswer">
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mb-2">Add</button>

        </form>
    </div>


    <div class="form-style-5" v-if="answers.length > 0">
        <form @submit.prevent="updateAnswers()">
            <div class="form-group row" v-for="(answer, index) in answers">
                <label for="answer.id" class="col-sm-2 col-form-label">{{index+1}}. Answer</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" :id="answer.id" :value="answer.text">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-danger btn-sm" @click="deleteAnswer(answer)"><i class="fas fa-trash"></i></button>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mb-2">Update</button>

        </form>
    </div>

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
                parent: {},
                possibleAnswers: [],
                newQuestion: this.question.text,
                newAnswer: '',
                answers: []

            }
        }
        , methods: {
            updateQuestion() {

            },
            updateAnswers() {

            },
            getParentQuestion() {
                axios.get('/api/parentanswer/' + this.question.id)
                .then((r) => {
                    this.parent = r.data;
                    // console.log(r.data)
                })
                .catch((e) => {console.log(e)});
            },
            addAnswer() {
                axios.post('/api/answer', {
                    question_id: this.question.id,
                    survey_id: this.surveyData.id,
                    text: this.newAnswer
                })
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Answer created.');
                    EventBus.$emit('refresh-questions');
                    this.refresh();
                    this.newAnswer = '';
                })
                .catch((e) => {EventBus.$emit('showAlert', 'danger', 'Something went wrong.');});
            },
            getAnswers(){
                axios.get('/api/answers/' + this.question.id)
                .then((r) => {
                    this.answers = r.data;
                })
                .catch((e) => {console.log(e)});
            },
            refresh() {
                this.getAnswers();
            },
            deleteAnswer(answer){
                axios.delete('/api/answer/' + answer.id)
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Answer deleted.');
                    this.refresh();
                })
                .catch((e) => {console.log(e)});
            }
        }
        , mounted() {
            this.getParentQuestion();
            this.getAnswers();
        }
    }
</script>

<style scoped>
    .questionBox {
        padding: 2%;
    }

    .form-style-5{
        padding: 10px 20px;
        background:#e9ecef;
        margin: 10px auto;
        padding: 20px;
        background:#e9ecef;
        border-radius: 8px;
    }
</style>
