<template>
    <div>

            <div class="flex flex-wrap w-full justify-center items-center pt-5">
                <div class="flex flex-wrap max-w-xl">
                    <div class="p-2 w-full">
                        <div class="mb-3" >
                            <input class="form-control" style="display: none" type="file" id="image" name="image" @change="onFileSelected"  ref="fileInput">
                        </div>
                        <button class="btn btn-outline-primary mb-2" @click="$refs.fileInput.click()"> {{ uploadString }} </button><br>
                    </div>

                    <div class="p-2 w-full">

                        <textarea name="body" class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="write here" v-model="post.body" required></textarea>
                    </div>
                    <button type="submit"  @click.prevent="createPost" class="btn btn-primary">create</button>
                </div>


            </div>

        <div>

            <div style="cursor:pointer;" @click="showUserPosts = !showUserPosts" class="alert alert-info mt-2 mb-2 w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" role="alert">
                check out your posts &nbsp;
                <div style="display: inline;" v-if="!showUserPosts">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <div style="display: inline;" v-else>
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
            </div>

            <div v-if="showUserPosts">
                <div v-if="userPosts.length" class="row row-cols-1 row-cols-md-3 g-4" style="justify-content: space-around">
                    <div class="shadow p-3 mb-5 bg-white rounded col" v-for="post in userPosts" v-bind:key="post.slug" style="width: 18rem;">
                        <div v-if="post.image">
                            <img :src="'http://127.0.0.1:8000/storage' + post.image" class="card-img-top" alt="...">
                        </div>
                        <div v-else>
                            <img src="https://static.thenounproject.com/png/1728394-200.png" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Post Info</h5>
                            <p class="card-text">{{ post.body }}</p>
                            <div style="display: flex; justify-content: space-evenly">
                                <router-link :to="'/post-detail/' + post.slug"><i class="fa-regular fa-eye"></i></router-link>
                                <router-link :to="'/postupdate/' + post.slug"><i class="fas fa-edit"></i></router-link>
                                <div style="cursor: pointer" @click="deletePost(post.slug)" ><i class="fa-solid fa-trash"></i></div>
                            </div>

                        </div>
                        <p class="mt-4 block text-gray-400 text-xs">
                            Published <time>{{ post.created_at }}</time>
                        </p>

                    </div>
                </div>
                <div v-else>
                    There's no post yet
                </div>
            </div>


        </div>

    </div>



</template>

<script>


export default {
    emits : ['fetch-post'],
    data() {
        return {
            user: null,
            post: {
                slug: '',
                body: '',
                user_id: '',
                image: null,
            },
            userPosts: [],
            selectedFile:null,
            uploadString: 'Want to upload an Image?',
            showUserPosts: false,
        }
    },
    mounted() {
        this.getUser();
    },
    methods: {
        createPost() {
            const fd = new FormData();
            fd.append('body', this.post.body)
            fd.append('user_id', this.post.user_id)
            fd.append('image', this.post.image)


            axios.post('api/postapi', fd)
                .then(data => {
                    console.log(data.data)
                    // this.post.slug = ""
                    this.post.body = ""
                    alert('a post is created')
                    this.$emit("fetch-post");
                    this.fetchPost()
                })
        },

         getUser() {
             axios.get('/api/user' ).then((res)=>{

                 this.user = res.data
                 this.post.user_id = this.user.id
                 this.fetchPost()
            })
        },


        deletePost(slug) {
            console.log(this.userPosts.data)

                axios.delete(`api/postapi/${slug}`)
                    .then(res =>  res.data)
                    .then(data => {
                        alert('Post Removed')
                        this.fetchPost()
                        this.$emit('fetch-post')
                    })

        },
        fetchPost() {
            axios.get(`api/postapi/details/${this.post.user_id}` )
                .then((res) => {

                    this.displayPost(res.data.data)
                })
        },
        displayPost(data) {
            this.userPosts = data
            for (let i = 0; i < this.userPosts.length; i++) {
                if (this.userPosts[i].image) {
                    this.userPosts[i].image = this.userPosts[i].image.slice(6)
                }
            }


        },
        onFileSelected(event) {
            this.post.image = event.target.files[0];
            this.uploadString = "Selected a file, Cool let's go"
            // console.log(this.post.image);
        }


    },
    watch: {
        showUserPosts(oldValue, newValue) {
            if(newValue) {
                this.fetchPost()
            }
        }
    }

}
</script>

