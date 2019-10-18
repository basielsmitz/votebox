<template>
    <div id="party" class="container">
        <div v-if="loading"  class="loader"></div>
        <div class="info">
            <figure>
                <img :src="party.pictureUri" alt="party image">
            </figure>
            <div class="group">
                <h1>{{party.name}}</h1>
                <p>{{party.description}}</p>
                <h2>kandidaten</h2>
                <table>
                    <thead>
                    <th>#</th>
                    <th>Naam</th>
                    </thead>
                    <tbody>
                    <tr v-for="(candidate, index) in userItems">
                        <td>{{index + 1}}</td>
                        <!--<img :src="candidate.user.pictureUri">-->
                        <td>
                            <router-link :to="{ name: 'user', params: { id: candidate.user.id }}">
                                {{candidate.user.firstname}} {{candidate.user.lastname}}
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                userItems:[],
                paginate: ['users'],
                party: [],
                loading: true,

            }
        },
        methods: {
            /**get parties*/
            loadData: function (id) {
                this.axios.get('/api/parties/' + id).then((response) => {
                    console.log(response.data);
                    this.party = response.data;
                    this.userItems = this.party.candidates;
                this.stopLoading();

                });
            },
            /**stop loading animation*/
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 1500);
            }
        },
        mounted() {
            this.loadData(this.$route.params.id);
            console.log('Party mounted.')
        }
    }
</script>