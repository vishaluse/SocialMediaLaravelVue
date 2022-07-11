<template>
    <div>


       <div v-if="user">
           <post-create @fetch-post="fetchPost"></post-create>
       </div>




        <div class="alert alert-secondary" role="alert">
           ALL POSTS
        </div>


        <div  v-for="post in posts" v-bind:key="post.slug">
            <div class="shadow p-3 mb-5 bg-white rounded ">
                <div class="card-header"> Posted by <router-link :to="/dashboard/+post.user_id">{{post.user_id}}</router-link> </div>

                <div style="display: flex; justify-content: space-around; margin: 1px 76px 0px 674px;">
                    <router-link v-if="user && post.user_id === user.id" :to="'/postupdate/' + post.slug"><i class="fas fa-edit"></i></router-link>
                    <div style="cursor: pointer" v-if="user && post.user_id === user.id" @click="deletePost(post.slug)" ><i class="fa-solid fa-trash"></i></div>
                </div>

                <hr>
                <div class="card-body">

                    <div v-if="post.image">
                        <div class="col-span-4 lg:text-center  mb-5">
                            <img v-bind:src="'http://127.0.0.1:8000/storage' + post.image" alt="" class="object-cover h-60 w-105 rounded-xl">

                        </div>
                    </div>

                    <p class="mt-4 block text-gray-400 text-xs">
                        Published <time>{{ post.created_at }}</time>
                    </p>

                    <p class="card-text mt-2"> {{ post.body}} </p>

                    <div v-if="user">

                        <like  :post="post.id" :user="user.id"></like>





                        <a class="btn btn-primary" @click="ToggleComment('comment-'+post.id)">Comments</a><br>
                        <div style='display:none;' :id="'comment-'+post.id" >
                            <comment :post="post.id" ></comment>
                        </div>

                    </div>

                    <router-link :to="/post-detail/ + post.slug"><div class="mt-1 ml-2"> See the Post </div> </router-link><br>


                    <div v-if="user === null">

                        <figcaption class="blockquote-footer">
                            login or sign up to <cite title="Source Title">like and comment</cite>
                        </figcaption>
                    </div>



                </div>
            </div>

        </div>
    </div>
</template>


<script>

import Like from "./Like";
import PostCreate from "./PostCreate";
import Comment from "./Comment";
import $ from "jquery";

export default {
    data() {
        return {
            user: null,
            posts: [],
            post: {
                slug:"",
                body:"",
                user_id: 1,
                image: "",
            },
            article_id : "",
            createPostVar: false,

        }
    },
    mounted() {

        this.getUser();
        this.fetchPost();
    },
    methods: {

        getUser() {
            axios.get('/api/user' ).then((res)=>{
                this.user = res.data
            })
        },

        async fetchPost() {
            try {
                let response = await axios.get('api/postsapi')
                // console.log(response.data.data)
                this.displayPost(response.data.data)
            } catch (error) {
                console.log(error);
            }


        },
        displayPost(data) {
            this.posts = data;
            for (let i = 0; i < this.posts.length; i++) {
                if (this.posts[i].image) {
                    this.posts[i].image = this.posts[i].image.slice(6)
                }
            }

        },
        deletePost(slug) {
            if (confirm('Are you sure')) {
                axios.delete(`api/postapi/${slug}`)
                    .then(res => res.data)
                    .then(data => {
                        alert('Post Removed')
                        this.fetchPost()
                    })
            }
        },
        ToggleComment: function(txtDivID)
        {
            $("#"+txtDivID).toggle(400);
        },
    },
    components: {
        PostCreate,
        Like,
        Comment
    }


}

</script>
