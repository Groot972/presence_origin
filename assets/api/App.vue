<template>
<div id="base">
    <div class="container">
        <div id="nav">

            <router-link to="/">Home</router-link> |
            <router-link to="/about">About</router-link>
            <router-link to="/inscription">Inscription</router-link>
            <router-link to="/login">Connexion</router-link>
            <router-link to="/admin">Admin</router-link>
            <router-link to="/professeur">Professeur</router-link>

        </div>
        <router-view/>
    </div>

</div>
 
</template>

<script>


</script>


<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

#nav {
  padding: 30px;
  text-align: center;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
#base{
  height: 100vh;
}
</style>
