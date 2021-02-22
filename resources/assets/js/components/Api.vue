<template>
    <div>
        <div class="card">
            <h5 class="card-header">API Link</h5>
            <div class="card-body">
                <!-- <h5 class="card-title">Special title treatment</h5> -->
                <p class="card-text" id="apilink">{{link}}</p>
                <!-- <button class="btn btn-primary btn-sm" @click="copyLink()">Copy</button> -->
                <div class="tooltip-cust">
                    <button class="btn btn-sm btn-primary" @mouseout="outFunc()" @click="copyLink()" >
                      <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                      Copy link
                    </button>
                </div>
                    
            </div>
        </div>
        <br><br>

        <div class="card">
            <h5 class="card-header">Raw data</h5>
            <div class="card-body">
              <!-- <h5 class="card-title">Special title treatment</h5> -->
              <p class="card-text">{{data}}</p>
              <!-- <a href="#" class="btn btn-primary btn-sm">Copy</a> -->
            </div>
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
            // surveyData: Object
        },
        data() {
            return {
                data: {},
                link: ''
                // textInput: '',
            }
        }
        , methods: {
            refresh(){
                this.getSurveyData();
                this.getLink();
            },
            copyLink() {
                let element = document.getElementById("apilink");
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();
                var tooltip = document.getElementById("myTooltip");
                tooltip.innerHTML = "Copied!";
            },
            outFunc() {
                let tooltip = document.getElementById("myTooltip");
                tooltip.innerHTML = "Copy to clipboard";
            },
            getSurveyData() {
                axios.get('/api/surveydata/' + this.$route.params['id'])
                .then((r) => {
                    this.data = r.data;
                }).catch((e) => {
                    console.log(e);
                });
            },
            getLink() {
                let getUrl = window.location;
                let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                this.link = baseUrl + 'api/surveydata/' + this.$route.params['id'];
            }
        }
        , mounted() {
            this.refresh();
            EventBus.$on('refresh-dt', () => {this.refresh()});
        }
    }
</script>

<style scoped>
    .tooltip-cust {
  position: relative;
  display: inline-block;
}

.tooltip-cust .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip-cust .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip-cust:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>