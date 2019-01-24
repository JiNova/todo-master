import Vue from 'vue'
import moment from 'moment'
import App from './App.vue'

Vue.filter('formatDate', function (value) {

  if (value == null) {
    return 'None'
  } else if (value) {
    return moment(String(value)).format('MM/DD/YYYY hh:mm')
  }
})

Vue.mixin({
  methods: {
    isEmpty: function (obj) {
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
          return false
        }
      }
      return true
    }
  }
})

new Vue({
  el: '#app',
  render: h => h(App)
})
