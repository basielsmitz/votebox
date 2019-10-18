<template>
    <div id="parties" class="container">
        <div v-if="loading"  class="loader"></div>
        <div class="card-field">
            <div class="standard-card" v-for="party in parties">
                <div class="card-wrapper">
                    <router-link :to="{ name: 'party', params: { id: party.id }}">
                        <div class="card">
                            <figure>
                                <img :src="party.pictureUri">
                            </figure>
                            <h1>{{party.name}}</h1>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                parties: [],
                filterQuery: '',
                checkboxValues: [],
                loading: true,

            }
        },

        methods: {
            /**load all parties*/
            loadData() {
                this.axios.get('/api/parties').then((response) => {
                    this.parties = response.data;
                this.stopLoading();

            });
            },
            /**stop loading animation*/
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 1500);
            }
        },

        computed: {
            /**filter parites by keyword*/
            filterByName() {
                return this.parties.filter( party => {
                    return party.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 && party.isClosed == value;
                })
            }
        },

        mounted() {
            this.loadData();
            console.log('Elections mounted.');
        }
    }

</script>