<template>
  <div>
    <spinner :show="loading"></spinner>
    <div class="hero-body">
      <div class="container">
        <div class="is-pulled-left">
          <h1 class="title">
            Menus
          </h1>
          <h2 class="subtitle">
            Add, Edit and Delete Menus
          </h2>
        </div>
        <div class="is-pulled-right">
          <button @click="openForm" class="button is-primary is-outlined">
            <span class="icon">
              <i class="fa fa-plus"></i>
            </span>
            <span>Add Menu</span>
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

            <p class="control is-expanded">
              <input v-model="newMenu.title" class="input" type="title" placeholder="Title">
            </p>
            <p class="control is-expanded">
              <input v-model="newMenu.url"  class="input" type="url" placeholder="Url">
            </p>
            <p class="control is-expanded">
              <input v-model="newMenu.order"  class="input" type="order" placeholder="Order">
            </p>
            <p class="control select">
                <select v-model="newMenu.parent_id">
                  <option value="" hidden>Choose Menu Item</option>
                  <option v-for="menu in menus" v-bind:value="menu.id">{{menu.title}}</option>
                </select>
            </p>


          </form>

        </section>
        <footer class="modal-card-foot">
          <button v-if="!edit" class="button is-primary" @click="AddNewMenu" >Save</button>
          <button v-if="edit" class="button is-success" @click="EditMenu">Edit</button>
          <a @click="closeForm" class="button">Cancel</a>
        </footer>
      </div>
    </div>

    <hr>
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>title</th>
          <th>url</th>
          <th>order</th>
          <th>parent_id</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="menu in menus">
          <th><span v-if="menu.parent_id == 0">{{menu.id}}</span></th>
          <th><span v-if="menu.parent_id > 0"> <i style="font-size:14px; margin-top:3px;" class="fa fa-long-arrow-right"> </i> </span>{{menu.title}}</th>
          <th>{{menu.url}}</th>
          <th>{{menu.order}}</th>
          <th>{{menu.parent_id}}</th>
          <th>
            <button class="button is-small is-primary" @click="ShowMenu(menu.id)">
              <span class="icon is-small"><i class="fa fa-edit"></i></span>
              <span>Edit</span>
            </button>
            <button class="button is-small is-danger" @click="RemoveMenu(menu.id)">
              <span class="icon is-small"><i class="fa fa-remove"></i></span>
              <span>Delete</span>
            </button>
          </th>
        </tr>
      </tbody>
    </table>

    <hr>

  </div>
</template>


<script>
import Spinner from './Spinner.vue'
export default {
  components: {
    Spinner
  },
  mounted() {
    console.log('Menu Component ready.')
    this.fetchMenu()
  },
  data : function() {
    return {
      loading: false,
      menus: [],
      newMenu:{
        id: '',
        title: '',
        url: '',
        parent_id: '',
        order: '',
      },
      edit: false,
      form: false
    }
  },
  methods : {
    fetchMenu: function(){
      this.loading = true
      this.$http.get('/api/menus').then((response) => {
        this.menus = response.data.menus
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch menus');
      })

    },


    RemoveMenu: function (id) {
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
        self.$http.delete('/api/menus/' + id).then((data) => {
          self.fetchMenu()
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

    ShowMenu: function (id) {
      this.edit = true
      this.$http.get('/api/menus/' + id).then((data) => {
        this.newMenu.id = data.data.id
        this.newMenu.title = data.data.title
        this.newMenu.url = data.data.url
        this.newMenu.parent_id = data.data.parent_id
        this.newMenu.order = data.data.order
        document.forms[0].elements[0].focus();
        this.form = true
      })



    },

    EditMenu: function(){
      var menu = this.newMenu
      var id = menu.id
      this.$http.patch('/api/menus/' + id, menu).then((data) => {
        this.newMenu = { title:'', url:'', parent_id:'',order:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchMenu()
      })
      this.edit = false

    },

    AddNewMenu: function(){
      // menu input
      var menu = this.newMenu

      // send post
      this.$http.post('/api/menus/', menu).then((data) => {
        this.newMenu = { title:'', url:'', parent_id:'',order:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Page
        this.fetchMenu()
      })
    },
    closeForm: function () {
      this.form = false
      this.newMenu = { title:'', url:'', parent_id:'',order:''}
    },
    openForm: function () {
      this.form = true
    }

  },

  computed: {

  }
}
</script>
