<template>
    <div>
        <form @submit.prevent="newSurvey()">
            <div class="form-row align-items-center">
                <div class="col-auto">
                <input type="text" class="form-control mb-2"  name="name" id="survey-name" v-model="surveyName" placeholder="Enter survey name...">
                </div>

                <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Add</button>
                </div>
            </div>
        </form>
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
                    this.surveyName = '';
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
