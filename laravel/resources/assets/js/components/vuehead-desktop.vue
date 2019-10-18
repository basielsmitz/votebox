<template>
    <header class="desktop-header">
        <div class="container-item">
            <figure class="header-logo">
                <a href="/">
                <img src="/images/logo.svg" alt="">
                </a>
            </figure>
            <ul class="desktop-nav">
                <li>
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <router-link @click.native="hideNav" :to="{ path: '/'}">Home</router-link>

                </li>
                <li>
                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    <router-link @click.native="hideNav" replace :to="{ name: 'elections'}">Verkiezingen</router-link>
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
        </div>
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
    }
</script>