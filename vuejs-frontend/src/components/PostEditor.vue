<template>
        <form @submit.prevent="addPost">
                <input v-model="title">
                <textarea v-model="content"></textarea>

                <button>Add Post</button>
        </form>
</template>
      
<script>
export default {
        data() {
                return {
                        title: '',
                        content: ''
                }
        },

        methods: {
                addPost() {
                        this.$emit('submit', {
                                title: this.title,
                                content: this.content
                        })
                }
        }
}
</script>