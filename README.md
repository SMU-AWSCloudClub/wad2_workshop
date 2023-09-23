# WAD2 Workshop:

This repository contains a full-stack web application with:

- Vue.js frontend code in `vuejs-frontend` folder
  - Vue components for posts - `Post.vue`, `PostEditor.vue`, `PostList.vue`
  - Router configuration
  - SCSS styles
  - Favicon and static assets
- PHP backend API in `php-backend` folder
  - CRUD operations on posts - `create.php`, `read.php`, `update.php`, `delete.php`
  - Database and CORS configuration
- GitHub Actions workflow for CI/CD in `.github/workflows`  
- Scripts for:
  - Database seeding - `seed.sql`
  - S3 upload - `upload2s3.sh`
  - Server setup - `user_data.sh`
- README and folder structure overview - `README.md`, `tree.txt`

The frontend allows users to create/view/edit blog posts by calling the backend PHP APIs. The app is configured for automated deployments using GitHub Actions.

Overall this is a full-stack web application with a Vue SPA frontend, PHP REST API backend, and automation scripts for CI/CD.#   w a d 2 _ w o r k s h o p  
 