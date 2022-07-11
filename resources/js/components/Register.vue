<template>
    <div class="flex flex-wrap w-full justify-center items-center pt-5">
        <div class="flex flex-wrap max-w-xl">
            <div class="p-2 text-2xl text-gray-800 font-semibold"><h1>Register an account</h1></div>
            <div class="p-2 w-full">
                <label class="w-full" for="name">Name</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Name" type="text" v-model="form.name" name="name">
            </div>

            <div class="p-2 w-full">
                <label class="w-full" for="username">Username</label>

                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Username" type="text" v-model="form.username" name="username">
                <span class="w-full text-red-500" v-if="errors.username">{{errors.username[0]}}</span>

            </div>

            <div class="p-2 w-full">
                <label for="email"> e-mail</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Email" type="email" v-model="form.email" name="email">
                <span class="w-full text-red-500" v-if="errors.email">{{errors.email[0]}}</span>

            </div>

            <div class="p-2 w-full">
                <label for="email"> Profile Photo</label>
                <div class="mb-3" >
                    <input class="form-control" style="display: none" type="file" id="image" name="image" @change="onFileSelected"  ref="fileInput">
                </div>
                <button class="btn btn-outline-primary mb-2" @click="$refs.fileInput.click()"> {{ uploadString }} </button><br>
            </div>

            <div class="p-2 w-full">
                <label for="password">Password</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Password" type="password" v-model="form.password" name="password">
                <span class="w-full text-red-500" v-if="errors.password">{{errors.password[0]}}</span>
            </div>
            <div class="p-2 w-full">
                <label for="confirm_password">Confirm Password</label>
                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Confirm Password" type="password" v-model="form.password_confirmation" name="password_confirmation">

            </div>
            <div class="p-2 w-full mt-4">
                <button @click.prevent="saveForm" type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Register</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            form:{
                name: '',
                email: '',
                username: '',
                image:'',
                password:'',
                password_confirmation:''
            },
            errors:[],
            uploadString: 'upload your photo'
        }
    },
    methods:{
        saveForm(){
            const fd = new FormData();
            fd.append('name', this.form.name)
            fd.append('email', this.form.email)
            fd.append('username', this.form.username)
            fd.append('image', this.form.image)
            fd.append('password', this.form.password)
            fd.append('password_confirmation', this.form.password_confirmation)


            axios.post('/api/register', fd).then(() =>{
                this.$router.push({ name: "index"});
            }).catch((error) =>{
                this.errors = error.response.data.errors;
                console.log(this.errors)
            })
        },
        onFileSelected(event) {
            this.form.image = event.target.files[0];
            this.uploadString = "Selected a file, Cool let's go"

        }
    }
}
</script>
