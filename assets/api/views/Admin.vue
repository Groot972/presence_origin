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
                <button class="btn btn-primary" type="submit" @click="afficher(1)">Liste des classes</button>
            </div>
            <div class="col-3">
                <button class="btn btn-primary" type="submit" @click="afficher(2)">Liste des cours</button>
            </div>


            <div class="classes col-md-6">
                <!-- Creation et gestion des classes -->
                <div class="row" v-if="code === 1">
                    <div class="col-3">
                        <button class="btn btn-info" type="button" @click="action('creer')"><i class='bx bx-add-to-queue'> Créer </i></button>
                    </div>
                    <div>
                        <form v-if="mvt" class="row p-3">
                            <h4 v-if="mvt === 'creer'">Ajouter une classe</h4>
                            <h4 v-if="mvt === 'modif'">Modifier une classe</h4>
                            <h4 v-if="mvt === 'modifEleve'">Modifier un eleve</h4>
                            <div class="col-auto">
                                <label for="libelle" class="form-label">Libellé</label>
                            </div>
                            <div v-if="mvt === 'creer' || mvt === 'modif'" class="col-auto">
                                <input type="text" v-model="classe.libelle" class="form-control" id="libelle"  required>
                            </div>
                            <div v-if="mvt === 'modifEleve'" class="col-auto">
                                <input type="text" v-model="eleve.email" :aria-placeholder="eleve.email">

                            </div>
                            <div class="col-auto">
                                <!--Boutton submit-->
                                <button v-if="mvt === 'creer'" class="btn btn-primary" type="submit" @click.prevent="addClasse()"> Ajouter </button>
                                <button v-if="mvt === 'modif'" class="btn btn-primary" type="submit" @click.prevent="modClasse(classe.id)"> Modifier </button>
                                <button v-if="mvt === 'modifEleve'" class="btn btn-primary" type="submit" @click.prevent="modEleve(eleve.id, eleve.email)"> Modifier </button>
                            </div>
                        </form>

                    </div>

                    <h3>Liste des classes : </h3>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom de la classe</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="school in classes">
                            <td>
                                {{school.libelle}}

                                    <div v-if="school.id === showId" class="lise-eleves">
                                        Liste des eleves :
                                        <ul v-for="liste in liste_eleves">
                                            <li> {{liste.nom}}{{liste.prenom}} <button type="button" @click="action('modifEleve'), affEleve(liste.id, liste.email, liste.classes)" class="btn btn-outline-dark"><i class='bx bx-pencil' ></i></button> </li>
                                        </ul>
                                    </div>


                            </td>
                            <td>

                                <button type="button" class="btn btn-outline-primary" @click="showEleves(school.id)"><i class='bx bx-info-circle'></i></button>
                                <button type="button" @click="action('modif'), affClasse(school.id, school.libelle)" class="btn btn-outline-dark"><i class='bx bx-pencil' ></i></button>
                                <button type="button" @click="deleteClasse(school.id)" class="btn btn-outline-danger"><i class='bx bx-message-square-x'></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <!-- Creation et gestion des cours -->
                <div class="row" v-if="code === 2">
                    <div class="col-3">
                        <button class="btn btn-info" type="button" @click="action('creerSession')"><i class='bx bx-add-to-queue'> Créer </i></button>
                    </div>
                    <div>
                        <form v-if="mvt" class="row p-3">
                            <h4 v-if="mvt === 'creerSession'">Ajouter une Session</h4>
                            <h4 v-if="mvt === 'modifSession'">Modifier une Session</h4>

                            <div class="col-auto">
                                    <label for="jour" class="form-label">Jour</label>
                                    <select id="jour" v-model="session.jour" class="form-select">
                                        <option v-for="day in jours" :value="day.libelle">{{day.libelle}}</option>
                                    </select>
                            </div>
                            <div class="col-auto">
                                    <label for="heure" class="form-label">Heure</label>
                                    <select id="heure" v-model="session.heure" class="form-select">
                                        <option v-for="hours in heures" :value="hours.libelle">{{hours.libelle}}</option>
                                    </select>
                            </div>
                            <div class="col-auto">
                                    <label for="classe" class="form-label">Classe</label>
                                    <select id="classe" v-model="session.classe" class="form-select">
                                        <option v-for="school in classes" :value="school.id">{{school.libelle}}</option>
                                    </select>
                            </div>
                            <div class="col-auto">
                                <label for="matiere" class="form-label">Matiere</label>
                                <select id="matiere" v-model="session.matiere" class="form-select">
                                    <option v-for="school in cours" :value="school.id">{{school.libelle}}</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <!--Boutton submit-->
                                <button v-if="mvt === 'creerSession'" class="btn btn-primary" type="submit" @click.prevent="addSession()"> Ajouter </button>
                                <button v-if="mvt === 'modifSession'" class="btn btn-primary" type="submit" @click.prevent="modSession(session.id)"> Modifier </button>
                            </div>
                        </form>

                    </div>

                    <h3>Liste des Cours : </h3>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Matiere</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="school in cours">
                            <td>
                                {{school.libelle}}

                                <div v-if="school.id === showId" class="lise-eleves">
                                    Liste des sessions :
                                    <ul v-for="liste in liste_sessions">
                                        <li> {{liste.jour}}{{liste.heure}} avec la classe de {{liste.classes}}
                                             appel réalisé : {{liste.appel}} .
                                            <div v-if="liste.appel === 'oui'"> Présents : {{liste.totalPresent}} élèves. Abscents : {{liste.totalAbs}}</div>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" @click="showSession(school.id)"><i class='bx bx-info-circle'></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>



</template>

<script>
    import axios from 'axios';
    export default {
        name: 'Admin',
        data(){
            return{
                classe : {
                    id: null,
                    libelle : ''
                },
                classes : []
                ,
                message: {
                    etat: '',
                    text: ''
                },
                code: '',
                mvt : '',
                liste_eleves: [],
                liste_matieres: [],
                liste_sessions: [],
                showId : '',
                eleve: {
                    id: '',
                    email:''
                },
                session: {
                    id: '',
                    jour: '',
                    heure: '',
                    classe: '',
                    matiere: ''
                },
                cours: [],
                jours: [
                    {id:1, libelle:'Lundi'}, {id:2, libelle:'Mardi'}, {id:3, libelle:'Mercredi'}, {id:4, libelle:'Jeudi'}, {id:5, libelle:'Vendredi'},
                ],
                heures: [
                    {id:1, libelle:'9:00'}, {id:2, libelle:'10:00'}, {id:3, libelle:'11:00'}, {id:4, libelle:'14:00'}, {id:5, libelle:'15:00'}, {id:6, libelle:'16:00'}
                ]

            }},
        created(){
            this.showClasses();
            this.showCours();
        },

        methods: {
            showClasses:function(){
                axios.get('/api/getclasses')
                    .then(response => {
                        this.classes = response.data;
                    })
            },
            addClasse:function(){
                axios.post('/api/addclasse', {classe: this.classe})
                    .then(response => {
                        console.log(response.data);
                        //Si la classe est créée,
                        if (response.data.etat === 'success') {
                            this.classe.libelle = '';
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.showClasses();
                            setTimeout(()=>{
                                this.message.etat = '';
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
            deleteClasse:function(id){
                axios.post('api/deleteclasse/'+id)
                    .then(response=>{
                        //Si la classe est supprimée,
                        if (response.data.etat === 'success') {
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.showClasses();
                            setTimeout(()=>{
                                this.message.etat = '';
                            }, 3000)
                        }})
                    .catch(error => {
                        console.error(error);
                    })
            },
            affClasse:function(id, libelle){
                this.classe.id = id;
                this.classe.libelle = libelle;},
            modClasse:function(id){
                axios.post('/api/modifierclasse/'+id, {classe: this.classe})
                    .then(response=>{
                        //Si la classe est supprimée,
                        if (response.data.etat === 'success') {
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.classe.id = '';
                            this.classe.libelle = '';
                            this.showClasses();
                            setTimeout(()=>{
                                this.message.etat = '';
                            }, 3000)
                        }})
                    .catch(error => {
                        console.error(error);
                    })
            },
            afficher: function(el){
                this.code = el;
            },
            action: function(el){
                this.mvt = el;
                if (el === 'creer') {
                    this.classe.libelle = "";
                    this.classe.id = "";
                }

            },
            showEleves:function(id){
                axios.post('/api/geteleves/classe/'+id)
                    .then(response => {
                        this.liste_eleves = response.data;
                        this.showId = id
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            modEleve:function(id){
                axios.post('/api/modifiereleve/'+id, {eleve: this.eleve})
                    .then(response=>{

                        if (response.data.etat === 'success') {
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.eleve.id = '';
                            this.eleve.email = '';

                            this.showId = "";
                            this.mvt= "";
                            setTimeout(()=>{
                                this.message.etat = '';
                            }, 3000)
                        }})
                    .catch(error => {
                        console.error(error);
                    })
            },
            affEleve:function(id, email){

                this.eleve.id = id;
                this.eleve.email = email;

            console.log(this.eleve)},
            addSession:function(){
                console.log(this.session)
                axios.post('/api/addsession', {session: this.session})
                    .then(response => {
                        console.log(response.data);
                        //Si la classe est créée,
                        if (response.data.etat === 'success') {
                            this.session.jour = '';
                            this.session.heure = '';
                            this.session.classe = '';
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.showClasses();
                            setTimeout(()=>{
                                this.message.etat = '';
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
            modSession:function(id){
                axios.post('/api/modifiersession/'+id, {session: this.session})
                    .then(response=>{
                        //Si la classe est supprimée,
                        if (response.data.etat === 'success') {
                            // On envoie une alerte
                            this.message.etat = response.data.etat;
                            this.message.text = response.data.message;
                            this.session.jour = '';
                            this.session.heure = '';
                            this.session.classe = '';

                            setTimeout(()=>{
                                this.message.etat = '';
                            }, 3000)
                        }})
                    .catch(error => {
                        console.error(error);
                    })
            },
            showCours:function(){
                axios.get('/api/getcours')
                    .then(response => {
                        this.cours = response.data;
                    })
            },
            showSession:function(id){
                axios.post('/api/getsession/cours/'+id)
                    .then(response => {
                        this.liste_sessions = response.data;
                        this.showId = id
                    })
                    .catch(error => {
                        console.error(error);
                    })
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