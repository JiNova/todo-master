<template>
  <div id="projects" class="container">
    <h2>Your projects!</h2>
    <table border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Title</th>
        <th>Due date</th>
        <th>Completion rate (in %)</th>
      </tr>

      <tr style="border-bottom:1pt solid black;" v-for="project in projects">
        <td>
          <input v-if = "project.edit_title==true" v-model = "project.title"
            v-focus
            @blur= "project.edit_title=false; changeTitle(project.project_id,project.title); $emit('update')"
            @keyup.enter = "project.edit_title=false; changeTitle(project.project_id,project.title); $emit('update')">
          <div v-else>
            <label @click="project.edit_title = true;">
              {{ project.title }}
              <span class="icon is-small"><i class="fas fa-pencil-alt"></i></span>
            </label>
          </div>
        </td>
        <td>{{ project.due_date | formatDate }}</td>
        <td>
          <input v-if = "project.edit_rate==true" v-model = "project.completion_rate"
              v-focus
              @blur= "project.edit_rate=false; changeRate(project.project_id,project.completion_rate); $emit('update')"
              @keyup.enter = "project.edit_rate=false; changeRate(project.project_id,project.completion_rate); $emit('update')">
          <div v-else>
            <label @click="project.edit_rate = true;">
              {{ project.completion_rate }}
              <span class="icon is-small"><i class="fas fa-pencil-alt"></i></span>
            </label>
          </div>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "projects",

  data () {
    return {
      projects: ""
    }
  },

  methods: {
    loadProjects: function() {

      axios.get('ajax.php', {
        params: {
          op: 'project_overview'
        }
      })
      .then((response) => {
        this.projects = response.data;
        
        for (var i = 0; i < this.projects.length; ++i) {
          this.$set( this.projects[i], "edit_title", "false" )
          this.$set( this.projects[i], "edit_rate", "false" )
        }
      })
      .catch((error) => {
        console.log(error);
      });
    },
    editProject: function(project) {
      this.editedProject = project;
    },
    changeTitle: function(pid,ptitle) {

      axios.get('update.php', {
        params: {
          op: 'project_change_title',
          id: pid,
          title: ptitle
        }
      })
      .then((response) => {
        this.loadProjects();
      })
      .catch((error) => {
        console.log(error);
      })
    },
    changeRate: function(pid,prate) {

      if (prate >= 0 && prate <= 100)
      {
        axios.get('update.php', {
          params: {
            op: 'project_change_completion',
            id: pid,
            rate: prate
          }
        })
        .then((response) => {
          
        })
        .catch((error) => {
          console.log(error);
        })
      }
      this.loadProjects();
    }
  },

  directives: {
    focus: {
      inserted (el) {
        el.focus()
      }
    }
  },

  mounted() {
    this.loadProjects();
  }
}
</script>

<style>

</style>
