<template>
  <div>
    <h1>Posts</h1>
    <Post v-for="post in posts" :key="post.id" :post="post" />
  </div>
</template>

<script>
import Post from './Post.vue'

export default {
  components: {
    Post
  },
  props: ['posts']
}
</script>