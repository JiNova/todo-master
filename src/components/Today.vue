<template>
  <div id="today" class="container">
    <h2>This is your day:</h2>
    <p>List all tasks scheduled for today, if any exist:</p>
    <br>
    <p v-if="!tasks || isEmpty(tasks)">You are done for today! Nice :)</p>
    <table v-else border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Title</th>
        <th>Priority</th>
        <th>Project</th>
      </tr>

      <tr v-for="task in tasks">
        <td>{{ task.title }}</td>
        <td>{{ task.priority }}</td>
        <td>{{ task.project }}</td>
      </tr>
    </table>

    <br>
    <br>
    <p>Automatically suggest some tasks that might be worth doing today:</p>
    <br>
    <h3>Think you can handle more? Here are some tasks you might want to consider doing today:</h3>
    <p v-if="!tasks_schedule || isEmpty(tasks_schedule)">
      Looks like nothing is really worth your time at the moment! :)
    </p>
    <table v-else border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Title</th>
        <th>Due date</th>
        <th></th>
      </tr>

      <tr v-for="task_s in tasks_schedule">
        <td>{{ task_s.title }}</td>
        <td v-if="task_s.due_date != null">{{ task_s.due_date }}</td>
        <td v-else>none</td>
        <td>
          <button v-on:click="scheduleMe(task_s.task_id)">Schedule Me!</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "today",

  data () {
    return {
      tasks: "",
      tasks_schedule: ""
    }
  },

  methods: {
    today: function(){
      
      axios.get('ajax.php', {
        params: {
          op: 'today'
        }
      })
      .then((response) => {
        this.tasks=response.data;
      })
      .catch((error) => {
        console.log(error);
      })
    },
    loadTasksToSched: function() {

      axios.get('ajax.php', {
        params: {
          op: 'schedule_suggestion'
        }
      })
      .then((response) => {
        this.tasks_schedule = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
    scheduleMe: function(tid) {

      axios.get('update.php', {
        params: {
          op: 'task_schedule',
          id: tid
        }
      })
      .then((response) => {
        this.today();
        this.loadTasksToSched();
        this.$root.$emit('tasks_update', "");
      })
      .catch((error) => {
        console.log(error);
      })
    }
  },

  mounted() {

    this.today();
    this.loadTasksToSched();

    this.$root.$on('tasks_update', data => {
        this.today();
        this.loadTasksToSched();
    });
  }
};
</script>

<style>
</style>

