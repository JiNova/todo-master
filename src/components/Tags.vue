<template>
  <div id="tags" class="container">
    <h2>Your tasks by tags:</h2>
    <input v-model="tag_search" placeholder="Search for tasks with tag" @keyup="taskByTag">
    <p>Showing tasks with tag: {{ tag_search }}</p>
    <p v-if="!tasks || isEmpty(tasks)">No tasks found!</p>
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
  name: "tags",
  
  data() {
    return {
      tasks: "",
      tag_search: ""
    }
  },

  methods: {
    taskByTag: function() {

      if (this.tag_search.length < 3)
      {
        this.tasks = "";
        return;
      }

      axios.get('ajax.php', {
        params: {
          op: 'tasks_by_tags',
          tag_search: this.tag_search
        }
      })
      .then((response) => {
        this.tasks = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    }
  }
};
</script>

<style>
</style>
