<template>
    <div>
        <spinner :show="loading"></spinner>
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Roles & Permissions
                </h1>
                <h2 class="subtitle">
                    Add, Edit and Delete Roles & Permissions
                </h2>
            </div>
        </div>
        <div class="columns">

          <div class="column">
            <form id="form" action="#" @submit.prevent="AddNewRole" method="POST">
              <div class="control is-grouped">
                <p class="control has-icon is-expanded">
                    <input v-model="newRole.name" class="input" type="text" placeholder="Role Name">
                </p>

                <p class="control has-icon">
                    <input v-model="newRole.display_name"  class="input" type="text" placeholder="Display Name">
                </p>
              </div>
              <p class="control">
                  <select multiple
                        v-model="newRole.selected_pers"
                        >
                    <option v-for="permission in permissions"
                            v-bind:value="permission.id">
                            {{ permission.display_name }}
                    </option>
                  </select>
              </p>
              <div class="control is-grouped">
                <p class="control has-icon is-expanded">
                    <textarea v-model="newRole.description" class="input"></textarea>
                </p>
                <p class="control">
                    <button type="submit" v-if="!editRole" class="button is-success" >Save</button>
                </p>
                <p class="control">
                    <button v-if="editRole" class="button is-success" @click="EditRole">Edit</button>
                </p>
              </div>
            </form>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>display_name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles">
                        <th>{{role.id}}</th>
                        <th>{{role.name}}</th>
                        <th>{{role.display_name}}</th>
                        <th>
                            <button class="button is-small is-primary" @click="ShowRole(role.id)">
                                <span class="icon is-small"><i class="fa fa-edit"></i></span>
                                <span>Edit</span>
                            </button>
                            <button class="button is-small is-danger" @click="RemoveRole(role.id)">
                                <span class="icon is-small"><i class="fa fa-remove"></i></span>
                                <span>Delete</span>
                            </button>
                        </th>
                    </tr>
                </tbody>
            </table>
          </div>
          <div class="column">
            <form id="form" action="#" @submit.prevent="AddNewPermission" method="POST">
              <div class="control is-grouped">
                <p class="control has-icon is-expanded">
                    <input v-model="newPermission.name" class="input" type="text" placeholder="Permission Name">
                </p>

                <p class="control has-icon">
                    <input v-model="newPermission.display_name"  class="input" type="text" placeholder="Display Name">
                </p>
              </div>
              <div class="control is-grouped">
                <p class="control has-icon is-expanded">
                    <textarea v-model="newPermission.description" class="input"></textarea>
                </p>
                <p class="control">
                    <button type="submit" v-if="!editPerm" class="button is-success" >Save</button>
                </p>
                <p class="control">
                    <button v-if="editPerm" class="button is-success" @click="EditPermission">Edit</button>
                </p>
              </div>
            </form>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>display_name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="permission in permissions">
                        <th>{{permission.id}}</th>
                        <th>{{permission.name}}</th>
                        <th>{{permission.display_name}}</th>
                        <th>
                            <button class="button is-small is-primary" @click="ShowPermission(permission.id)">
                                <span class="icon is-small"><i class="fa fa-edit"></i></span>
                                <span>Edit</span>
                            </button>
                            <button class="button is-small is-danger" @click="RemovePermission(permission.id)">
                                <span class="icon is-small"><i class="fa fa-remove"></i></span>
                                <span>Delete</span>
                            </button>
                        </th>
                    </tr>
                </tbody>
            </table>
          </div>

        </div>



    </div>
</template>


<script>
    import Spinner from './Spinner.vue'
    export default {
        components: {
            Spinner
        },
        mounted() {
            console.log('Role Component ready.')
            this.fetchRoles()
            this.fetchPermissions()
        },
        data : function() {
            return {
                loading: false,
                roles: [],
                permissions: [],
                newRole: {
                  id: '',
                  name: '',
                  display_name: '',
                  description: '',
                  selected_pers:[],
                },
                newPermission: {
                  id: '',
                  name: '',
                  display_name: '',
                  description: '',
                },
                editRole: false,
                editPerm: false,


            }
        },
        methods : {
          fetchRoles: function () {
            this.loading = true
            this.$http.get('/api/roles/').then((response) => {
              this.roles = response.data.roles
              self = this
              setTimeout(function () {
                  self.loading = false
              }, 1000)
            }, (response) => {
                console.log('Error fetch Roles');
            })
          },
          AddNewRole: function () {
            var role = this.newRole
            this.$http.post('/api/roles/', role).then((data) => {
              this.newRole = {id: '',name: '',display_name: '', description: '',selected_pers:[] }
              swal({
                  title: 'Good job!',
                  text: 'You clicked the button!',
                  type: 'success',
                  showConfirmButton: false,
                  timer: 1500
              }).done()
              //Reload Page
              this.fetchRoles()
            })
          },

          ShowRole: function (id) {
              this.editRole = true
              this.$http.get('/api/roles/' + id).then((data) => {
                  this.newRole.id = data.data.role.id
                  this.newRole.name = data.data.role.name
                  this.newRole.display_name = data.data.role.display_name
                  this.newRole.description = data.data.role.description
                  this.newRole.selected_pers = data.data.selected_pers
                  document.forms[0].elements[0].focus();
              })


          },
          EditRole: function () {
            var role = this.newRole
            var id = role.id
            this.$http.patch('/api/roles/' + id, role).then((data) => {
              this.newRole = {id: '',name: '',display_name: '', description: '',selected_pers:[] }
                swal({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).done()
                this.fetchRoles()
            })
            this.editRole = false

          },
          RemoveRole: function (id) {
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
                  self.$http.delete('/api/roles/' + id).then((data) => {
                      self.fetchRoles()
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

          fetchPermissions: function () {
            this.loading = true
            this.$http.get('/api/permissions/').then((response) => {
              this.permissions = response.data.permissions
              self = this
              setTimeout(function () {
                  self.loading = false
              }, 1000)
            }, (response) => {
                console.log('Error fetch Permissions');
            })
          },

          AddNewPermission: function () {
            var permission = this.newPermission
            this.$http.post('/api/permissions/', permission).then((data) => {
              this.newPermission = {name: '',display_name: '', description: '' }
              swal({
                  title: 'Good job!',
                  text: 'You clicked the button!',
                  type: 'success',
                  showConfirmButton: false,
                  timer: 1500
              }).done()
              //Reload Page
              this.fetchPermissions()
            })
          },
          ShowPermission: function (id) {
              this.editPerm = true
              this.$http.get('/api/permissions/' + id).then((data) => {
                  this.newPermission.id = data.data.permission.id
                  this.newPermission.name = data.data.permission.name
                  this.newPermission.display_name = data.data.permission.display_name
                  this.newPermission.description = data.data.permission.description
                  document.forms[0].elements[0].focus();
              })
          },

          EditPermission: function () {
            var permission = this.newPermission
            var id = permission.id
            this.$http.patch('/api/permissions/' + id, permission).then((data) => {
              this.newPermission = {id: '',name: '',display_name: '', description: ''}
                swal({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).done()
                this.fetchPermissions()
            })
            this.editPerm = false
          },
          RemovePermission: function (id) {
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
                  self.$http.delete('/api/permissions/' + id).then((data) => {
                      self.fetchPermissions()
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



        },

        computed: {

        }
    }
</script>
