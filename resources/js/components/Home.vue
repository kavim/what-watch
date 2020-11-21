<template>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12 col-md-10 shadow-sm mx-auto bg-white rounded mt-5 mb-3 p-5 d-flex justify-content-between">
                <h1><i class="fas fa-swatchbook"></i> Lista de series</h1>
                <button @click="addTvshow" type="button" class="btn btn-outline-success px-3"><i class="fas fa-plus"></i> Adicionar nova série</button>
            </div>
        </div>

        <div v-if="this.$store.getters.haveListTvShow" class="row">
            <div class="col-12 col-md-8 mx-auto bg-white rounded mt-3 p-4" v-for="(tvshow, index) in listTvShow" :key="index">
                <div class="row">
                    <div class="col-6">
                        <span class="ts_title">{{tvshow.name}}</span>,
                        <span>{{tvshow.year}}</span>
                        
                        <br>
                        
                        <span><i class="fas fa-stream"></i> {{tvshow.seasons_quantity}} Temporadas</span>
                        &nbsp;
                        &nbsp;
                        <span><i class="fas fa-film"></i> {{filterTvshowCategory(tvshow.category_id)}}</span>
                        
                        <br>

                        <span>{{tvshow.synopsis}}</span>
                        
                    </div>
                    <div class="col-6 text-right">
                        <button @click="editTvShow(tvshow)" type="button" class="btn btn-outline-primary"><i class="fas fa-pen"></i></button>
                        <button @click="deleteTvShow(tvshow)" type="button" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>        
            </div>
        </div>
        <div v-else class="row">
            <div class="col-12 text-white text-center p-5">
                <h3>Nenhuma serie cadastrada</h3>
            </div>
        </div>
        
        <div id="modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Adicionar nova série</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <tvshow :to_update="this.to_update" :updating="this.updating" :to_update_id="this.to_update_id"></tvshow>
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                to_update: {},
                to_update_id: 0,
                updating: false
            }
        },
        created: function(){

            this.initAssets();

        },
        methods: {
            initAssets: function(){
                this.$store.dispatch("getTvShows").then(() => {

                    this.$store.dispatch("getCategories");
                    this.$store.dispatch("getStatus");
                    this.$store.dispatch("getYears");
                    
                    this.loading = false;
                });
            },
            addTvshow: function(){

                this.updating = false;
                this.to_update = {};
                this.to_update_id = 0;
                $('#modal').modal('toggle');

            },
            editTvShow: function(ts){

                this.updating = true;
                this.to_update = ts;
                this.to_update_id = ts.id;
                
                $('#modal').modal('toggle');

            },
            deleteTvShow: function(ts){

                let that = this;

                axios.delete('/api/delete-tvshow/' + ts.id, {
                    tvshow: ts
                })
                .then(function (response) {
                    
                    if (response.status != 200) {
                        
                        return new Error("Something went wrong");

                    }

                    that.$store.dispatch("deleteTvShow", ts.id);

                })
                .catch(function (error) {
                    alert(error);
                });
            },
            filterTvshowCategory: function(id){
                 
                let found = this.$store.state.categories.find(el => el.id == id);
                return found.name;
                
            },
        },
        computed: {
            listTvShow: function(){
                return this.$store.state.tvshows;
            },
        }
    }
</script>
