<template>
  <div class="home gradient-custom">
    

  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Connexion</h2>
              

              <div class="form-outline form-white mb-4">
                <input type="email" id="typeEmailX" class="form-control form-control-lg" />
                <label class="form-label" for="typeEmailX">Email</label>
              </div>

              <div class="form-outline form-white mb-4">
                <input type="password" id="typePasswordX" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX">Mot de passe</label>
              </div>

            

              <button class="btn btn-outline-light btn-lg px-5" type="submit">Se connecter</button>

              

            </div>



          </div>
        </div>
      </div>
    </div>
  </div>


  </div>
</template>

<script>
// @ is an alias to /src


export default {
  name: 'Connexion',
 
}
</script>
<style scoped>
.gradient-custom {
background-image: radial-gradient(circle at 50% -20.71%, #ffef37 0, #fff327 7.14%, #fff619 14.29%, #e8f80f 21.43%, #c9f911 28.57%, #a6f81e 35.71%, #7cf62c 42.86%, #3cf23c 50%, #00ee4d 57.14%, #00ea60 64.29%, #00e574 71.43%, #00e18a 78.57%, #00dea1 85.71%, #00dab9 92.86%, #00d8d2 100%);
}
</style>
