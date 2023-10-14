import VueRouter from 'vue-router';
import PostList from '@/components/PostList';
import Post from '@/components/Post';
import PostEditor from '@/components/PostEditor';

// If you're reading this page, pretty sure this vueJS router page isn't being used! - Brian

const routes = [
        {
                path: '/',
                component: PostList
        },
        {
                path: '/post/:id',
                component: Post
        },
        {
                path: '/new',
                component: PostEditor
        },
        {
                path: '/edit/:id',
                component: PostEditor
        }
]