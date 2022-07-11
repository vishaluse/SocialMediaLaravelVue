<template>
    <div class="flex flex-wrap w-full justify-center items-center pt-5">
        <div class="flex flex-wrap max-w-xl">
            <div class="p-2 text-2xl text-gray-800 font-semibold"><h1>Login to your account</h1></div>
            <div class="p-2 w-full">
                <label for="email">Your e-mail</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Email" type="email" v-model="form.email" name="email">
                <span class="w-full text-red-500" v-if="errors.email">{{errors.email[0]}}</span>

            </div>
            <div class="p-2 w-full">
                <label for="password">Password</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Password" type="password" v-model="form.password" name="password">
                <span class="w-full text-red-500" v-if="errors.password">{{errors.password[0]}}</span>

            </div>
            <div class="p-2 w-full mt-4">
                <button @click.prevent="loginUser" type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Login</button>
            </div>
        </div>
    </div>
</template>
<script>



export default {
    data(){
        return{
            form:{
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods:{
        loginUser(){
            axios.post('/api/login', this.form).then(() =>{

                this.$router.push({ name: "Dashboard"});

            }).catch((error) =>{
                this.errors = error.response.data.errors;
                console.log(this.errors)
            })
        }
    }
}
</script>
