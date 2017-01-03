<template>
  <div>
    <spinner :show="loading"></spinner>
    <div class="hero-body">
      <div class="container">
        <div class="is-pulled-left">
          <h1 class="title">
            Users
          </h1>
          <h2 class="subtitle">
            Add, Edit and Delete Users
          </h2>
        </div>
        <div class="is-pulled-right">
          <button @click="openForm" class="button is-primary is-outlined">
            <span class="icon">
              <i class="fa fa-plus"></i>
            </span>
            <span>Add User</span>
          </button>
        </div>
      </div>
    </div>
    <div :class="{'is-active': form}" class="modal">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Modal title</p>
          <button @click="closeForm" class="delete"></button>
        </header>
        <section class="modal-card-body">

          <form id="form" action="#" @submit.prevent="" method="POST">
            <div class="control is-grouped">
            <img v-if="edit" v-bind:src="avatar" alt="" />
            <p class="control has-icon is-expanded">
              <input v-model="newUser.name" class="input" v-bind:class="{ 'is-danger': !validation.name }" type="name" placeholder="Name">
              <i class="fa fa-user"></i>
              <span v-show="!validation.name" class="help is-danger">Type Correct name</span>
            </p>
          </div>
            <div class="control is-grouped">
              <p class="control has-icon is-expanded">
                <input v-model="newUser.email"  class="input" v-bind:class="{ 'is-danger': !validation.email }" type="email" placeholder="Email">
                <i class="fa fa-envelope"></i>
                <span v-show="!validation.email" class="help is-danger">Type Correct Email</span>
              </p>
              <p class="control select">
                  <select v-model="newUser.admin">
                    <option value="" hidden>Choose Role</option>
                    <option v-for="role in roles" v-bind:value="role.id">{{role.name}}</option>
                  </select>
                  <span v-show="!validation.admin" class="help is-danger">Required</span>
              </p>
            </div>
            <div class="control is-grouped">
              <p class="control has-icon is-expanded">
                <input v-model="newUser.password" class="input" type="password" placeholder="Password">
                <i class="fa fa-key"></i>
              </p>

              <p class="control has-icon is-expanded">
                <input v-model="newUser.rpassword" class="input" type="password" placeholder="Password">
                <i class="fa fa-key"></i>
                <span v-show="!validation.password" class="help is-danger">Don't match or less than 6 characters</span>
              </p>

            </div>

          </form>

        </section>
        <footer class="modal-card-foot">
          <button :disabled="!isValid" v-if="!edit" class="button is-primary" @click="AddNewUser" >Save</button>
          <button :disabled="!isValid" v-if="edit" class="button is-success" @click="EditUser">Edit</button>
          <a @click="closeForm" class="button">Cancel</a>
        </footer>
      </div>
    </div>

    <hr>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <form action="">
              <p class="control has-icon has-addons">
                <input class="input "  type="text" v-model="searchKey" placeholder="search in names" />
                <i class="fa fa-search"></i>
              </p>
            </form>
          </th>
          <th>Email</th>
          <th>Privilage</th>
          <th>created_at</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in filteredUsers">
          <th><input type="checkbox" class="control" v-model="deleted_user" :value="user.id"></th>
          <th>{{user.name}}</th>
          <th>{{user.email}}</th>
          <th>{{NameRole(user.admin)}}</th>
          <th>{{user.created_at}}</th>
          <th>
            <button class="button is-small is-primary" @click="ShowUser(user.id)">
              <span class="icon is-small"><i class="fa fa-edit"></i></span>
              <span>Edit</span>
            </button>
            <button class="button is-small is-danger" @click="RemoveUser(user.id)">
              <span class="icon is-small"><i class="fa fa-remove"></i></span>
              <span>Delete</span>
            </button>
          </th>
        </tr>
      </tbody>
    </table>
    <button :disabled="!deleted_user" class="button is-danger" @click="DeleteSelected()">Delete Selected</button>

    <nav class="pagination">
      <a @click.prevent="fetchUser(prev_page_url)" :disabled="!prev_page_url" class="button"><i class="fa fa-angle-left"></i></a>
      <a @click.prevent="fetchUser(next_page_url)" :disabled="!next_page_url" class="button"><i class="fa fa-angle-right"></i></a>
      <ul>
        <li v-for="pageNumber in last_page" v-if="Math.abs(pageNumber - current_page) < 3 || pageNumber == last_page || pageNumber == 1">
          <a href="#" class="button" @click.prevent="fetchUser('/api/users?page=' + pageNumber)"  :class="{'is-primary': current_page === pageNumber}">{{ pageNumber }}</a>
        </li>
      </ul>
    </nav>

    <hr>
    {{NameRole}}
  </div>
</template>


<script>
var emailRE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
import Spinner from './Spinner.vue'
export default {
  components: {
    Spinner
  },
  mounted() {
    console.log('User Component ready.')
    this.fetchUser()
  },
  data : function() {
    return {
      loading: false,
      users: [],
      deleted_user: [],
      newUser:{
        id: '',
        name: '',
        email: '',
        password: '',
        admin: '',
        rpassword: '',
      },
      roles: [],
      avatar:'',
      searchKey: '',
      current_page : 0,
      last_page : 0,
      next_page_url : '',
      prev_page_url : '',
      first_page_url: '/api/users/',
      per_page: 0,
      total : 0,
      edit: false,
      form: false
    }
  },
  methods : {
    fetchUser: function(page_url){
      this.loading = true
      page_url = page_url || '/api/users/'
      this.$http.get(page_url).then((response) => {
        this.makePagination(response.data.data)
        this.users = response.data.data.data
        this.roles = response.data.roles
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch users');
      })

    },
    makePagination: function(data){data

      var getLocation = function(url) {
        if(url){
          var l = document.createElement("a");
          l.href = url;
          return l.pathname + l.search;
        }
      };

      this.current_page = data.current_page
      this.last_page = data.last_page
      this.next_page_url = getLocation(data.next_page_url)
      this.prev_page_url = getLocation(data.prev_page_url)
      this.total = data.total
      this.per_page = data.per_page
    },

    RemoveUser: function (id) {
      var self = this;
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then(function() {
        self.$http.delete('/api/users/' + id).then((data) => {
          self.fetchUser()
        })
        swal({
          title: 'Deleted!',
          text: 'Your file has been deleted.',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done();
      },function() {
        swal({
          title: 'Aha!',
          type: 'question',
          showConfirmButton: false,
          timer: 1500
        }).done();
      })
    },
    DeleteSelected: function () {
      var self = this
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then(function() {
        self.$http.delete('/api/users/' + self.deleted_user).then((data) => {
          console.log(self.deleted_user);
          self.fetchUser()
      })
        swal({
          title: 'Deleted!',
          text: 'Your file has been deleted.',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done();
      },function() {
        swal({
          title: 'Aha!',
          type: 'question',
          showConfirmButton: false,
          timer: 1500
        }).done();
      })
    },

    ShowUser: function (id) {
      this.edit = true
      this.$http.get('/api/users/' + id).then((data) => {
        this.newUser.id = data.data.data.id
        this.newUser.name = data.data.data.name
        this.newUser.email = data.data.data.email
        this.newUser.admin = data.data.data.admin
        this.newUser.password = data.data.data.password
        this.newUser.rpassword = data.data.data.password
        this.avatar = data.data.avatar
        document.forms[0].elements[0].focus();
        this.form = true
      })

    },

    EditUser: function(){
      var user = this.newUser
      var id = user.id
      this.$http.patch('/api/users/' + id, user).then((data) => {
        this.newUser = { name:'', email:'', password:'',admin:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchUser()
      })
      this.edit = false

    },

    AddNewUser: function(){
      // user input
      var user = this.newUser

      // send post
      this.$http.post('/api/users/', user).then((data) => {
        this.newUser = { name:'', email:'', password:'',admin:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Page
        this.fetchUser()
      })
    },
    closeForm: function () {
      this.form = false
      this.newUser = { name:'', email:'', password:'',admin:''}
      this.edit = false
    },
    openForm: function () {
      this.form = true
    },

    NameRole: function (id) {
      var self = this
      var result = $.grep(self.roles, function(e){ return e.id == id; });
      if (result.length == 0) {
        console.log('No Roles Yet');
      } else if (result.length == 1) {
        return result[0].name;
      }
    }

  },

  computed: {
    validation: function(){
      return{
        name: !!this.newUser.name.trim(),
        email: emailRE.test(this.newUser.email),
        admin: !!this.newUser.admin,
        password: this.newUser.password === this.newUser.rpassword,
      }
    },

    isValid: function(){
      var validation = this.validation
      return Object.keys(validation).every(function(key){
        return validation[key]
      })
    },
    filteredUsers: function () {
      var self = this
      return self.users.filter(function (users) {
        return users.name.indexOf(self.searchKey) !== -1
      })
    },

  }
}
</script>
