<template>
    <div class="container">
        <div id="success" class="mb-3">

        </div>
                <div>
                    <div v-if="user_id">
                        <div v-if="likeAdded">
                            <a style="cursor: pointer" @click.prevent="deleteLike(like.id)"><i class="fa-solid fa-thumbs-up">  </i></a>
                            Liked
                        </div>
                        <div v-if="!likeAdded">
                            <a style="cursor: pointer" @click.prevent="addLike"><i class="fa-regular fa-thumbs-up"></i></a>
                        </div>
                        <p>{{ TotalLikes }} people liked it</p>
                    </div>
                    <div v-else>
                        <figcaption class="blockquote-footer">
                            login or sign up to <cite title="Source Title">like and comment</cite>
                        </figcaption>
                    </div>

                </div>
    </div>

</template>

<script>
export default {
    props: ['post', 'user'],

    data() {
        return {
            // user: null,
            like: {
                id:'',
                user_id:'',
                post_id:'',
                count: 0,
            },
            likes: [],
            likeAdded : false,
            TotalLikes: 0, // collection of like for a single post which it belongs
            user_id: '',
        }
    },
    mounted() {
        this.like.post_id = this.post
        if(this.user) {
            this.like.user_id = this.user; // this.user will only provide id
            this.user_id = this.user
            this.fetchAllLikes()
        } else {
            this.getUser()
        }

    },
    methods: {
        getUser() { // its avoidable
            axios.get('/api/user' ).then((res)=>{
                // this.user = res.data
                this.user_id = res.data.id
                this.like.user_id = res.data.id
                // console.log(this.post.user_id)
                this.$emit("fetch-like");
                this.fetchAllLikes()
            })
        },

        addLike() {
            axios.post('/api/like', this.like)
                .then((res) => {
                    this.likeAdded = true;
                    this.fetchAllLikes()
                })
        },
        fetchAllLikes() {
            axios.get(`/api/like/${this.post}`)
                .then((res) => {
                    // console.log(res.data.data);
                    this.likes = res.data.data
                    this.calculateTotalLikes(this.likes);
                })
        },
        calculateTotalLikes(likes) {
            this.TotalLikes = 0
            for(let i = 0; i < likes.length; i++) {
                this.TotalLikes += likes[i].count;
                if(likes[i].user_id === this.like.user_id) {
                    this.likeAdded = true;
                    this.like = likes[i]
                }
            }

        },
        deleteLike(id) {

                axios.delete(`api/like/delete/${id}`)
                    .then(res => res.data)
                    .then(data => {
                        this.likeAdded = false;
                        this.like.user_id = this.user_id
                        this.like.post_id = this.post
                        this.like.count = 0
                        this.fetchAllLikes()
                    })

        }
    }
}
</script>
