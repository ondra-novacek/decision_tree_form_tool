<template>
    <div>
        Create new survey:
        <form @submit.prevent="newSurvey()">
            <label for="survey-name">
                <input type="text" name="name" id="survey-name" v-model="surveyName">
            </label>
            <input type="submit" value="Create new">
        </form>

        <!-- <input type="button" value="test new sur" @click="test()"> -->
    </div>
</template>

<script>
    // import NewSurvey from './NewSurvey.vue';
    import EventBus from '../event-bus.js';

    export default {
        components: {
            // 'new-survey' : NewSurvey
        },
        data() {
            return {
                surveyName: ''
                // neco: [],
                // textInput: '',
            }
        }
        , methods: {
            newSurvey() {
                axios.post('/api/survey', {
                    name: this.surveyName,
                    user_id: this.$store.state.user.id
                }).then((r) => {
                    EventBus.$emit('showAlert', 'success', 'Survey succesfully created.');
                    EventBus.$emit('refresh');
                }).catch((e) => {
                    EventBus.$emit('showAlert', 'danger', 'Something went wrong.');
                    console.log(e);
                })
            },
            test() {
                // EventBus.$emit('showAlert', 'success', 'Survey succesfully created.');
            }
        }
        , mounted() {
            
        }
    }
</script>
