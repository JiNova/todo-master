<template>
  <div id="priorities">
    <h2>Your tasks by priorities:</h2>
    <p>Loads the priorities from the database and displays them as a dropdown</p>
    <select v-model="selected" @change="priority_list">
      <option disabled value>Please select one</option>
      <option v-for="priority in priorities" :value="priority.priority_id">{{ priority.name }}</option>
    </select>
    <span>Selected: {{ selected }}</span>

    <br>
    <br>
    <p>Loads the task with the selected priority and displays them (if any:)</p>
    <br>
    <p v-if="!tasks || isEmpty(tasks)">No tasks found</p>
    <!-- List records -->
    <table v-else border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Title</th>
      </tr>

      <tr v-for="task in tasks">
        <td>{{ task.title }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "priorities",
  
  data () {
    return {
      selected: "",
      tasks: "",
      priorities: ""
    }
  },

  methods: {
    priority_list: function(){

      axios.get('ajax.php', {
        params: {
          op: 'priority_list',
          priority: this.selected
        }
      })
      .then((response) => {
        this.tasks=response.data;
      })
      .catch((errror) => {
        console.log(error);
      });
    },
    load_priorities: function() {

      axios.get('ajax.php', {
        params: {
          op: 'priorities_display'
        }
      })
      .then((response) => {
        this.priorities = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
  },

  mounted () {
    this.load_priorities();
  }
};
</script>

<style>
</style>

