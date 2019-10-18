<template>
    <div id="elections" class="container">
        <div v-if="loading"  class="loader"></div>
        <div id="cards">
            <paginate
                    name="elections"
                    :list="filterByName"
                    :per="6"
            >
                <div class="filters">

                    <div class="searchfield">
                        <figure class="icon">
                            <img src="images/magnifier.svg" class="search"/>
                        </figure>
                        <input type="text" v-model="filterQuery" placeholder="Search...">
                    </div>
                    <div class="checkboxes">
                        <input type="radio" id="3" value="3" checked v-model="radioValue"> Alle
                        <input type="radio" id="0" value="0" v-model="radioValue"> Lopende
                        <input type="radio" id="1" value="1" v-model="radioValue"> Gesloten
                        <input type="radio" id="2" value="2"  v-model="radioValue"> Geplande
                    </div>
                </div>
                <div class="card-field">
                    <div class="standard-card" v-for="election in paginated('elections')">
                        <div class="card-wrapper">
                            <div class="card">
                                <figure>
                                    <img :src="election.pictureUri">
                                </figure>
                                <div class="card-info">
                                    <h1 class="title">{{ election.name }}</h1>
                                    <p>
                                        {{ election.description }}
                                    </p>
                                    <ul v-if="election.isComing && election.isClosed">
                                        <li class="coming">Gepland</li>
                                        <li>Start op: {{ election.startDate }}</li>
                                    </ul>
                                    <ul v-else-if="!election.isComing && !election.isClosed">
                                        <li class="open"> Lopend</li>
                                        <li  > Eindigt op: {{ election.endDate }}</li>
                                    </ul>
                                    <ul v-else>
                                        <li class="closed"> Gesloten</li>
                                    </ul>

                                </div>
                            </div>
                            <div class="button-field">
                                <router-link :to="{ name: 'election', params: { id: election.id }}" class="to-detail">
                                    <button class="btn blue">Bekijken</button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </paginate>
        </div>
        <paginate-links for="elections" :limit="5"></paginate-links>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                elections: [],
                paginate: ['elections'],
                filterQuery: '',
                radioValue: 3,
                checkboxComing: false,
                dateNow: new Date(),
                loading: true,

            }
        },
        components : {

        },

        methods: {
            /**load all elections sorted by enddate*/
            loadData() {
                this.axios.get('/api/elections').then((response) => {
                    this.elections = response.data.all.sort(function(a,b) {
                        return new Date(a.endDate).getTime() - new Date(b.endDate).getTime()
                    });
                this.stopLoading();

            });
            },
            /**stop teh loading animation*/
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 1500);
            }
        },

        computed: {
            /**filter paginated list by keyword or status*/
            filterByName() {
                let value = this.radioValue;
                return this.elections.filter( election => {
                    if(value == 3){
                            return election.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1;
                    }else{
                        switch (parseInt(value)) {
                            case 0: {
                                return election.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 && election.isClosed == 0 ;

                            }break;
                            case 1: {
                                return election.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 && election.isClosed == 1 && election.isComing == 0;

                            }break;
                            case 2: {

                                return election.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 && election.isComing == 1 ;

                            }break;
                            case 3: {
                                return election.name.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 ;

                            }break;
                        }
                    }
                })
            }
        },

        mounted() {
            this.loadData();
        }
    }
</script>