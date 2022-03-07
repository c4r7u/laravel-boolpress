<template>
    <div>
        <Newsletter />
        <section>
            <div class="container">
                <h1>Ciao sono la homepage</h1>
            </div>
        </section>
    </div>
</template>

<script>
import Newsletter from '../components/Newsletter.vue';

export default {
    name: 'Home',
    components: {
        Newsletter
    }
}
</script>