<template>
    <div class="shadow p-3 mb-5 bg-white rounded">
        <section class="px-6 py-8">
            <main class="max-w-6xl mx-auto mt-2 lg:mt-20 space-y-6">
                <div class="lg:flex justify-between mb-2 ml-20">
                    <a href="/">
                        Back to Home
                    </a>
                </div>
                <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">


                    <div class="col-span-7 lg:text-center lg:pt-14 mb-10">
                        <div v-if="post.image">
                            <img v-bind:src="'http://127.0.0.1:8000/storage' + post.image" alt="" class="object-cover h-90 w-130 rounded-xl">
                        </div>

                        <p class="mt-4 block text-gray-400 text-xs">
                            Published <time>{{ post.created_at }}</time>
                        </p>
                        <like v-if="dataLoaded" :post="post.id" ></like>

                    </div>

                    <div class="col-span-5">


                        <h1 class="font-bold text-3xl lg:text-4xl mb-10">
                            <router-link v-if="dataLoaded" :to="/dashboard/+post.user_id">{{user.name}}</router-link>'s Post
                        </h1>

                        <div class="space-y-4 lg:text-lg leading-loose">
                            <p>{{ post.body }}</p>
                        </div>

                    </div>


                    <section class="col-span-8 col-start-5 mt-10 space-y-6">


                        <comment v-if="dataLoaded" :post="post.id" ></comment>
                    </section>
                </article>

            </main>
        </section>

    </div>
</template>

<script>
import Like from "./Like";

export default {
    data() {
        return {
            user: {
                name:''
            },
            post : {
                id:'',
                image:null,
                user_id:'',
                body:'',

            },
            dataLoaded: false,
            TotalLikes: 0,
        }
    },
    mounted() {

        this.fetchPost()
    },
    methods: {
        fetchPost() {
            axios.get(`api/postapi/${this.$route.params.slug}`)
                .then((res) => {
                    this.post = res.data.data
                    this.dataLoaded = true
                    this.getUserInfo(this.post.user_id)
                    if(this.post.image) {
                        this.post.image = this.post.image.slice(6)
                    }
                })
        },
        getUserInfo(id) {
            axios.get(`api/user/${id}`)
                .then((res) => {
                    this.user = res.data.data[0]

                })
        },


    },
    components: {
        Like,
    }
}
</script>

