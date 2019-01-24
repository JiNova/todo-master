<template>
  <div id="Search" class="container">
    <!--<h2>Search for tasks (someday):</h2>-->
    <br>
    <br>
    <h3>Tasks in Eisenhower Matrix top left field:</h3>
    <table border="1" width="80%" style="border-collapse: collapse;">
      <tr>
        <th>Title</th>
      </tr>

      <tr v-for="task in eisenhower">
        <td>{{ task.title }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "search",

  data() {
    return {
      eisenhower: ""
    }
  },

  methods: {
    loadEisenhower: function() {

      axios.get('ajax.php', {
        params: {
          op: 'eisenhower_top_left'
        }
      })
      .then((response) => {
        this.eisenhower = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    }
  },

  mounted() {
    this.loadEisenhower();
  }
};
</script>

<style>
</style>


