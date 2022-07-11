<template>

    <div>
        <div v-if="user">
            <textarea class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2 mt-2" name="body"  id="body" cols="100" rows="2" v-model="comment.body" placeholder="comment here">

            </textarea>
            <button class="btn btn-success" @click="addComment">Comment</button>
        </div>


        <button class="btn btn-primary mt-2" @click="showComment = !showComment">{{ commentText }}</button>

        <div v-if="showComment">

            <div class="card mt-4" v-for="cmnt in Comments" v-bind:key="comment.id">
                <div class="card-header">
                    <router-link :to="'/dashboard/'+cmnt.user_id">{{ cmnt.user_id }}</router-link>
                </div>
                <div class="card-body ">
                    <p class="card-text">{{ cmnt.body }} </p>
                    <div v-if="cmnt.user_id === comment.user_id">
                        <div style="cursor:pointer;" @click="deleteComment(cmnt.id)" ><i class="fa-solid fa-trash"></i></div>
                    </div>
                </div>
            </div>
            <div v-if="Comments.length === 0"> No comments yet</div>
        </div>

    </div>




</template>

<script>
export default {

    props: ['post'],

    data() {
        return {
            user:null,
            comment: {
                user_id:'',
                post_id:'',
                body: '',
            },
            showComment: false,
            Comments: [], // collection of comments for a single post which it belongs
            commentText:  ''
        }
    },
    mounted() {

        this.comment.post_id = this.post
        this.getUser()


    },
    watch : {
        showComment(oldValue, newValue) {
            if(newValue) {
                this.commentText = 'Show Comments'
            } else {
                this.commentText = 'Hide Comments'
            }
        }
    },
    methods: {
         getUser() {
             axios.get('/api/user' ).then((res)=>{
                this.comment.user_id = res.data.id
                // console.log(res.data)
                 this.user = res.data

            }).catch(error => {
                console.log(error)
             })

             this.fetchAllComment()
        },

        addComment() {
            axios.post('/api/comment', this.comment)
                .then((res) => {
                    console.log('comment added')
                    this.comment.body = ''
                    this.fetchAllComment()
                })
        },
        fetchAllComment() {
             axios.get(`/api/comment/${this.post}`)
                 .then((res) => {
                     this.showComment = true
                     this.Comments = res.data.data
                     // console.log(this.co)
                 })
        },
        deleteComment(id) {
            if (confirm('Are you sure you want to delete this comment')) {
                axios.delete(`api/comment/${id}`)
                    .then(res => res.data)
                    .then(data => {
                        alert('Comment Removed')
                        this.fetchAllComment()
                    })
            }
        },



    }
}
</script>

