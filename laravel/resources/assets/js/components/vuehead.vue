<template>

    <header class="main-header">
        <figure>
            <p id="hamburger">
                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </p>
        </figure>
        <h1>{{dutchify(this.$route.name)}}</h1>
    </header>

</template>
<script>
    export default{
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        methods: {
            /**genereate dutch name for each routename*/
            dutchify: function (value) {
                switch (value){
                    case 'home': {
                        return 'Home';
                    }break;
                    case 'elections': {
                        return 'Verkiezingen';
                    }break;
                    case 'election': {
                        return 'Verkiezing';
                    }break;
                    case 'electionVote': {
                        return 'Verkiezings stem';
                    }break;
                    case 'applyElection': {
                        return 'Registreer';
                    }break;
                    case 'referenda': {
                        return 'Referenda';
                    }break;
                    case 'Referendum': {
                        return 'Referendum';
                    }break;
                    case 'newReferenda': {
                        return 'Nieuw Referendum';
                    }break;
                    case 'groups': {
                        return 'Groupen';
                    }break;
                    case 'group': {
                        return 'Group';
                    }break;
                    case 'parties': {
                        return 'Partijen';
                    }break;
                    case 'party': {
                        return 'Partij';
                    }break;
                    case 'account': {
                        return 'Account';
                    }break;
                    case 'user': {
                        return 'Gebruiker';
                    }break;
                }

            }
        },
        mounted() {
        }

    }
</script>