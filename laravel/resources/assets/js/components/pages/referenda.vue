<template>
    <div id="referenda-overview" class="container">
        <div v-if="loading"  class="loader"></div>
        <div class="group">
            <h1>Referenda</h1>
            <div class="button-field">
                <router-link :to="{ name: 'newReferenda'}" class="btn blue">nieuw referendum</router-link>
            </div>
        </div>
            <paginate
                    name="referenda"
                    :list="filterByName"
                    :per="5"
            >
                <div class="filters">
                    <div class="searchfield">
                        <figure class="icon">
                            <img src="images/magnifier.svg" class="search"/>
                        </figure>
                        <input type="text" v-model="filterQuery" placeholder="Search...">
                    </div>
                    <div class="checkboxes">
                        <input type="checkbox" id="0" value="0" v-model="checkboxValues"> Lopend
                        <input type="checkbox" id="1" value="1" v-model="checkboxValues"> Gesloten
                    </div>
                </div>
                <div class="referendum" v-for="referendum in paginated('referenda')">
                    <h1>{{referendum.title}}</h1>
                    <p>{{referendum.description}}</p>
                    <p>Status:
                        <span class="closed"v-if="referendum.isClosed">Gesloten</span>
                        <span class="open"v-else >Open</span>
                    </p>
                    <p class="read-more">
                        <router-link :to="{ name: 'referendum', params: { id: referendum.id }}">Lees meer</router-link>
                    </p>
                </div>
            </paginate>
        <paginate-links for="referenda" :limit="5"></paginate-links>
    </div>
</template>


<script>
    export default {

        data() {
            return {
                referenda: [],
                paginate: ['referenda'],
                filterQuery: '',
                checkboxValues: [],
                loading: true,

            }
        },

        methods: {
            /**load all referenda sort by enddate*/
            loadData: function () {
                this.axios.get('/api/referenda').then((response) => {
                    this.referenda = response.data.all.sort(function(a,b) {
                        return new Date(a.endDate).getTime() - new Date(b.endDate).getTime()
                    });
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
            /**filter referenda by keyword or status*/
            filterByName() {
                return this.referenda.filter( referendum => {
                    if(this.checkboxValues.length == null || this.checkboxValues.length == 0 || this.checkboxValues.length == 2){
                        return referendum.title.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1;
                    }else{
                        let value = this.checkboxValues[0];
                        return referendum.title.toLowerCase().indexOf(this.filterQuery.toLowerCase()) > -1 && referendum.isClosed == value;
                    }
                })
            },
        },
        mounted() {
            this.loadData();
        }
    }
</script>