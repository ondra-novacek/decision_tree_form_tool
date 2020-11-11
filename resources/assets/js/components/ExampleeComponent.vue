<template>
    <div>
      
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
            // surveyData: Object
        },
        data() {
            return {
                // neco: [],
                // textInput: '',
            }
        }
        , methods: {
            refresh(){

            }
        }
        , mounted() {
            // refresh
            EventBus.$on('refresh', () => {this.refresh()});
            // alert
            // EventBus.$on('showAlert', (type, message) => {this.handleAlert(type, message)});
        }
    }
</script>
