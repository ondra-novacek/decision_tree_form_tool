<template>
<div>
    <!-- alerts -->
    <div class="alert alert-success" role="alert" v-if="success">{{success}}</div>
    <div class="alert alert-danger" role="alert" v-if="danger">{{danger}}</div>
    <div class="alert alert-info" role="alert" v-if="info">{{info}}</div>

    <div class="container">     
        <br>
        <div class="row">
            <new-survey></new-survey>
        </div>
        
        <div class="row">
            <div class="card" style="width: 18rem;" v-for="survey in surveys">
                <img src="/img/survey.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">{{survey.name}}</h4>
                    <p class="card-text">
                        <strong>Last updated:</strong> <span>{{survey.updated_at.split(' ')[0].split('-')[2]}}. {{survey.updated_at.split(' ')[0].split('-')[1]}}. {{survey.updated_at.split(' ')[0].split('-')[0]}}</span> 
                    </p>
                    <router-link :to="{name: 'edit', params: {id: survey.id}}">
                        <button class="btn btn-primary btn-sm">Edit</button>
                    </router-link>
                    <button @click="deleteSurvey(survey.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import NewSurvey from './NewSurvey.vue';

    export default {
        components: {
            'new-survey' : NewSurvey,
        },
        props: {
            user: Object
        },
        data() {
            return {
                neco: [],
                textInput: '',
                loggedUser: '',
                success: '',
                danger: '',
                info: '',
                surveys: [],
            }
        }
        , 
        methods: {
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
            refresh() {
                this.getSurveys();
            },
            test() {
                console.log(this.$store.state.user);
            },
            getSurveys() {
                axios.get('/api/survey', {
                    params: {
                        user_id: this.user.id
                    }
                }).then((r) => {
                    this.surveys = r.data;
                }).catch((e) => {
                    console.log(e);
                })
            },
            deleteSurvey(id) {
                axios.delete('/api/survey/' + id)
                .then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Survey deleted.');
                    this.refresh();
                })
                .catch((e) => {console.log(e)});
            }
        }
        , mounted() {
            if( typeof(this.user) == "object" ) {
                this.$store.commit("setUser", this.user);
            }

            // alert
            EventBus.$on('showAlert', (type, message) => {this.handleAlert(type, message)});

            // refresh
            EventBus.$on('refresh', () => {this.refresh()});
            this.getSurveys();
        }
    }
</script>

<style scoped>
    .card {
        margin-right: 1%;
    }

</style>
