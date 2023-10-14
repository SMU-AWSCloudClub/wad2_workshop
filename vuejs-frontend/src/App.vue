<template>
  <div id="app" class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">

        <h1 class="mb-4 text-center mt-4">📔 Todos List</h1>

        <div v-if="loading" class="alert alert-info">
          <p class="text-center">Loading todos.. </p>
        </div>
        <div v-if="!posts.length">
          <p class="text-center">Your List is empty... </p>
        </div>

        <div v-else>
          <div v-for="post in posts" class="card mb-3 border-primary">

            <div class="card-body rounded-3" style="background-color:;">
              <div v-if="editingPostId !== post.id" class="p-3">
                <h2 class="card-title text-break">{{ post.title }}</h2>
                <p class="card-text text-break" style="overflow-y: auto; max-height: 150px;">{{ post.content }}</p>

                <div class="row">
                  <div class="col-6">
                    <button @click="editPost(post)" class="btn btn-primary me-2 w-100">Edit</button>

                  </div>
                  <div class="col-6">
                    <button @click="deletePost(post.id)" class="btn btn-danger w-100">Delete</button>

                  </div>
                </div>

              </div>
              <div v-else>
                <div class="container pt-3">
                  <div class="form-group">
                    <input v-model="editingPost.title" class="form-control w-100" placeholder="Title">
                  </div>
                  <div class="form-group">
                    <textarea v-model="editingPost.content" class="form-control w-100" placeholder="Content"></textarea>
                  </div>
                </div>


                <div class="row">
                  <div class="col-6">
                    <button @click="updatePost(editingPost)" class="btn btn-pri me-2 w-100 m-3">Save</button>
                  </div>
                  <div class="col-6">
                    <button @click="cancelEdit" class="btn btn-sec w-75 m-3">Cancel</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <hr class="shadow-sm">

        <form @submit.prevent="addPost" class=" p-4 rounded">

          <div class="form-group col-md-6 mx-auto pb-2 w-100">
            <input v-model="newPost.title" class="form-control form-control-lg border-0 shadow-sm w-100 rounded"
              placeholder="title">
          </div>
          <div class="form-group col-md-6 mx-auto w-100">
            <textarea v-model="newPost.content" class="form-control form-control-lg border-0 shadow-sm w-100 rounded"
              placeholder="what do you need to do?" rows="5"></textarea>
          </div>

          <div class="form-group col-md-3 mx-auto w-100">
            <button class="btn btn-primary btn-block rounded shadow-sm w-100">
              Add Post
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
</template>
    
<!-- Frontend script for pulling the data from our backend! -->
<script>
import axios from 'axios'

export default {

  data() {
    return {
      posts: [],
      newPost: {
        title: '',
        content: ''
      },
      loading: false,
      editingPostId: null
    }
  },

  created() {
    this.fetchPosts()
  },

  methods: {

    async fetchPosts() {
      this.loading = true
      const response = await axios.get('http://workshopnumber.bchwy.com/2read.php')
      this.posts = response.data
      this.loading = false
    },

    async addPost() {
      const response = await axios.post('http://workshopnumber.bchwy.com/1create.php', this.newPost, {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });

      const newPost = {
        id: response.data, // ID from API
        title: this.newPost.title,
        content: this.newPost.content,
      }
      console.log(newPost)
      this.posts.push(newPost)
      this.newPost = { title: '', content: '' }
    },

    async deletePost(id) {
      await axios.post('https://workshopnumber.bchwy.com/4delete.php', { id }, {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });

      this.posts = this.posts.filter(x => x.id !== id)
    },

    editPost(post) {
      this.editingPost = { ...post }
      this.editingPostId = post.id
    },
    cancelEdit() {
      this.editingPostId = null
      this.editingPost = null
    },

    async updatePost(updatedPost) {
      await axios.post('http://workshopnumber.bchwy.com/3update.php', updatedPost, {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
      const index = this.posts.findIndex(x => x.id === updatedPost.id)
      this.posts[index] = updatedPost
      this.editingPost = null
      this.editingPostId = null
    }
  }

}
</script>
