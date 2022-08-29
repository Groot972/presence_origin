<template>
    <div class="container">
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


        <div class="row justify-content-center">
            <div class="col-3">
                <button class="btn btn-primary" type="submit" @click="afficher(1)">Liste des sessions</button>
            </div>

            <div class="classes col-md-6">

                <!-- Faire l'appel -->
                <div class="row">

                    <h3>Liste des Sessions : </h3>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Jour</th>
                            <th scope="col">Heure</th>
                            <th scope="col">Classe</th>
                            <th scope="col">Appel</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="school in liste_sessions">
                            <td>
                                {{school.jour}}
                            </td>
                            <td>
                                {{school.heure}}
                            </td>
                            <td>
                                {{school.classes}}
                            </td>
                            <td>
                                {{school.appel}}
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" @click="faireAppel(school.eleves)">Faire l'appel</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <div v-for="eleve in liste_eleves"  class="appel">
                        Appel : Cochez les abscents
                        Abscents : <div> {{abscences }}</div>
                        <li>
                           {{eleve.nom}} {{eleve.prenom}}
                            <input type="checkbox" id="abscent" :value="eleve.prenom" v-model="abscences">
                            <label for="abscent">Abscent</label>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>



</template>

<script>
    import axios from 'axios';
    export default {
        name: 'Professeur',
        data(){
            return{
                message: {
                    etat: '',
                    text: ''
                },
                liste_sessions: [],
                liste_eleves: [],
                session: {
                    id: '',
                    jour: '',
                    heure: '',
                    classe: '',
                    matiere: ''
                },
                abscences: [],
                presences: []

            }},
        created(){
            this.showSessions(1);
        },
        methods: {
            showSessions:function(id){
                axios.post('/api/getsession/cours/'+id)
                    .then(response => {
                        this.liste_sessions = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            faireAppel:function(value){
                this.liste_eleves = value
            }


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