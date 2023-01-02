<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-1 panel-left">
                <div class="panel">

                    <a href="/"><img src="/img/profresh.png" class="main-img" alt=""></a>

                    <div v-if="loggedIn === true">

                    <router-link to="/dashboard" class="panel-list_item">
                        <p><span class="icon">
                                <i class="icon-logo far fa-calendar"></i>
                                <span class="icon-name">Dashboard</span>
                            </span></p>
                    </router-link>

                    <router-link to="/projects" class="panel-list_item">
                        <p><span class="icon">
                                <i class="icon-logo  fab fa-product-hunt"></i>
                                <span class="icon-name">Projects</span>
                            </span></p>
                    </router-link>

                    <project-button></project-button>

                    <a href="" @click.prevent="signOut()" class="panel-list_item">
                        <p><span class="icon"><i class="icon-logo fas fa-sign-out-alt"></i><span class="icon-name">Logout</span></span></p>
                    </a>
                </div>
                </div>
            </div>

            <div class="col-md-11 panel-right">

                <nav class="navbar navbar-expand-md navbar-light bg-white">
                    <router-link class="navbar-brand" to='/home'><b>Profresh</b></router-link>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            <li class="nav-item" v-if="loggedIn !== true">
                                <router-link class="nav-link" to='/login'>Sign In</router-link>
                            </li>
                            <li class="nav-item" v-if="loggedIn !== true">
                                <router-link class="nav-link" to='/register'>Sign Up</router-link>
                            </li>
                             <notifications  class="mr-3" v-if="loggedIn === true"></notifications>
                        </ul>
                    </div>
                </nav>

                <router-view>
                </router-view>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    computed:{
      loggedIn:{
        get(){
          return this.$store.state.currentUser.loggedIn
        }
      }
    },
    methods: {
     signOut(){
       this.$store.dispatch('currentUser/logoutUser');
    },
    }
}

</script>
