<template>
    <div class="container">
        <h1>Lista de series</h1>
        {{listTvShow}}
        <br>
        <br>
        <br>
        <br>
        <br>
        
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> -->
        <button @click="addTvshow" type="button" class="btn btn-outline-success">Novo</button>

        <div id="modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <tvshow :to_update="this.to_update" :updating="this.updating" :to_update_id="this.to_update_id"></tvshow>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 border rounded my-2 p-4" v-for="(tvshow, index) in listTvShow" :key="index">
                <div class="row">
                    <div class="col-6">
                        <strong>{{tvshow.name}}</strong>
                        <span>{{tvshow.year}}</span>
                    </div>
                    <div class="col-6 text-right">
                        <button @click="editTvShow(tvshow)" type="button" class="btn btn-outline-primary">edit</button>
                        <button @click="deleteTvShow(tvshow)" type="button" class="btn btn-outline-danger">del</button>
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
                
                $('#exampleModal').modal({backdrop: 'static', keyboard: false})

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
            }
        },
        computed: {
            listTvShow: function(){
                return this.$store.state.tvshows;
            }
        }
    }
</script>
