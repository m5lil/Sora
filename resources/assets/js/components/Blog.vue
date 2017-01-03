g<template>
  <div>
    <spinner :show="loading"></spinner>
    <div class="tabs">
      <ul>
        <li v-bind:class="{'is-active': activeTab == 'posts'}" ><a @click="setActiveTab('posts')">Posts</a></li>
        <li v-bind:class="{'is-active': activeTab == 'categories'}" ><a @click="setActiveTab('categories')">Categories</a></li>
        <li v-bind:class="{'is-active': activeTab == 'comments'}" ><a @click="setActiveTab('comments')">Comments</a></li>
      </ul>
    </div>
    <div v-show="activeTab == 'posts'">

      <div class="hero-body">
        <div class="container">
          <div class="is-pulled-left">
            <h1 class="title">
              Posts
            </h1>
            <h2 class="subtitle">
              Add, Edit and Delete Posts
            </h2>
          </div>
          <div class="is-pulled-right">
            <button @click="openForm" class="button is-primary is-outlined">
              <span class="icon">
                <i class="fa fa-plus"></i>
              </span>
              <span>Add Post</span>
            </button>
          </div>
        </div>
      </div>
      <!-- Modal -->
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
                <input v-model="newPost.title" class="input" type="title" placeholder="Title">
              </p>
              <p class="control is-expanded">
                <textarea v-model="newPost.content" id="tinymce" v-html="newPost.content" class="input"></textarea>
              </p>
              <p class="control is-expanded">
                <input v-model="newPost.status"  class="input" type="status" placeholder="Status">
              </p>
              <p class="control is-expanded">
                <input v-model="newPost.seo_title"  class="input" type="seo_title" placeholder="seo_title">
              </p>
              <p class="control is-expanded">
                <input v-model="newPost.seo_description"  class="input" type="seo_description" placeholder="seo_description">
              </p>

            </form>

          </section>
          <footer class="modal-card-foot">
            <button v-if="!edit" class="button is-primary" @click="AddNewPost" >Save</button>
            <button v-if="edit" class="button is-success" @click="EditPost">Edit</button>
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
          <tr v-for="post in posts">
            <th>{{post.id}}</span></th>
            <th>{{post.title}}</th>
            <th>{{post.seo_title}}</th>
            <th v-html="post.content.substring(0,60)"></th>
            <th>{{post.status}}</th>
            <th>
              <button class="button is-small is-primary" @click="ShowPost(post.id)">
                <span class="icon is-small"><i class="fa fa-edit"></i></span>
                <span>Edit</span>
              </button>
              <button class="button is-small is-danger" @click="RemovePost(post.id)">
                <span class="icon is-small"><i class="fa fa-remove"></i></span>
                <span>Delete</span>
              </button>
            </th>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- // Categories -->
    <div v-show="activeTab == 'categories'">
      <div class="hero-body">
        <div class="container">
          <div class="is-pulled-left">
            <h1 class="title">
              Categories
            </h1>
            <h2 class="subtitle">
              Add, Edit and Delete Categories
            </h2>
          </div>
          <div class="is-pulled-right">
            <button @click="openForm" class="button is-primary is-outlined">
              <span class="icon">
                <i class="fa fa-plus"></i>
              </span>
              <span>Add Category</span>
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
                <input v-model="newCategory.title" class="input" type="title" placeholder="Title">
              </p>
              <p class="control is-expanded">
                <input v-model="newCategory.status"  class="input" type="status" placeholder="Status">
              </p>

            </form>

          </section>
          <footer class="modal-card-foot">
            <button v-if="!edit" class="button is-primary" @click="AddNewCategory" >Save</button>
            <button v-if="edit" class="button is-success" @click="EditCategory">Edit</button>
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
            <th>status</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories">
            <th>{{category.id}}</span></th>
            <th>{{category.title}}</th>
            <th>{{category.status}}</th>
            <th>
              <button class="button is-small is-primary" @click="ShowCategory(category.id)">
                <span class="icon is-small"><i class="fa fa-edit"></i></span>
                <span>Edit</span>
              </button>
              <button class="button is-small is-danger" @click="RemoveCategory(category.id)">
                <span class="icon is-small"><i class="fa fa-remove"></i></span>
                <span>Delete</span>
              </button>
            </th>
          </tr>
        </tbody>
      </table>

      <hr>
    </div>

    <!-- Comments -->
    <div v-show="activeTab == 'comments'">
      <div class="hero-body">
        <div class="container">
          <div class="is-pulled-left">
            <h1 class="title">
              comments
            </h1>
            <h2 class="subtitle">
              Add, Edit and Delete comments
            </h2>
          </div>
          <div class="is-pulled-right">
            <button @click="openForm" class="button is-primary is-outlined">
              <span class="icon">
                <i class="fa fa-plus"></i>
              </span>
              <span>Add Comment</span>
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
                <input v-model="newComment.name" class="input" type="title" placeholder="Title">
              </p>
              <p class="control is-expanded">
                <input v-model="newComment.status"  class="input" type="status" placeholder="Status">
              </p>
              <p class="control is-expanded">
                <center>{{newComment.content}}</center>
              </p>

            </form>

          </section>
          <footer class="modal-card-foot">
            <button v-if="!edit" class="button is-primary" @click="AddNewComment" >Save</button>
            <button v-if="edit" class="button is-success" @click="EditComment">Edit</button>
            <a @click="closeForm" class="button">Cancel</a>
          </footer>
        </div>
      </div>

      <hr>
      <table class="table">
        <thead>
          <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>content</th>
            <th>status</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="comment in comments">
            <th>{{comment.id}}</span></th>
            <th>{{comment.name}}</th>
            <th>{{comment.email}}</th>
            <th v-html="comment.content.substring(0,60)"></th>
            <th>{{comment.status}}</th>
            <th>
              <button class="button is-small is-primary" @click="ShowComment(comment.id)">
                <span class="icon is-small"><i class="fa fa-edit"></i></span>
                <span>Edit</span>
              </button>
              <button class="button is-small is-danger" @click="RemoveComment(comment.id)">
                <span class="icon is-small"><i class="fa fa-remove"></i></span>
                <span>Delete</span>
              </button>
            </th>
          </tr>
        </tbody>
      </table>


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
    console.log('Post Component ready.')
    tinymce.init({
      selector:'textarea',
      height: 300,
      theme: 'modern',
      plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
      toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image fullscreen"
     })
    this.fetchPost()

  },

  data : function() {
    return {
      activeTab: 'posts',
      loading: false,
      posts: [],
      categories: [],
      comments: [],
      newPost:{
        id: '',
        title: '',
        content: '',
        category_id: '1',
        status: '',
        seo_title: '',
        seo_description: '',
      },
      newCategory:{
        id: '',
        title: '',
        status: '',
      },
      newComment:{
        id: '',
        name: '',
        email: '',
        content: '',
        post_id: '',
        status: '',
      },
      edit: false,
      form: false
    }
  },

  methods : {
    fetchPost: function(){
      this.loading = true
      this.$http.get('/api/posts').then((response) => {
        this.posts = response.data.posts
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch posts');
      })
    },

    fetchCategory: function(){
      this.loading = true
      this.$http.get('/api/categories').then((response) => {
        this.categories = response.data.categories
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch categories');
      })
    },

    fetchComment: function(){
      this.loading = true
      this.$http.get('/api/comments').then((response) => {
        this.comments = response.data.comments
        self = this
        setTimeout(function () {
          self.loading = false
        }, 1000)
      }, (response) => {
        console.log('Error fetch comments');
      })
    },


    RemovePost: function (id) {
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
        self.$http.delete('/api/posts/' + id).then((data) => {
          self.fetchPost()
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

    RemoveCategory: function (id) {
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
        self.$http.delete('/api/categories/' + id).then((data) => {
          self.fetchCategory()
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

    RemoveComment: function (id) {
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
        self.$http.delete('/api/comments/' + id).then((data) => {
          self.fetchComment()
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

    ShowPost: function (id) {
      this.edit = true
      this.$http.get('/api/posts/' + id).then((data) => {
        this.newPost.id = data.data.id
        this.newPost.title = data.data.title
        this.newPost.content = data.data.content
        tinymce.get("tinymce").setContent(this.newPost.content);
        this.newPost.status = data.data.status
        this.newPost.seo_title = data.data.seo_title
        this.newPost.seo_description = data.data.seo_description
        document.forms[0].elements[0].focus();
        this.form = true
      })
    },

    ShowCategory: function (id) {
      this.edit = true
      this.$http.get('/api/categories/' + id).then((data) => {
        this.newCategory.id = data.data.id
        this.newCategory.title = data.data.title
        this.newCategory.status = data.data.status
        document.forms[0].elements[0].focus();
        this.form = true
      })
    },

    ShowComment: function (id) {
      this.edit = true
      this.$http.get('/api/comments/' + id).then((data) => {
        this.newComment.id = data.data.id
        this.newComment.name = data.data.name
        this.newComment.email = data.data.email
        this.newComment.content = data.data.content
        this.newComment.post_id = data.data.post_id
        this.newComment.status = data.data.status
        document.forms[0].elements[0].focus();
        this.form = true
      })
    },

    EditPost: function(){
      var post = this.newPost
      post.content = tinymce.get('tinymce').getContent()
      var id = post.id
      this.$http.patch('/api/posts/' + id, post).then((data) => {
        this.newPost = { title:'', content:'', status:'', seo_title:'', seo_description:''}
        this.form = false
        tinymce.get("tinymce").setContent('')
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchPost()
      })
      this.edit = false
    },

    EditCategory: function(){
      var category = this.newCategory
      var id = category.id
      this.$http.patch('/api/categories/' + id, category).then((data) => {
        this.newCategory = { title:'',  status:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchCategory()
      })
      this.edit = false
    },

    EditComment: function(){
      var comment = this.newComment
      var id = comment.id
      this.$http.patch('/api/comments/' + id, comment).then((data) => {
        this.newComment = { name:'',email:'', content:'', post_id:'', status:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        this.fetchComment()
      })
      this.edit = false
    },

    AddNewPost: function(){
      // post input
      var post = this.newPost
      post.content = tinymce.get('tinymce').getContent()
      // send post
      this.$http.post('/api/posts/', post).then((data) => {
        this.newPost = { title:'', content:'', status:'', seo_title:'', seo_description:''}
        this.form = false
        tinymce.get("tinymce").setContent('')
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Post
        this.fetchPost()
      })
    },

    AddNewCategory: function(){
      // category input
      var category = this.newCategory
      // send category
      this.$http.post('/api/categories/', category).then((data) => {
        this.newCategory = { title:'',  status:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Category
        this.fetchCategory()
      })
    },

    AddNewComment: function(){
      // comment input
      var comment = this.newComment
      // send comment
      this.$http.post('/api/comments/', comment).then((data) => {
        this.newComment = { name:'',email:'', content:'', post_id:'', status:''}
        this.form = false
        swal({
          title: 'Good job!',
          text: 'You clicked the button!',
          type: 'success',
          showConfirmButton: false,
          timer: 1500
        }).done()
        //Reload Comment
        this.fetchComment()
      })
    },

    closeForm: function () {
      this.form = false
      this.newPost = { title:'', content:'', status:'', seo_title:'', seo_description:''}
      this.newCategory = { title:'',  status:''}
      tinymce.get("tinymce").setContent('');
    },

    openForm: function () {
      this.form = true
    },
    setActiveTab: function (tab) {
      if (tab == 'posts') {
        this.activeTab = tab
      }else if (tab == 'categories') {
        this.activeTab = tab
        if (!this.categories.length > 0) this.fetchCategory()
      }else if (tab == 'comments') {
        this.activeTab = tab
        if (!this.comments.length > 0) this.fetchComment()
      }


    }

  },

  computed: {

  }
}
</script>
