<template>
    <div id="group-detail" class="container">
        <div v-if="loading"  class="loader"></div>
        <div class="group">
            <div class="group-item">
                <figure>
                    <img :src="group.pictureUri"></img>
                </figure>
            </div>
            <div class="group-item">
                <h1>{{group.name}}</h1>
                <p>{{group.description}}</p>
                <div class="button-field">
                    <button v-if="!listed" @click="join" class="btn green">Lid worden</button>
                </div>
            </div>
        </div>
            <h2>Gebruikers</h2>
            <paginate
                    name="users"
                    :list="userItems"
                    :per="12"
            >
                <div class="card-field">
                    <div class="standard-card" v-for="user in paginated('users')">
                        <router-link :to="{ name: 'user', params: { id: user.id }}">
                            <div class="card-wrapper">
                                <div class="card">
                                    <!--<img :src="user.pictureUri">-->
                                    <p>{{user.firstname}} {{user.lastname}}</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </paginate>
            <paginate-links for="users" :limit="5"></paginate-links>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                userItems:[],
                paginate: ['users'],
                user : [],
                group: [],
                listed: false,
                loading: true,


            }
        },
        methods: {
            /** get groups*/
            loadData: function (id) {
                this.axios.get('/api/groups/' + id).then((response) => {
                    this.userItems = response.data.users;
                    this.group = response.data.group;
                    this.checkListed();
                });
            },
            /**get authenticated user*/
            loadUserData: function (groupId) {
                this.axios.get('/api/user').then((response) => {
                    this.user = response.data;
                    this.loadData(groupId);
                });
            },
            /** join new group*/
            join: function() {
                self = this;
                self.axios.post('/api/groups/join',{
                    group_id: self.group.id,
                    user_id: self.user.id,


                }).then((response) => {

            });
                window.location.reload()

            },
            checkListed() {
                let filtered = _.filter(this.userItems, { 'id': this.user.id});
                (filtered.length === 0)?this.listed = false : this.listed = true;
                this.stopLoading();


            },
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 1500);
            }
        },
        mounted() {
            this.loadUserData(this.$route.params.id);
        }
    }
</script>