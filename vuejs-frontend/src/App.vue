<style scoped>
img {
  max-width: 100%;
  height: auto;
}
</style>
<template>
  <div id="app" class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">

        <!-- Header -->
        <h1 class="mb-4 text-center mt-4">📔 Todos List</h1>

        <!-- Loading state -->
        <div v-if="loading" class="alert alert-info">
          <p class="text-center">Loading todos.. </p>
        </div>

        <!-- Empty state -->
        <div v-if="!posts.length">
          <p class="text-center">Your List is empty... </p>
        </div>

        <!-- Todos List -->
        <div v-else>
          <div v-for="post in posts" class="card mb-3 border-primary">
            <div class="card-body rounded-3">
              <!-- Non-editing state -->
              <div v-if="editingPostId !== post.id" class="p-3">
                <h2 class="card-title text-break">{{ post.title }}</h2>
                <img v-if="post.imageURL" :src="post.imageURL" alt="Post image" class="img-fluid">
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

              <!-- Editing state -->
              <div v-else>
                <div class="container pt-3">
                  <div class="form-group">
                    <input v-model="editingPost.title" class="form-control w-100" placeholder="Title">
                  </div>
                  <div class="form-group">
                    <textarea v-model="editingPost.content" class="form-control w-100" placeholder="Content"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="editImageUpload" class="form-label">Upload New Image</label>
                    <input type="file" class="form-control w-100" id="editImageUpload" v-on:change="handleImageUpload($event, 'edit')" accept=".png, .jpg, .jpeg">
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button @click="updatePost(editingPost)" class="btn btn-primary w-100 m-3">Save</button>
                  </div>
                  <div class="col-6">
                    <button @click="cancelEdit" class="btn btn-secondary w-75 m-3">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Divider -->
        <hr class="shadow-sm">

        <!-- Add Todo Form -->
        <form @submit.prevent="addPost" class="p-4 rounded">
          <div class="form-group col-md-6 mx-auto pb-2 w-100">
            <input v-model="newPost.title" class="form-control form-control-lg border-0 shadow-sm w-100 rounded" placeholder="Title">
          </div>
          <div class="form-group col-md-6 mx-auto w-100">
            <textarea v-model="newPost.content" class="form-control form-control-lg border-0 shadow-sm w-100 rounded" placeholder="What do you need to do?" rows="5"></textarea>
          </div>
          <div class="form-group col-md-6 mx-auto w-100 pb-2">
            <label for="imageUpload" class="form-label">Upload Image</label>
            <input type="file" class="form-control form-control-lg border-0 shadow-sm w-100 rounded" id="imageUpload" v-on:change="handleImageUpload" accept=".png, .jpg, .jpeg">
          </div>
          <div class="form-group col-md-3 mx-auto w-100">
            <button class="btn btn-primary btn-block rounded shadow-sm w-100">Add Post</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>
    
<!-- Frontend script for pulling the data from our backend! -->
<script>
import axios from 'axios'
// import AWS from 'aws-sdk';
// import AWS from 'aws-sdk/dist/aws-sdk'
// AWS.config.update({
//   region: 'ap-southeast-1', // your AWS region
//   accessKeyId: '', // your AWS access key ID
//   secretAccessKey: '' // your AWS secret access key
// })

export default {

  data() {
    return {
      posts: [],
      newPost: {
        title: '',
        content: '',
        image: ''
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
      const response = await axios.get('http://localhost:8000/2read.php')
      this.posts = response.data
      this.loading = false
    },

    handleImageUpload(event, type) {
      // Check if the event contains an image, if so assign it to newPost.image or editingPost.image
      if (event.target.files.length > 0) {
        if (type === 'edit') {
          this.editingPost.image = event.target.files[0];
        } else {
          this.newPost.image = event.target.files[0];
        }
      }
    },

    async addPost() {
      console.log('Adding post here..')
      const formData = new FormData();
      formData.append('image', this.newPost.image);
      formData.append('title', this.newPost.title);
      formData.append('content', this.newPost.content);

      const response = await axios.post('http://localhost:8000/1create.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      // const response = await axios.post('http://localhost:8000/1create.php', this.newPost, {
      //   headers: {
      //     // 'Content-Type': 'application/x-www-form-urlencoded'
      //     'Content-Type': 'multipart/form-data' // have to use this for images!
      //   }
      // });

      // const file = this.newPost.image // the image file to upload
      // const params = {
      //   Bucket: 'bchewy-images', // your S3 bucket name
      //   Key: 'todos/' + file.name, // the name of the file in S3
      //   Body: file, // the file itself
      //   ACL: 'public-read' // to make the file publicly readable
      // }
      // s3.upload(params, function (err, data) {
      //   if (err) {
      //     console.log(err)
      //   } else {
      //     console.log('File uploaded successfully', data.Location)
      //   }
      // })

      const newPost = {
        id: response.data, // ID from API
        title: this.newPost.title,
        content: this.newPost.content,
        imageURL: this.newPost.imageURL
      }
      console.log(newPost)
      this.posts.push(newPost)
      this.newPost = { title: '', content: '', image: '' }
      await this.fetchPosts();
    },

    async deletePost(id) {
      await axios.post('http://localhost:8000/4delete.php', { id }, {
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
      console.log('Updating post here')
      const formData = new FormData();
      formData.append('id', updatedPost.id);
      formData.append('title', updatedPost.title);
      formData.append('content', updatedPost.content);

      if (updatedPost.image) {
        formData.append('image', updatedPost.image);
      }

      const response = await axios.post('http://localhost:8000/3update.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      console.log(response.data);

      const index = this.posts.findIndex(x => x.id === updatedPost.id)
      console.log(index);
      console.log(updatedPost);
      this.posts[index] = { ...updatedPost, imageURL: updatedPost.image }
      this.editingPost = null
      this.editingPostId = null
      await this.fetchPosts();
    }
  }

}
</script>
