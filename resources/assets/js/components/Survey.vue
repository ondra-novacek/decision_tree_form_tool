<template>
<div>
     <!-- alerts -->
     <div class="alert alert-success" role="alert" v-if="success">{{success}}</div>
     <div class="alert alert-danger" role="alert" v-if="danger">{{danger}}</div>
     <div class="alert alert-info" role="alert" v-if="info">{{info}}</div>

    <main>
    <div class="container">
       
    
            <input id="tab1" type="radio" name="tabs" checked>
            <label for="tab1">Create</label>
        
            <input id="tab2" type="radio" name="tabs">
            <label for="tab2" @click="updateDT()">Show</label>
        
            <input id="tab3" type="radio" name="tabs">
            <label for="tab3" @click="updateDT()">API</label>


        
            <section id="content1">
                <new-question :surveyData="survey" :rootAvailable="rootAvailable"></new-question>
                
                <table class="table">
                    <strong>List of questions:</strong>
                    <tbody>
                        <template v-for="question in questions">
                        <tr @click="rowClicked(question.id)" class="hovercolorchange" v-bind:class="{selected: rowShow[question.id]}">
                            <td >
                                <span > {{question.text}} <span v-if="question.isRoot"><strong>(root)</strong></span> </span>
                                <button class="btn btn-sm btn-danger" @click.stop="rowClicked" @click="deleteQuestion(question)" style="float: right">Delete</button>
                            </td>
                        </tr>
                        <tr v-if= "rowShow[question.id]" class="not-active" :class="{selectedTwo: rowShow[question.id]}">
                            <td :class="'row-' + question.id">
                                <question :surveyData="survey" :question="question"></question>
                            </td>
                        </tr>
                        </template>
                    </tbody>
                </table>
                
        
        
                <!-- tree -->
                 <!-- <div v-for="branch in tree"></div> -->
            </section>
        
            <section id="content2">
                <decision-tree :surveyData="survey"></decision-tree>
            </section>

            <section id="content3">
                <api></api>
            </section>
    </div>
    </main>
</div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import NewQuestion from './NewQuestion.vue';
    import Question from './Question.vue';
    import DecisionTree from './DecisionTree.vue';
    import Api from './Api.vue';

    export default {
        components: {
            'new-question' : NewQuestion,
            'question' : Question,
            'decision-tree' : DecisionTree,
            'api' : Api,
        },
        props: {
            surveyData: Object
        },
        data() {
            return {
                questions: [],
                newQuestionText: '',
                showNew: false,
                id: this.$route.params['id'],
                survey: {},
                success: '',
                danger: '',
                info: '',
                rowShow: [],
                rootAvailable: true
            }
        }
        , methods: {
            getSurvey() {
                axios.get('/api/survey/' + this.id)
                .then((r) => {this.survey = r.data;})
                .catch((e) => {console.log(e)});
            },
            getQuestions() {
                axios.get('/api/question', {
                    params: {
                        'survey_id': this.id
                    }
                })
                .then((r) => {this.questions = r.data})
                .catch((e) => {console.log(e)});
            },
            refresh(){
                this.getQuestions();
            },
            showNewForm(){
                this.showNew = this.showNew ? false : true;
            },
            updateDT() {
                EventBus.$emit('refresh-dt');
            },
            handleAlert(type, message) {
                let context = this;
                switch(type) {
                    case 'success':
                        this.success = message;
                        this.timeout(type);
                        break;
                    case 'danger':
                        this.danger = message;
                        this.timeout(type);
                        break;
                    default:
                        this.info = message;
                        this.timeout(type);
                }
            },
            timeout(el) {
                let context = this;
                setTimeout(() => {eval('context.' + el + ' = ""')}, 4000);
            },
            fillStateRowShow() {
                this.questions.foreach(q => {
                    this.rowShow[q.id] = false;
                });
            },
            rowClicked(index) {
                this.$set(this.rowShow, index, !this.rowShow[index]);
                // document.querySelector('.row-' + index).classList.toggle('activeRow');
            },
            deleteQuestion(question){
                axios.delete('/api/question/' + question.id)
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Question deleted.');
                    EventBus.$emit('refresh-questions');
                })
                .catch((e) => {console.log(e)});
            }
        }
        , mounted() {
            this.getSurvey();
            this.getQuestions();
            // refresh
            EventBus.$on('refresh-questions', () => {this.refresh()});
            // alert
            EventBus.$on('showAlert', (type, message) => {this.handleAlert(type, message)});
        }
    }
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    /* *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}html,body{height:100vh;}body{display:flex;align-items:center;justify-content:center;padding:40px;font:14px/1.5 'Open Sans',sans-serif;color:#345;background:#f0f2f4;} */
    
    p:not(:last-child) {
      margin: 0 0 20px;
    }
    
    main {
      max-width: 1200px;
      padding: 40px;
      border: 1px solid rgba(0,0,0,.2);
      background: #fff;
      box-shadow: 0 1px 3px rgba(0,0,0,.1);
      margin: auto;
      min-height: 900px;
    }
    
    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #abc;
    }
    
    input {
      display: none;
    }
    
    label {
      display: inline-block;
      margin: 0 0 -1px;
      padding: 15px 25px;
      font-weight: 600;
      text-align: center;
      color: rgb(160, 165, 163);
      border: 1px solid transparent;
    }
    
    label:before {
      font-family: fontawesome;
      font-weight: normal;
      margin-right: 10px;
    }
    
    /* label[for*='1']:before { content: '\f1cb'; } */
    /* label[for*='2']:before { content: '\f17d'; } */
    /* label[for*='3']:before { content: '\f16c'; } */
    /* label[for*='4']:before { content: '\f171'; } */
    
    label:hover {
      color: #789;
      cursor: pointer;
    }
    
    input:checked + label {
      color: rgba(29, 29, 29, 0.822);
      border: 1px solid #abc;
      border-top: 2px solid rgba(29, 29, 29, 0.822);
      border-bottom: 1px solid #fff;
    }
    
    #tab1:checked ~ #content1,
    #tab2:checked ~ #content2,
    #tab3:checked ~ #content3,
    #tab4:checked ~ #content4,
    #tab5:checked ~ #content5 {
      display: block;
    }
    
    @media screen and (max-width: 800px) {
      label {
        font-size: 0;
      }
      label:before {
        margin: 0;
        font-size: 18px;
      }
    }
    
    @media screen and (max-width: 500px) {
      label {
        padding: 15px;
      }
    }

    .tab-slider--nav{
        width: 100%;
        float: left;
        margin-bottom: 20px;
    }
    .tab-slider--tabs{
        display: block;
        float: left;
        margin: 0;
        padding: 0;
        list-style: none;
        position: relative;
        border-radius: 35px;
        overflow: hidden;
        background: #fff;
        height: 35px;
        user-select: none; 
    }
    .tab-slider--trigger {
        font-size: 12px;
        line-height: 1;
        font-weight: bold;
        color: #345F90;
        text-transform: uppercase;
        text-align: center;
        padding: 11px 20px;
        position: relative;
        z-index: 2;
        cursor: pointer;
        display: inline-block;
        user-select: none; 
    }
    .uppercase{
        text-transform: uppercase;
    }
    a{
        text-decoration: none;
        color: #2BBBAD;
    }
    .card, .carddeck, .cardbody{
        box-shadow: none !important;
    }
    .selected {
        background-color: #c4bdbdb6;   
        color: black; 
    }
    .hovercolorchange:hover{
        cursor: pointer;
        background-color: #c4bdbdb6;
    }
    tr.not-active td {
        padding: 0px;
        border-bottom: 0px solid black;
        transition: border-bottom 0.3s;
    }
    tr.selectedTwo td {
        border-bottom: 1px solid black;
    }

</style>
