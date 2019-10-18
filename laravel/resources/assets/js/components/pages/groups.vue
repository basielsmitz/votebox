<template>
    <div id="groups" class="container">
        <div v-if="loading"  class="loader"></div>
        <h1>Groepen</h1>
        <paginate-links for="items"></paginate-links>
        <paginate
                name="groups"
                :list="items"
                :per="6"
        >
            <div class="card-field">
                <div class="standard-card" v-for="item in paginated('groups')">
                    <router-link :to="{ name: 'group', params: { id: item.id }}">
                        <div class="card-wrapper">
                            <div class="card">
                                <figure>
                                    <img :src="item.pictureUri">
                                </figure>
                                <h1>{{item.name}}</h1>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </paginate>
        <paginate-links for="groups" :limit="5"></paginate-links>
    </div>

</template>


<script>
    export default {

        data() {
            return {
                items: [],
                paginate: ['groups'],
                loading: true,

            }
        },

        methods: {
            /**get all groups*/
            loadData: function () {
                this.axios.get('/api/groups').then((response) => {
                    this.items = response.data;
                this.stopLoading();

            });
            },
            /**stop the loading animation*/
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 1500);
            }
        },

        mounted() {
            this.loadData();
            console.log('Referenda mounted.');
        }
    }
</script>