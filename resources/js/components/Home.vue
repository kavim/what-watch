<template>
    <div class="container">
        <h1>Lista de series</h1>
        {{listTvShow}}
        <br>
        <br>
        <br>
        <br>
        <br>

        <tvshow></tvshow>
        
        <div class="row">
            <div class="col-12 border rounded my-2 p-4" v-for="(tvshow, index) in listTvShow" :key="index">
                <div class="row">
                    <div class="col-6">
                        <strong>{{tvshow.name}}</strong>
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
        },
        computed: {
            listTvShow: function(){
                return this.$store.state.tvshows;
            }
        }
    }
</script>
