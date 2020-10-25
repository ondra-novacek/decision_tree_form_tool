<template>
    <div class="container">
      main
      <test></test>
      
      <form @submit.prevent="checkForm()" action="/" method="get"></form>
      <label for="testinput">Test </label>
      <input type="text" v-model='textInput'>
      <input type="submit" value="send" @click='checkForm'>
    </div>
</template>

<script>
    import Test from './Test.vue';

    export default {
        components: {
            Test
        },
        data() {
            return {
                neco: [],
                textInput: '',
            }
        }
        , methods: {
            checkForm() {
                console.log(this.textInput);
                axios
                    .get('/api/test')
                    .then(response => (console.log(response.data)));
            }
        }
        , mounted() {
            console.log('Component mounted.')
        }
    }
</script>
