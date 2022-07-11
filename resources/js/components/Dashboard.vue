<template>
    <div>

        <div >
            <div v-if="user.image">
                <img v-bind:src="'http://127.0.0.1:8000/storage' + user.image" alt="" class="h-30 w-60 rounded mx-auto d-block">
            </div>
            <div v-else>
                <img src="https://t4.ftcdn.net/jpg/03/46/93/61/360_F_346936114_RaxE6OQogebgAWTalE1myseY1Hbb5qPM.jpg" alt="" class="rounded mx-auto d-block">
            </div>

            <div >

                <div v-if="user.name && $route.params.id && user.id != $route.params.id">
                    <div v-if="following">
                        <a style="cursor: pointer" @click.prevent="deleteFollowingData(profileData.id)"><i class="fa-solid fa-user-check fa-2x"></i></a>
                        <br><span class="w-full text-blue-500" > you are now following {{visitor.name}}</span>
                    </div>

                    <div v-if="!following">
                        <a style="cursor: pointer" @click.prevent="addFollowing"><i class="fas fa-user-plus fa-2x"></i></a>
                        <br><span class="w-full text-red-500" > you are currently not following this profile</span>
                    </div>
                </div>
                <div v-else-if="user.name">
                    <figcaption class="blockquote-footer">
                        You are all set!
                    </figcaption>
                </div>
                <div v-else>
                    <figcaption class="blockquote-footer">
                        login or sign up  <cite title="Source Title" >to follow this profile</cite>
                    </figcaption>
                </div>

                <div v-if="visitor">
                    Name: {{visitor.name}} <br>
                    Email: {{visitor.email}}<br><br>
                </div>
                <div v-else>
                    Name: {{user.name}} <br>
                    Email: {{user.email}}<br><br>
                </div>

                <button v-if="user.name" @click="toggleSection('editId')" type="button" class="btn btn-outline-primary">Edit Profile</button>
                <button @click="toggleSection('FollowerId')" type="button" class="btn btn-outline-success">Follower</button>
                <button @click="toggleSection('FollowingId')" type="button" class="btn btn-outline-info">Following</button>


                <div style='display:none;' id="editId">
                    <div class="flex flex-wrap w-full justify-center items-center pt-5">
                        <div class="flex flex-wrap max-w-xl">
                            <div class="p-2 text-2xl text-gray-800 font-semibold mb-2"><h1>Edit Your Details</h1></div>
                            <span class="w-full text-green-500" v-if="updated">Your Profile is updated</span>

                            <div class="p-2 w-full mt-2">
                                <label class="w-full" for="name">Name</label>
                                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Name" type="text" v-model="user.name" >

                            </div>

                            <div class="p-2 w-full">
                                <label class="w-full" for="username">Username</label>
                                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Name" type="text" v-model="user.username" required>
<!--                                <span class="w-full text-red-500" > {{ errors.username[0] }} </span>-->
                            </div>

                            <div class="p-2 w-full">
                                <label for="email"> e-mail</label>
                                <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Email" type="email" v-model="user.email" required>
<!--                                <span class="w-full text-red-500" > {{ errors.email[0] }} </span>-->
                            </div>

                            <div class="p-2 w-full mt-4">
                                <button @click.prevent="updateUser" type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div style='display:none;' id="FollowerId">
                    follower
                </div>
                <div style='display:none;' id="FollowingId">
                    following
                </div>


            </div>
        </div>


    </div>
</template>
<script>
import $ from "jquery";

export default {
    data(){
        return{
            user: {
                id: '',
                name: '',
                username: '',
                email: ''
            },
            errors:[],
            updated: false,
            visitor: null,
            following: false,
            profileData: {
                user_id: '',
                follower_id: null,
                following_id: null
            }
        }
    },

    mounted(){

        if(this.$route.params.id ) {
            this.profileData.following_id = this.$route.params.id;
            this.getUserProfileDetail();
        }

        this.getUser()

    },
    methods: {
        toggleSection: function(txtDivID) {
            $("#"+txtDivID).toggle(400);
        },
        updateUser() {
            axios.put(`api/user/update/${this.user.id}`, this.user)
                .then((res) => {
                    this.updated = true;
                    console.log('successfully updated user')
                }).catch((error) =>{
                    this.errors = error.response.data.errors;

                })

        },
        getUserProfileDetail() {
            axios.get(`api/user/${this.$route.params.id}`)
                .then((res) => {
                    this.visitor = res.data.data[0]

                })
        },
        getUser() {
            axios.get('/api/user').then((res)=>{
                this.user = res.data
                // console.log(this.$route.params.id, this.user.id, this.$route.params.id !== this.user.id)

                this.profileData.user_id = this.user.id
                if(this.user.image) {
                    this.user.image = this.user.image.slice(6)
                }
                this.fetchProfileData()

            })
        },
        addFollowing() {
            axios.post(`api/following/${this.user.id}`, this.profileData)
                .then((res) => {
                    console.log(res.data.data)
                    this.profileData = res.data.data
                    this.following = true
                })
        },
        fetchProfileData() {
            axios.get(`api/following/profile/${this.user.id}`)
                .then((res) => {
                    console.log(res.data.data)
                    this.getFollowingData(res.data.data)
                })
        },
        getFollowingData(data) {
            console.log(data[0].follower_id)
            for(let i = 0; i < data.length; i++) {
                if(data[i].following_id == this.$route.params.id) {
                    this.profileData = data[i];
                    this.following = true;
                }
            }
        },
        deleteFollowingData(id) {
            axios.delete(`api/following/delete/${id}`)
                .then(res => res.data)
                .then(data => {
                    this.following = false;
                    this.profileData.user_id = this.user.id
                    this.profileData.following_id = this.$route.params.id
                    this.profileData.follower_id = null

                })
        }
    }
}
</script>
