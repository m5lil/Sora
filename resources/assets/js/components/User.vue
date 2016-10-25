<template>
    <div>
        <spinner :show="loading"></spinner>
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Users
                </h1>
                <h2 class="subtitle">
                    Add, Edit and Delete Users
                </h2>
            </div>
        </div>

        <form id="form" action="#" @submit.prevent="AddNewUser" method="POST">

          <div class="control is-grouped">
            <p class="control has-icon is-expanded">
                <input v-model="newUser.name" class="input" v-bind:class="{ 'is-danger': !validation.name }" type="name" placeholder="Name">
                <i class="fa fa-user"></i>
                <span v-show="!validation.name" class="help is-danger">Type Correct name</span>
            </p>

            <p class="control has-icon is-expanded">
                <input v-model="newUser.email"  class="input" v-bind:class="{ 'is-danger': !validation.email }" type="email" placeholder="Email">
                <i class="fa fa-envelope"></i>
                <span v-show="!validation.email" class="help is-danger">Type Correct Email</span>
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
                <span v-show="!validation.password" class="help is-danger">Don't the same</span>
            </p>

            <p class="control">
              <span class="select">
                <select v-model="newUser.admin">
                  <option v-for="permission in permissions" v-bind:value="permission.id">{{permission.name}}</option>
                </select>
              </span>
            </p>

            <p class="control">
                <button :disabled="!isValid" type="submit" v-if="!edit" class="button is-success" >Save</button>
            </p>
            <p class="control">
                <button :disabled="!isValid" v-if="edit" class="button is-success" @click="EditUser">Edit</button>
            </p>

          </div>


        </form>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
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
                    <th>{{user.id}}</th>
                    <th>{{user.name}}</th>
                    <th>{{user.email}}</th>
                    <th>{{user.admin}}</th>
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
                newUser:{
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    admin: '',
                    rpassword: '',
                },
                permissions: [],
                searchKey: '',
                current_page : 0,
                last_page : 0,
                next_page_url : '',
                prev_page_url : '',
                first_page_url: '/api/users/',
                per_page: 0,
                total : 0,
                edit: false,
            }
        },
        methods : {
            fetchUser: function(page_url){
                this.loading = true
                page_url = page_url || '/api/users/'
                this.$http.get(page_url).then((response) => {
                    this.makePagination(response.data.data)
                    this.users = response.data.data.data
                    this.permissions = response.data.permissions
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

            ShowUser: function (id) {
                this.edit = true
                this.$http.get('/api/users/' + id).then((data) => {
                    this.newUser.id = data.data.id
                    this.newUser.name = data.data.name
                    this.newUser.email = data.data.email
                    this.newUser.admin = data.data.admin
                    this.newUser.password = data.data.password
                    this.newUser.rpassword = data.data.password
                    document.forms[0].elements[0].focus();
                })


            },

            EditUser: function(){
                var user = this.newUser
                var id = user.id
                this.$http.patch('/api/users/' + id, user).then((data) => {
                    this.newUser = { name:'', email:'', password:'',admin:''}
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
            }
        },

        computed: {
            last_page_url: function () {
              return '/api/users?page=' + this.last_page
            },
            validation: function(){
                return{
                    name: !!this.newUser.name.trim(),
                    email: emailRE.test(this.newUser.email),
                    password: this.newUser.password === this.newUser.rpassword
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
            }
        }
    }
</script>
