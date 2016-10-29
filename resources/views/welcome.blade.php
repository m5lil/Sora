@extends('dashboard.layout')

@section('content')
  <div id="app">
    {{-- <nav class="nav has-shadow">
    <div class="container">
    <div class="nav-left">
    <router-link active-class="is-active" to="/" class="nav-item is-tab " exact>Settings</router-link>
    <router-link active-class="is-active" to="/foo" class="nav-item is-tab " >Pages</router-link>
    <router-link active-class="is-active" to="/bar" class="nav-item is-tab ">Blogs</router-link>
    <router-link active-class="is-active" to="/users" class="nav-item is-tab ">Users</router-link>
    <router-link active-class="is-active" to="/roles" class="nav-item is-tab ">Roles/Permissions</router-link>
    <router-link active-class="is-active" to="/newsletter" class="nav-item is-tab ">Newsletter</router-link>
    <router-link active-class="is-active" to="/services" class="nav-item is-tab ">Services</router-link>
    <router-link active-class="is-active" to="/projects" class="nav-item is-tab ">Projects</router-link>
  </div>
</div>
</nav> --}}
<section>
  <div class="hero-head">
    <header class="nav">
      <div class="container">
        <div class="nav-left">
          <a class="nav-item">
            {{-- <img src="images/bulma-type-white.png" alt="Logo"> --}}
            <span style="font-size:25px;">Admin Dashboard</span>

          </a>
        </div>
        <span class="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <div class="nav-right nav-menu">

          <router-link active-class="is-active" to="/" class="nav-item is-tab " exact>Settings</router-link>
          <router-link active-class="is-active" to="/pages" class="nav-item is-tab " >Pages</router-link>
          <router-link active-class="is-active" to="/blogs" class="nav-item is-tab ">Blog</router-link>
          <router-link active-class="is-active" to="/users" class="nav-item is-tab ">Users</router-link>
          <router-link active-class="is-active" to="/roles" class="nav-item is-tab ">Roles/Permissions</router-link>
          <router-link active-class="is-active" to="/newsletter" class="nav-item is-tab ">Newsletter</router-link>
          <router-link active-class="is-active" to="/menus" class="nav-item is-tab ">Menus</router-link>
          <router-link active-class="is-active" to="/projects" class="nav-item is-tab ">Projects</router-link>

          <span class="nav-item">
            <a class="button is-info is-inverted" href={{url('/')}}>
              <span class="icon">
                <i class="fa fa-globe"></i>
              </span>
              <span>The Site</span>
            </a>
          </span>
        </div>
      </div>
    </header>
  </div>
</section>
<section>
  <transition name="slide-fade" mode="out-in">
    <keep-alive>
      <router-view class="container"></router-view>
    </keep-alive>
  </transition>
</section>
</div>
@endsection



@push('scripts')
  {{-- / setting value to your CSRFglobal variables  --}}
  <script>
  window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
  ]); ?>
  </script>

  <script src="{{ elixir('js/app.js') }}"></script>
  <script src="{{ elixir('js/all.js') }}"></script>

@endpush
