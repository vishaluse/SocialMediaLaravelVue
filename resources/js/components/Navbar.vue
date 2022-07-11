<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <router-link  class="navbar-brand" to='/' exact>Home</router-link>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <router-link class="nav-link mr-4 active" to='/postcreate' exact>Create</router-link>
                        </li>

                        <template v-if="user">
                            <li class="nav-item">
                                <router-link class="nav-link mr-4 active" to='/dashboard' exact>Dashboard</router-link>
                            </li>
                            <li style="cursor: pointer" class="nav-link mr-4 active router-link-exact-active router-link-active" @click.prevent="logout">
                                Logout
                            </li>
                        </template>

                        <template v-else>
                            <li class="nav-item" >
                                <router-link to="/loginapi" class="nav-link mr-4 active">Login</router-link>
                            </li>

                            <li class="nav-item" >
                                <router-link to="/registerapi" class="nav-link mr-4 active">Register</router-link>
                            </li>
                        </template>
                    </ul>
                    <form class="d-flex">

                        <div v-if="dataLoaded" class="nav-item">Hello, {{user.name}}</div>
                    </form>
                </div>
            </div>
        </nav>


    </div>

</template>

<script>
export default {
    data() {
        return {
            user: null,
            dataLoaded: false,
        }
    },
    mounted() {
        axios.get('/api/user').then((res)=>{
            this.user = res.data
            this.dataLoaded = true
        })


    },
    methods:{
        logout(){
            axios.post('/api/logout').then(()=>{
                this.user = null
                this.dataLoaded = false
                this.$router.push({ name : 'Login'})
            })
        }
    },
}

</script>
