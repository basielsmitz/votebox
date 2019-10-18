<template>
    <div id="election-detail" class="container">
        <div v-if="loading"  class="loader"></div>
        <div class="group">
            <div class="group-item">
                <figure class="election-image">
                    <img :src="election.pictureUri">
                </figure>
            </div>

            <div class="group-item">
                <h1>{{election.name}}</h1>
                <p class="description">{{election.description}}</p>
                <p v-if="status == 'coming'">Gepland</p>
                <p v-if="status == 'coming'">Start op: {{ election.startDate }}</p>
                <p v-if="status == 'open'" class="is-open"> open</p>
                <p v-if="status == 'open'" > Eindigt op: {{ election.endDate }}</p>
                <p v-if="status == 'closed'" class="is-closed">Gesloten</p>

                <hr />
            </div>
        </div>

        <h1 class="candidates-title">Kandidaten</h1>
        <table>
            <thead>
                <th>Kandidaat</th>
                <th>Partij</th>
            </thead>
            <tbody>
            <tr v-for="candidate in election.candidates" v-if="candidate.pivot.approved">
                <td >{{ candidate.user.firstname }} {{ candidate.user.lastname }}</td>
                <td >{{ candidate.party.name }}</td>
            </tr>
            </tbody>
        </table>

        <div class="button-field" v-if="status == 'open' && !voted && !empty">
            <router-link :to="{ name: 'electionVote', params: { id: election.id }}" class="full-width">
                <button class="btn blue">Stemmen</button>
            </router-link>
        </div>

        <div class="results" v-if="election.isClosed">
            <div class="button-field" v-if="status == 'coming' && !listed">
                <router-link   :to="{ name: 'applyElection', params: { id: election.id }}">
                    <button class="btn blue">registreer</button>
                </router-link>
            </div>
        </div>
        <div v-if="status == 'closed'" class="results">
            <h1>Uitslag</h1>
            <div class="ct-chart">
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                election: [],
                candidates: [],
                scores: [],
                user: [],
                listed: false,
                reg: false,
                status: 'closed',
                voted: false,
                loading: true,
                empty: false,
            }
        },

        methods: {
            /** get current election and userdata*/
            loadData: function (id, userId) {
                this.axios.get('/api/elections/' + id).then((response) => {
                    this.election = response.data;
                    if(this.election.candidates.length == 0){
                        this.empty = true;
                    }
                    this.axios.get('/api/users/' + userId).then((response) => {
                        this.user = response.data;
                        this.checkReg();
                        this.checkStatus();

                    });
                });

            },
            /** get authenticated user data*/
            loadUserData: function (electionId) {
                this.axios.get('api/user').then((response) => {
//                    this.user = response.data;
                    this.loadData(electionId, response.data.id);
                });
            },
            /**check if user is listed as candidate*/
            checkListed() {
                let candidates = this.election.candidates;
                for (let i = 0; i < candidates.length; i++) {
                    if(this.user.id === candidates[i].user_id){
                        this.listed = true
                    }
                }
                this.stopLoading();

            },
            /**check if registration is allowed*/
            checkReg(){
                if(new Date() < new Date(this.election.startDate)){
                    this.reg = true;
                }else {
                    this.reg = false;
                }
            },
            /**check elecions status*/
            checkStatus(){
                if(new Date() < new Date(this.election.startDate)){
                    this.status = 'coming';
                    this.checkListed();
                }
                else if ((new Date() > new Date(this.election.startDate))&& (new Date() < new Date(this.election.endDate))){
                    this.status = 'open';
                    this.checkVoted();
                }else{
                    this.status = 'closed';
                    this.drawGraph();
                }

            },
            /** check if user has voted already*/
            checkVoted(){
                let self = this;
                let history = self.user.history;
                for(let i = 0; i < history.length;  i++){
                    let electionId = self.user.history[i];
                    if(electionId.election_id == self.election.id){
                        self.voted = true;
                        break;
                    }
                }
                this.stopLoading();
            },
            /**stop the loading animation*/
            stopLoading: function () {
                let _self = this;
                setTimeout(function(){ _self.loading = false; }, 1500);
            },
            /**draw result graph*/
            drawGraph() {
                if(this.election.isClosed) {
                    for(let i = 0; i < this.election.candidates.length; i++){
                        if(this.election.candidates[i].pivot.approved){
                            this.candidates.push(this.election.candidates[i].user.firstname + " " + this.election.candidates[i].user.lastname);
                            this.scores.push(this.election.candidates[i].pivot.score)
                        }
                    }
                    var options = {
                        labelInterpolationFnc: function(value) {
                            return value[0]
                        }
                    };
                    new Chartist.Bar('.ct-chart', {
                        labels: this.candidates,
                        series: [this.scores]
                    }, options);
                    this.stopLoading();
                }
            },
        },
        mounted() {
            this.loadUserData(this.$route.params.id);
        }
    }
</script>