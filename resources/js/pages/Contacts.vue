<template>
    <div>
        <section>
            <div class="container">
                <h1>Contattaci</h1>

                <div v-if="success">Grazie per averci contattato, email inviata</div>

                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input v-model="email" type="email" class="form-control" id="email">
                    </div>

                    <div v-if="errors.email">
                        <p v-for="(error, index) in errors.email" :key="index">{{ error }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input v-model="name" type="text" class="form-control" id="name">
                    </div>

                    <div v-if="errors.name">
                        <p v-for="(error, index) in errors.name" :key="index">{{ error }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Messaggio</label>
                        <textarea v-model="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <div v-if="errors.message">
                        <p v-for="(error, index) in errors.message" :key="index">{{ error }}</p>
                    </div>

                    <button type="submit" @click.prevent="sendMessage()" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    name: 'Contacts',
    data: function() {
        return {
            email: '',
            name: '',
            message: '',
            success: false,
            errors: {}
        };
    },
    methods: {
        sendMessage: function() {
            axios.post('/api/leads/store', {
                email: this.email,
                name: this.name,
                message: this.message
            })
            .then((response) => {
                if(response.data.success) {
                    // Tutto ok
                    this.name = '';
                    this.email = '';
                    this.message = '';
                    this.success = true;
                    this.error = {};
                } else {
                    // Ci sono errori di validazione
                    this.success = false;
                    this.errors = response.data.errors
                }
            });
        }
    }
}
</script>