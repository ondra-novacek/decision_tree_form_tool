<template>
    <div>
        <button @click="collapse()" class="btn btn-secondary">Toggle all</button>
        <br><br>
        <ul>
            <tree-item
                class="item"
                :item="tree"
                :openDefault="openDefault"
            ></tree-item>
        </ul>
    </div>
</template>

<script>
    import EventBus from '../event-bus.js';
    import TreeItem from './TreeItem.vue';

    export default {
        components: {
            'tree-item' : TreeItem
        },
        props: {
            surveyData: Object
        },
        data() {
            return {
                tree: {},
                openDefault: false,
                collapsed: true
            }
        }
        , methods: {
            refresh(){
                this.getDecisionTree();
            },
            getDecisionTree() {
                axios.get('/api/decisiontree/' + this.$route.params['id'])
                .then((r) => {
                    this.tree = r.data;
                }).catch((e) => {
                    console.log(e);
                });
            },
            collapse(){
                EventBus.$emit('collapse', this.collapsed);
                this.collapsed = !this.collapsed;
            }
        }
        , mounted() {
            this.getDecisionTree();
            // refresh
            EventBus.$on('refresh', () => {this.refresh()});
            // dt refresh
            EventBus.$on('refresh-dt', () => {this.refresh()});
        }
    }
</script>

<style scoped>
    .item {
        cursor: pointer;
    }
    ul {
        padding-left: 1em;
        line-height: 1.5em;
        list-style-type: disc;
    }
</style>
