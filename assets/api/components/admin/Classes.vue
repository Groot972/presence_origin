<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <button class="btn btn-primary" type="submit" @click="afficher(1)">Liste des classes</button>
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
                            <div class="col-auto">
                                <label for="libelle" class="form-label">Libellé</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" v-model="classe.libelle" class="form-control" id="libelle"  required>
                            </div>
                            <div class="col-auto">
                                <!--Boutton submit-->
                                <button v-if="mvt === 'creer'" class="btn btn-primary" type="submit" @click.prevent="addClasse()"> Ajouter </button>
                                <button v-if="mvt === 'modif'" class="btn btn-primary" type="submit" @click.prevent="modClasse(classe.id)"> Modifier </button>

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
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary"><i class='bx bx-info-circle'></i></button>
                                <button type="button" @click="action('modif'), affClasse(school.id, school.libelle)" class="btn btn-outline-dark"><i class='bx bx-pencil' ></i></button>
                                <button type="button" @click="deleteClasse(school.id)" class="btn btn-outline-danger"><i class='bx bx-message-square-x'></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <!-- Creation et gestion des cours -->


            </div>
        </div>
    </div>



</template>

<script>
    import axios from 'axios'
    export default {
        name: 'Classes',
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
                mvt : ''


            }},
        created(){
            this.showClasses()
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