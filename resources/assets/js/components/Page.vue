<template>
  <div>
    <spinner :show="loading"></spinner>
    <div class="hero-body">
      <div class="container">
        <div class="is-pulled-left">
          <h1 class="title">
            Pages
          </h1>
          <h2 class="subtitle">
            Add, Edit and Delete Pages
          </h2>
        </div>
        <div class="is-pulled-right">
          <button @click="openForm" class="button is-primary is-outlined">
            <span class="icon">
              <i class="fa fa-plus"></i>
            </span>
            <span>Add Page</span>
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
              <input v-model="newPage.title" class="input" type="title" placeholder="Title">
            </p>
            <p class="control is-expanded">
              <textarea v-model="newPage.content" id="tinymce" v-html="newPage.content" class="input"></textarea>
            </p>
            <p class="control is-expanded">
              <input v-model="newPage.status"  class="input" type="status" placeholder="Status">
            </p>
            <p class="control is-expanded">
              <input v-model="newPage.seo_title"  class="input" type="seo_title" placeholder="seo_title">
            </p>
            <p class="control is-expanded">
              <input v-model="newPage.seo_description"  class="input" type="seo_description" placeholder="seo_description">
            </p>

          </form>

        </section>
        <footer class="modal-card-foot">
          <button v-if="!edit" class="button is-primary" @click="AddNewPage" >Save</button>
          <button v-if="edit" class="button is-success" @click="EditPage">Edit</button>
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
          <th>Seo Title</th>
          <th>Content</th>
          <th>status</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="page in pages">
          <th>{{page.id}}</span></th>
          <th>{{page.title}}</th>
          <th>{{page.seo_title}}</th>
          <th v-html="page.content.substring(0,60)"></th>
          <th>{{page.status}}</th>
          <th>
            <button class="button is-small is-primary" @click="ShowPage(page.id)">
              <span class="icon is-small"><i class="fa fa-edit"></i></span>
              <span>Edit</span>
            </button>
            <button class="button is-small is-danger" @click="RemovePage(page.id)">
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
    console.log('Page Component ready.')
    tinymce.init({
      selector:'textarea',
      height: 300,
      theme: 'modern',
      plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
      toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image fullscreen"
     })
    this.fetchPage()
  },

  data : function() {
    return {
      loading: false,
      pages: [],
      newPage:{
        id: '',
        title: '',
        content: '',
        status: '',
        seo_title: '',
        seo_description: '',
      },
      edit: false,
      form: false
    }
  },

  methods : {
    fetchPage: function(){
      this.loading = true
      this.$http.get('/api/pages').then((response) => {
        this.pages = response.data.pages
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch pages');
      })

    },


    RemovePage: function (id) {
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
        self.$http.delete('/api/pages/' + id).then((data) => {
          self.fetchPage()
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

    ShowPage: function (id) {
      this.edit = true
      this.$http.get('/api/pages/' + id).then((data) => {
        this.newPage.id = data.data.id
        this.newPage.title = data.data.title
        this.newPage.content = data.data.content
        tinymce.get("tinymce").setContent(this.newPage.content);
        this.newPage.status = data.data.status
        this.newPage.seo_title = data.data.seo_title
        this.newPage.seo_description = data.data.seo_description
        document.forms[0].elements[0].focus();
        this.form = true
      })
    },

    EditPage: function(){
      var page = this.newPage
      page.content = tinymce.get('tinymce').getContent()
      var id = page.id
      this.$http.patch('/api/pages/' + id, page).then((data) => {
        this.newPage = { title:'', content:'', status:'', seo_title:'', seo_description:''}
        this.form = false
        tinymce.get("tinymce").setContent('')
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchPage()
      })
      this.edit = false
    },

    AddNewPage: function(){
      // page input
      var page = this.newPage
      page.content = tinymce.get('tinymce').getContent()
      // send post
      this.$http.post('/api/pages/', page).then((data) => {
        this.newPage = { title:'', content:'', status:'', seo_title:'', seo_description:''}
        this.form = false
        tinymce.get("tinymce").setContent('')
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Page
        this.fetchPage()
      })
    },

    closeForm: function () {
      this.form = false
      this.newPage = { title:'', content:'', status:'', seo_title:'', seo_description:''}
      tinymce.get("tinymce").setContent('');
    },

    openForm: function () {
      this.form = true
    }

  },

  computed: {

  }
}
</script>
