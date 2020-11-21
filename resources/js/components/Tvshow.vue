<template>
    <div class="row justify-content-center">
        <div class="col-8 m-3">
            <!-- <form> -->
                <div class="form-group">
                    <label for="Nameson">Nameson  </label>
                    <input v-model="name" type="text" class="form-control" id="Nameson" placeholder="Nome da serie">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Sinopson</label>
                    <textarea v-model="synopsis" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="sq">N.º de temporadas</label>
                        <input v-model="seasons_quantity" type="number" class="form-control" id="sq">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sq">Categoria</label>
                        <select v-model="category_id" class="form-control">
                            <option disabled hidden value="0">Categoria</option>
                            <option v-for="option in categoriesAs" v-bind:value="option.value" :key="option.value">
                                {{ option.text }}
                                {{ option.id }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select v-model="year" class="form-control">
                            <option disabled hidden value="0">Ano</option>
                            <option v-for="y in yearAs" v-bind:value="y.value" :key="y.value">
                                {{ y.text }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mx-auto my-2">
                        <div class="radio-btn-group">
                            <div class="radio" @click="status_id = 1">
                                <input v-model="this.status_id" type="radio" :value="1">
                                <label for="click_me">Já assisti</label>
                            </div>
                            <div class="radio" @click="status_id = 2">
                                <input v-model="this.status_id" type="radio" :value="2">
                                <label for="or_me">Quero VER</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button @click="submit" type="submit" class="btn btn-outline-dark">DALE</button>
            <!-- </form> -->
        </div>
        
    </div>
</template>

<script>
    export default {
        props: {
            updating: {
                type: Boolean,
            },
            to_update: {
                type: [Object, Array],
            },
            to_update_id: {
                type: Number,
            },
        },
        data() {
            return {
                id: 0,
                name: '',
                year: null,
                synopsis: '',
                seasons_quantity: null,
                category_id: 0,
                status_id: 1,
                year: 0
            }
        },
        methods: {
            submit: function(){
                let ts = {
                    id: this.id,
                    name: this.name,
                    year: this.year,
                    synopsis: this.synopsis,
                    seasons_quantity: this.seasons_quantity,
                    category_id: this.category_id,
                    status_id: this.status_id,
                }

                let that = this;
                
                axios.post('/api/save-tvshow', {
                    tvshow: ts
                })
                .then(function (response) {
                    
                    if (response.status != 200 || !response.data.status) {
                        
                        return new Error("Something went wrong");

                    }

                    that.$store.dispatch("saveTvShow", response.data.tvshow);

                    $('#modal').modal('toggle');

                })
                .catch(function (error) {
                    alert(error);
                    alert("not ok");
                });
            },
            syncData(){
                if(this.updating){
                    
                    this.id = this.to_update.id,
                    this.name= this.to_update.name,
                    this.year= this.to_update.year,
                    this.synopsis= this.to_update.synopsis,
                    this.seasons_quantity= this.to_update.seasons_quantity,
                    this.category_id= this.to_update.category_id,
                    this.status_id= this.to_update.status_id,
                    this.year= this.to_update.year

                    console.log("this.to_update");
                    
                }else{

                    this.id = 0,
                    this.name= '',
                    this.year= null,
                    this.synopsis= '',
                    this.seasons_quantity= null,
                    this.category_id= 0,
                    this.status_id= 0,
                    this.year= 0

                    console.log("add ts");

                }
            }
        },
        watch: {

            updating: function(){
                this.syncData();
            },
            to_update_id: function(){
                this.syncData();
            }
            
        },
        computed: {
            categoriesAs: function(){
                let retorno = [];

                this.$store.state.categories.forEach(cat => {
                    retorno.push({ text: cat.name, value: cat.id });
                });

                return retorno;
            },
            yearAs: function(){
                let retorno = [];

                this.$store.state.years.forEach(y => {
                    retorno.push({ text: y.text, value: y.value });
                });

                return retorno;
            }
        }
    }
</script>
