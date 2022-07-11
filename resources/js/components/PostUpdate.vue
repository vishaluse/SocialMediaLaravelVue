<template>

    <div>

            <div class="flex flex-wrap w-full justify-center items-center pt-5">

                <div class="flex flex-wrap max-w-xl">


                    <div class="p-2 w-full">

                        <textarea class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="write here" v-model="post.body" required></textarea>
                        <button type="submit" @click.prevent="updatePost" class="btn btn-primary">update</button>
                        <input type="hidden" name="_method" value="PUT">
                    </div>

                    <div class="flex flex-wrap max-w-xl mt-4">
                        <like v-if="dataLoaded" :post="post.id"></like>
                        <comment v-if="dataLoaded" :post="post.id" ></comment>
                    </div>
                </div>
            </div>



    </div>
</template>

<script>
import Comment from "./Comment";
import Like from "./Like";

export default {

    data() {
        return {
            post: {
                id:'',
                slug:  this.$route.params.slug ,
                body: '',
                user_id: '',
                like:''
            },
            dataLoaded:false,
            TotalLikes: 0,
        }
    },
    mounted() {
        this.fetchData()
    },
    methods : {
        fetchData() {
            axios.get(`api/postapi/${this.post.slug}`)
                .then((res) => {
                    this.dataLoaded = true
                    this.post = res.data.data

                    if(this.post.image !== null) {
                        this.uploadString = 'wanna change the image?'
                    }
                })
        },
        updatePost() {

            // const fd = new FormData();
            // fd.append('body', this.post.body)
            // fd.append('user_id', this.post.user_id)

            // if(this.uploadString === 'Selected a file') {
            //     fd.append('image', this.post.image, this.post.image.name)
            // } else {
            //     fd.append('image', null)
            // }


            axios.put(`api/postapi/update/${this.$route.params.slug}`, this.post)
                .then((res) => {

                    console.log('successfully updated')
                    this.$router.push({ name: "create"});
                })
        },



        // calculateTotalLikes(post) {
        //
        // }


    },
    components: {
        Like,
        Comment,
    }

}
</script>
