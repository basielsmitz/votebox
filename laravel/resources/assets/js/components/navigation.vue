<template>
    <nav id="mobile-nav" class="is-closed">
        <header>
            <img src="images/logo.svg">
            <i class="fa fa-times fa-2x" aria-hidden="true" id="cross"></i>
        </header>
        <ul>
            <li>
                <i class="fa fa-home" aria-hidden="true"></i>
                <router-link @click.native="hideNav" :to="{ path: '/'}">Home</router-link>

            </li>
            <li>
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                <router-link @click.native="hideNav" replace :to="{ name: 'elections'}">Verkiezing</router-link>
            </li>
            <li>
                <i class="fa fa-comments" aria-hidden="true"></i>
                <router-link @click.native="hideNav" replace :to="{ name: 'referenda'}">referenda</router-link>
            </li>
            <li>
                <i class="fa fa-users" aria-hidden="true"></i>
                <router-link @click.native="hideNav" replace :to="{ name: 'groups'}">Groepen</router-link>
            </li>
            <li>
                <i class="fa fa-sitemap" aria-hidden="true"></i>
                <router-link @click.native="hideNav" replace :to="{ name: 'parties'}">Partijen</router-link>
            </li>
            <li>
                <i class="fa fa-user" aria-hidden="true"></i>
                <router-link @click.native="hideNav" replace :to="{ name: 'account'}">Account</router-link>
            </li>
        </ul>
    </nav>
</template>
<script>
    export default{
        data(){
            return{
                mobileNav: '',
            }
        },
        methods: {
            hideNav(){
                document.getElementById('mobile-nav').className= "is-closed";
            }
    }
    }
</script>