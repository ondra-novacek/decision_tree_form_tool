<template>
    <div>
        <!-- alerts -->
        <div class="alert alert-success" role="alert" v-if="success">{{success}}</div>
        <div class="alert alert-danger" role="alert" v-if="danger">{{danger}}</div>
        <div class="alert alert-info" role="alert" v-if="info">{{info}}</div>

        <new-survey></new-survey>
        <br>
        <surveys></surveys>

        <!-- <input type="button" value="test main" @click='test()'> -->
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import NewSurvey from './NewSurvey.vue';
    import Surveys from './Surveys.vue';

    export default {
        components: {
            'new-survey' : NewSurvey,
            'surveys' : Surveys,
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
                info: ''
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
                
            },
            test() {
                console.log(this.$store.state.user);
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
        }
    }
</script>
