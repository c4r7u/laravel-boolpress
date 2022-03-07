<template>
    <section>
        <div class="container">
            <h1>{{ post.title }}</h1>

            <div v-if="post.category">Category: {{ post.category.name }}</div>

            <div v-if="post.tags && post.tags.length > 0">
                <router-link 
                v-for="tag in post.tags" 
                :key="tag.id"
                class="badge bg-warning text-dark mx-1"
                :to="{ name: 'tag-details', params: { slug: tag.slug } }"
                >
                    {{ tag.name }}
                </router-link>
            </div>

            <img v-if="post.cover" :src="post.cover" class="card-img-top" alt="post.title">

            <p>{{ post.content }}</p>
        </div>
    </section>
</template>

<script>
export default {
    name: 'PostDetails',
    data: function() {
        return {
            post: {}
        };
    },
    methods: {
        getPost() {
            axios.get('/api/posts/' + this.$route.params.slug)
            .then((response) => {
                if(response.data.success) {
                    this.post = response.data.results;
                } else {
                    this.$router.push({ name: 'not-found' });
                }
            });
        }
    },
    created: function() {
        this.getPost();
    }
}
</script>
