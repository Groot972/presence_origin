<template>

  <div class="row justify-content-center ">
    <h1 class="text-center p-3"> Formulaire d'inscription </h1>
    <!--Alert message-->
      <!-- ##### Message Alerte #####-->
      <Transition name="slide">
          <div v-if="message.etat === 'success'"  class="alert alert-success" role="alert">
              {{message.text}}
          </div>
      </Transition>
      <!--***** Fin *****-->
    <div v-if="message.etat === 'error'" class="alert alert-danger" role="alert">
      {{message.text}}
    </div>
    <div class="col-md-6 align-items-left p-4">
      <form class="row">
          <!--Nom-->
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" v-model="user.nom" class="form-control" id="nom"  required>
          </div>
          <!--Prénom-->
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" v-model="user.prenom" class="form-control" id="prenom" required>
          </div>
          <!--Email-->
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" v-model="user.email" class="form-control" id="email" required>
          </div>
          <!--Mot de passe-->
          <div class="col-md-6">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" v-model="user.password" class="form-control" id="password"  required>
          </div>
          <!--Confirmer Mot de passe-->
          <div class="col-md-6">
            <label for="password_confirm" class="form-label">Confirmez le mot de passe</label>
            <input type="password" v-model="user.password_confirm" class="form-control" id="password_confirm"  required>
          </div>
          <!--Professeur ou eleve-->
          <div class="col-md-6">
              <label for="statut" class="form-label">Statut</label>
              <select id="statut" v-model="user.statut" class="form-select">
                  <option value="eleve">Eleve</option>
                  <option value="professeur">Professeur</option>
              </select>
          </div>
          <!--Si eleve, choisir la classe-->
          <div v-if="user.statut === 'eleve'" class="col-md-6">
              <label for="classe" class="form-label">Classe</label>
              <select id="classe" v-model="user.classe" class="form-select">
                  <option v-for="school in classes" :value="school.id">{{school.libelle}}</option>
              </select>
          </div>
          <!--Si professeur, renseigner sa matiere-->
          <div v-if="user.statut === 'professeur'" class="col-md-6">
              <label for="matiere" class="form-label">Matière enseignée : </label>
              <input type="text" v-model="user.matiere" class="form-control" id="matiere" required>
          </div>
          <!--Boutton submit-->
          <div class="col-12">
            <button class="btn btn-primary" type="submit" @click.prevent="inscription()">S'enregistrer !</button>
          </div>
      </form>
    </div> <!-- col.//-->
  </div> 
</template>

<script>
// @ is an alias to /src
import axios from "axios";

export default {
  name: 'Inscription',
 data(){
  return{
          user: {
                nom: '',
                prenom: '',
                email: '',
                password: '',
                password_confirm: '',
                classe: '',
                statut: '',
                matiere : ''
          },
          message: {
                etat: '',
                text: ''
          },
            classes: []

  }
 },
    created(){
        this.showClasses()
    },
 methods: {

            inscription:function(){

                 axios.post('/api/inscription', {user: this.user})
                     .then(response => {
                         console.log(response.data);
                         //Si l'utilisateur est créé,
                         if (response.data.etat === 'success') {
                             this.user.nom = '';
                             this.user.prenom = '';
                             this.user.email = '';
                             this.user.password = '';
                             this.user.password_confirm = '';
                             this.user.classe = '';
                             this.user.statut = '';
                             this.user.matiere = '';
                             // On envoie une alerte
                             this.message.etat = response.data.etat;
                             this.message.text = response.data.message;
                             setTimeout(()=>{
                                 this.message.etat = '';
                                 this.$router.push('/login')
                             }, 3000)
                         } else {
                             // On envoie une alerte d'erreur
                             this.message.etat = response.data.etat;
                             this.message.text = response.data.message;
                         }


                     })
                     .catch(error => {
                         console.error(error);
                     })
              },
             showClasses:function(){
                 axios.get('/api/getclasses')
                     .then(response => {this.classes = response.data;})
                                    },

          }

             
 }

</script>
<style scoped>
    .slide-enter-active {
        transition: all 0.3s ease-out;
    }

    .slide-leave-active {
        transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .slide-enter-from,
    .slide-leave-to {
        transform: translateX(20px);
        opacity: 0;
    }
</style>
