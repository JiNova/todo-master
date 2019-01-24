<template>
  <div id="app" class="container">
    <tabs>
        <tab name="All Tasks">
            <AllTasks></AllTasks>
        </tab>

        <tab name="Today" :selected="true">
            <Today></Today>
        </tab>

        <tab name="Projects">
            <Projects></Projects>
        </tab>

        <tab name="Priorities">
            <Priorities></Priorities>
        </tab>

        <tab name="Tags">
            <Tags></Tags>
        </tab>

        <tab name="Search">
          <Search></Search>
        </tab>

        <tab name="Data Warehouse">
          <Data></Data>
        </tab>

    </tabs>
  </div>
</template>

<script>

import Tabs from './components/Tabs.vue';
import Tab from './components/Tab.vue'; 
import AllTasks from './components/AllTasks.vue';
import Today from './components/Today.vue';
import Priorities from './components/Priorities.vue';
import Tags from './components/Tags.vue';
import Search from './components/Search.vue';
import Projects from './components/Projects.vue';
import Data from './components/DataWarehouse.vue';

export default {
  name: 'app',

  components: {Tabs, Tab, AllTasks, Today, Priorities, Tags, Search, Projects, Data},

  data () {
    return {
    };
  },

  methods: {},

  mounted() {}
}
</script>

<style>
  body { padding-top: 40px; }
</style>
