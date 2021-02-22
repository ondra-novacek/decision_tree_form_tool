<template>
    <li>
        <div
          :class="{bold: item.type == 'q'}"
          @click="toggle"
          v-if="(typeof item !== 'undefined')"
          >
          <span v-if="item.data"> {{item.type}} - {{item.data.text}} </span>
          <span v-if="isExpandable">[{{ isOpen ? '-' : '+' }}]</span><span v-else></span>
        </div>

        <ul v-show="isOpen" v-if="isExpandable">
          <tree-item
            class="item"
            v-for="(child, index) in item.children"
            :key="index"
            :item="child"
            :openDefault="openDefault"
          ></tree-item>
        </ul>
    </li>
</template>

<script>
    import EventBus from '../event-bus.js';
    import TreeItem from './TreeItem.vue';

    export default {
        props: {
          item: Object,
          openDefault: Boolean
        },
        data: function () {
          return {
            isOpen: this.openDefault
          };
        },
        computed: {
          isExpandable: function () {
            return this.item && this.item.children && this.item.children.length;
          }
        },
        methods: {
          toggle: function () {
            if (this.isExpandable) {
              this.isOpen = !this.isOpen;
            }
          },
          collapse: function (collapsed) {
            this.isOpen = collapsed;
          }
        },
        components: {
            // 'new-survey' : NewSurvey
            'tree-item' : TreeItem
        }
        , mounted() {
            // alert
            EventBus.$on('collapse', (collapsed) => {this.collapse(collapsed)});
            // refresh
            // EventBus.$on('refresh', () => {this.refresh()});
        }
    }
</script>

<style scoped>
    .item {
        cursor: pointer;
    }
    .bold {
        font-weight: bold;
    }
    ul {
        padding-left: 1.5em;
        line-height: 1.5em;
        list-style-type: disc;
    }
</style>
