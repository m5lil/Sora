@extends('dashboard.layout')

@section('content')
        <div id="app">
            <nav class="nav has-shadow">
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
            </nav>
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
