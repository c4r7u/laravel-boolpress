<template>
    <section>
        <div class="container">
            <h1>Lista tags</h1>

            <ul class="list-group">
                <li v-for="tag in tags" :key="tag.id" class="list-group-item d-flex justify-content-between align-items-center">
                    <router-link :to="{ name: 'tag-details', params: { slug: tag.slug } }">{{ tag.name }}</router-link>
                    <span class="badge bg-warning rounded-pill">{{ tag.related_posts_number }}</span>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
export default {
    name: 'TagsList',
    data: function() {
        return {
            tags: []
        };
    },
    methods: {
        getTags: function() {
            axios.get('/api/tags')
            .then((response) => {
                this.tags = response.data.results;
            });
        }
    },
    created: function() {
        this.getTags();
    }
}
</script>