<template>
  <div id="all_tasks" class="container">
    <h2>All your undone tasks:</h2>

    <!-- List records -->
    <p v-if="!tasks || isEmpty(tasks)">No tasks found!</p>
    <table v-else border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Ops</th>
        <th>Title</th>
        <th>Priority</th>
        <th>Project</th>
      </tr>

      <tr v-for="task in tasks">
        <td>
          <span class="icon is-small" @click="taskDone(task.task_id)"><i class="fas fa-check"></i></span>
          <span class="icon is-small" @click="taskDelete(task.task_id)"><i class="fas fa-trash-alt"></i></span>
        </td>
        <td>
          <input v-if = "task.edit_title==true" v-model = "task.title"
            v-focus
            @blur= "task.edit_title=false; changeTitle(task.task_id,task.title); $emit('update')"
            @keyup.enter = "task.edit_title=false; changeTitle(task.task_id,task.title); $emit('update')">
          <div v-else>
            <label @click="task.edit_title = true;">
              {{ task.title }}
              <span class="icon is-small"><i class="fas fa-pencil-alt"></i></span>
            </label>
          </div>
        </td>
        <td>{{ task.priority }}</td>
        <td>
          <select v-if = "task.edit_project==true" v-model="sel_project"
            @blur="task.edit_project=false;"
            @change="task.edit_project=false; changeProject(task.task_id)">
            <option value="null">None</option>
            <option v-for="project in projects" :selected="project.project_id == task.project_id" :value="project.project_id">{{ project.title }}</option>
          </select>
          <div v-else>
            <label @click="task.edit_project = true;">
              {{ task.project_title }}
              <span class="icon is-small"><i class="fas fa-pencil-alt"></i></span>
            </label>
          </div>
        </td>
      </tr>
    </table>

    <br>
    <br>
    <br>
    <h2>How about anew task?</h2>
    <form method="GET" action="add.php" @submit.prevent="addTask">
      <div class="control">
        <label for="title" class="label">Task Title:</label>
        <input type="text" id="task_title" name="title" class="input" v-model="new_title">
      </div>
      <div class="control">
        <label for="priority" class="label">Priority:</label>
        <select id="task_priority" name="priority" v-model="sel_prio_new">
          <option disabled value>Please select one</option>
          <option v-for="priority in priorities" :value="priority.priority_id">{{ priority.name }}</option>
        </select>
      </div>
      <div class="control">
        <label for="project" class="label">Project:</label>
        <select id="task_project" v-model="sel_project_new">
            <option selected="selected" value="null">None</option>
            <option v-for="project in projects" :value="project.project_id">{{ project.title }}</option>
        </select>
      </div>
      <input type="submit" class="submit"  value="Submit">
     </form>
    
  </div>
</template>

<script>
export default {

  name: "inbox",
  
  data() {
    return {
      tasks: "",
      sel_project: "",
      sel_project_new: "",
      sel_prio: "",
      sel_prio_new: "",
      projects: "",
      new_title: "",
      db_request: true,
      priorities: ""
    };
  },

  methods: {
    allRecords: function(){

      axios.get('ajax.php')
      .then((response) => {
        this.tasks = response.data;
        for (var i = 0; i < this.tasks.length; ++i) {
          this.$set( this.tasks[i], "edit_title", "false" )
          this.$set( this.tasks[i], "edit_project", "false" )
        }
      })
      .catch((error) => {
        console.log(error);
      });
    },
    updateTask: function(tid) {

      axios.get('ajax.php', {
        params: {
          id: tid
        }
      })
      .then((response) => {
        const currentIndex = this.tasks.findIndex(t => t.task_id === tid);
        this.tasks.splice(currentIndex, 1, response.data);
      })
      .catch((error) => {
        console.log(error);
        return null;
      })
    },
    changeTitle: function(tid,ttitle) {

      axios.get('update.php', {
        params: {
          op: 'task_change_title',
          id: tid,
          title: ttitle
        }
      })
      .then((response) => {
         this.allRecords();
         this.$root.$emit('tasks_update', "");
      })
      .catch((error) => {
        console.log(error);
      })
    },
    loadProjects: function() {

      axios.get('ajax.php', {
        params: {
          op: 'project_overview'
        }
      })
      .then((response) => {
        this.projects = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
    changeProject: function(tid) {
      
      axios.get('update.php', {
        params: {
          op: 'task_change_project',
          id: tid,
          pid: this.sel_project
        }
      })
      .then((response) => {
        this.allRecords();
        this.$root.$emit('tasks_update', "");
      })
      .catch((error) => {
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
    addTask : function() {
      axios.get("add.php", {
        params: {
          new_title: this.new_title,
          prio_id: this.sel_prio_new,
          project_id: this.sel_project_new
        }
      })
      .then((response) => {
        this.new_title = "";
        this.sel_prio_new = "";
        this.sel_project_new = "";
        this.allRecords();
      })
      .catch((error) => {
        console.log(error);
      });
    },
    taskDone : function(tid) {
      axios.get("update.php", {
        params: {
          op: 'task_done',
          id: tid
        }
      })
      .then((response) => {
        this.allRecords()
        this.$root.$emit('tasks_update', "");
      })
      .catch((error) => {
        console.log(error);
      })
    },
    taskDelete: function(tid) {
      axios.get("delete.php", {
        params: {
          op: 'task_delete',
          id: tid
        }
      })
      .then((response) => {
        this.allRecords()
        this.$root.$emit('tasks_update', "");
      })
    }
  },

  directives: {
    focus: {
      inserted (el) {
        el.focus()
      }
    }
  },

  mounted () {
    this.allRecords();
    this.loadProjects();
    this.load_priorities();

    this.$root.$on('tasks_update', data => {
        this.allRecords();
    });
  }
};
</script>

<style>
</style>


