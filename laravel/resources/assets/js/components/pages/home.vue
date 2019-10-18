<template>
    <div id="home" class="container">
        <div v-if="loading"  class="loader">
            <!--<img src="images/logo-square.gif">-->
        </div>
        <figure id="logo">
            <img src="images/logo-square.svg">
        </figure>

        <div id="cards">
           <div class="card-field">
            <tabs>
                <tab v-if="elections" name="verkiezingen" :selected="true">
                    <div v-for="election in slicedElections" :key="election.id">
                        <router-link :to="{ name: 'election', params: { id: election.id }}">
                            <div class="card-element">
                                <figure>
                                    <img v-bind:src="election.pictureUri">
                                </figure>
                                <h1 class="election-title">{{election.name}}</h1>
                            </div>
                        </router-link>
                        <!--<item v-for="election in elections" :key="election.id" propImage="/images/logo-square.svg"  propLink="/elections/#" :propName="election.name"></item>-->
                    </div>
                </tab>
                <tab v-if="referenda" name="referenda">
                    <div v-for="referendum in slicedReferenda" :key="referendum.id" class="home-referendums">
                        <router-link :to="{ name: 'referendum', params: { id: referendum.id }}">
                            <div class="card-element">
                                <figure>
                                    <img src="images/logo-square.svg">
                                </figure>
                                <h1 class="election-title">{{referendum.title}}</h1>
                            </div>
                        </router-link>
                        <!--<item v-for="referendum in referenda" :key="referenda.id" propImage="/images/logo-square.svg" propLink="/referenda/#"  :propName="referendum.title"></item>-->
                    </div>
                </tab>

            </tabs>
        </div>
        </div>
    </div>



</template>

<script>
    import Vue from 'vue';
    import axios from 'axios'
    import VueAxios from 'vue-axios'

    Vue.use(VueAxios, axios)
    Vue.component('tabs', {
        template: `
            <div class="card-with-header">
                <header>
                    <div class="tab" v-for="tab in tabs" :class="{'active' : tab.isActive}">
                        <a @click="selectTab(tab)">{{tab.name}}</a>
                    </div>
                </header>
                <slot></slot>
            </div>`,
        data() {
            return {
                tabs: [],
            };
        },

        created() {
            this.tabs = this.$children;
        },

        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.href == selectedTab.href);
                });
            }
        }

    });
    Vue.component('tab', {
        template: ` <div v-show="isActive" class="card">
                    <slot></slot>
                    </div>`,
        props: {
            name: { required: true },
            selected: { default: false }
        },

        data() {
            return {
                isActive: false,

            };
        },

        computed: {
            href() {
                return '#' + this.name.toLowerCase().replace(/ /g, '-');
            }
        },

        mounted() {
            this.isActive = this.selected;
        },
    })
    Vue.component('item', {
        template: `
         <router-link :to="propLink">
         <div class="card-element">
                <img :src="propImage">
            <p>{{propName}}</p>
         </div>
         </router-link>
`,
        props: ['propName', 'propImage', 'propLink']

    })



    export default {
        data() {
            return {
                elections: [],
                referenda: [],
                slicedReferenda: [],
                slicedElections: [],
                loading: true,

            };
        },
        methods: {
            /**load all elections and referenda then slice them*/
            loadData: function () {
                Vue.axios.get('/api/elections').then((response) => {
                    this.elections = response.data.all.sort(function(a,b) {
                        return new Date(a.endDate).getTime() - new Date(b.endDate).getTime()
                    });
                    this.Slice();
                });
                Vue.axios.get('/api/referenda').then((response) => {
                    this.referenda = response.data.all.sort(function(a,b) {
                        return new Date(a.endDate).getTime() - new Date(b.endDate).getTime()
                    });
                    this.Slice();
                })
            },
            /**slice depending on client width*/
            Slice: function(){
               let clientWidth = document.documentElement.clientWidth;
               if(clientWidth > 1100) {
                   this.slicedElections = this.elections.slice(0,5);
                   this.slicedReferenda = this.referenda.slice(0,5);
                   this.stopLoading();
               } else {
                   this.slicedElections = this.elections.slice(0,3);
                   this.slicedReferenda = this.referenda.slice(0,3);
                   this.stopLoading();
               }
            },
            stopLoading: function () {
                let self = this;
                setTimeout(function(){ self.loading = false; }, 3000);
            }
        },

        mounted() {
            this.loadData();
            this.$nextTick(function() {
                window.addEventListener('resize', this.Slice);
            });
        },

    }

</script>




