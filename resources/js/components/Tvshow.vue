<template>
    <div class="row justify-content-center">
        <div class="col-11">
            <!-- <form> -->
                <div class="form-group col-md-6 mx-auto my-2">
                    <div class="radio-btn-group">
                        <div class="radio" @click="status_id = 1">
                            <input v-model="this.status_id" type="radio" :value="1">
                            <label for="click_me">Já assisti</label>
                        </div>
                        <div class="radio" @click="status_id = 2">
                            <input v-model="this.status_id" type="radio" :value="2">
                            <label for="or_me">Quero Ver</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Nameson">Nome da série</label>
                    <input v-model="name" type="text" class="form-control" id="Nameson" placeholder="Nome da serie" :maxlength="200">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Sinopse {{synopsis.length}}/500</label>
                    <textarea v-model="synopsis" class="form-control" id="exampleFormControlTextarea1" rows="4" placeholder="Sinopse da serie." :maxlength="500"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="sq">N.º de temporadas</label>
                        <input @input="seasons_quantity_filter" :value="seasons_quantity" type="number" class="form-control" id="sq"  placeholder="minimo 1">
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
                        <label for="inputState">Ano de lançamento</label>
                        <select v-model="year" class="form-control">
                            <option disabled hidden value="0">Ano</option>
                            <option v-for="y in yearAs" v-bind:value="y.value" :key="y.value">
                                {{ y.text }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <cover></cover>
                </div>
                
            <!-- </form> -->
        </div>
        
        <div class="col-11 text-right mt-4">
            <button type="button" class="btn btn-outline-dark mr-2" data-dismiss="modal" aria-label="Close">Cancelar</button>
            <button @click="submit" type="submit" class="btn btn-success" v-text="this.updating ? 'Atualizar' : 'Adicionar'" :disabled="validateBtn"></button>
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
                year: 0,
                cover: '/image/default-movie.png'
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

                if(ts.id == 0){
                    this.storeTvshow(ts);
                }else{
                    this.updateTvshow(ts);
                }
                
            },
            storeTvshow(ts){
                let that = this;
                
                axios.post('/api/save-tvshow', {
                    tvshow: ts
                })
                .then(function (response) {

                    if (response.status != 200 || !response.data.status) {   
                        return new Error("Something went wrong");
                    }

                    let newTvshow = response.data.tvshow;

                    that.saveCover(response.data.tvshow.id)
                    .then(data => {
                        newTvshow.cover = data.src;
                    });                    

                    that.$store.dispatch("saveTvShow", newTvshow);

                    $('#modal').modal('toggle');                    

                    that.syncData();
                    

                })
                .catch(function (error) {
                    alert(error);
                });
            },
            updateTvshow(ts){
                let that = this;
                
                axios.put("/api/update-tvshow/" + ts.id, {
                    tvshow: ts
                })
                .then(function (response) {
                    if (response.status != 200 || !response.data.status) {                        
                        return new Error("Something went wrong");
                    }

                    let newTvshow = response.data.tvshow;
                    
                    that.saveCover(response.data.tvshow.id)
                    .then(data => {
                        newTvshow.cover = data.src;
                    })
                    .catch(function (error) {
                        console.log(error);
                        newTvshow = response.data.tvshow.cover;
                    })
                    .then(function () {
                        that.$store.dispatch("saveTvShow", newTvshow);
                    });                  

                    $('#modal').modal('toggle');

                })
                .catch(function (error) {
                    alert(error);

                });
            },
            saveCover(id){

                var to_return;

                if(this.$store.state.cover.update && this.$store.state.cover.update == 1){
                    const config = {
                        headers: { "content-type": "multipart/form-data" },
                    };
                    const data = new FormData();
                    data.append('cover', this.$store.state.cover.data);
                    const json = JSON.stringify({
                        tvshow_id: id
                    });

                    data.append('data', json);

                    return axios.post("/api/save-cover", data, config)
                        .then(response => {

                            if (response.status != 200 && !response.data.status) {
                                return new Error("Something went wrong");
                            }

                            return response.data;

                        })
                        .catch(function(error) {
                            return error;
                        });
                }
                return false;
            },
            syncData(){
                if(this.updating){
                    
                    this.id = this.to_update.id;
                    this.name= this.to_update.name;
                    this.year= this.to_update.year;
                    this.synopsis= this.to_update.synopsis;
                    this.seasons_quantity= this.to_update.seasons_quantity;
                    this.category_id= this.to_update.category_id;
                    this.status_id= this.to_update.status_id;
                    this.year= this.to_update.year;
                    this.cover= this.to_update.cover;

                    // console.log(this.to_update);

                    this.$store.dispatch("setCover", { src: this.cover, data: '', update: 0});
                    
                }else{

                    this.id = 0;
                    this.name= '';
                    this.year= null;
                    this.synopsis= '';
                    this.seasons_quantity= null;
                    this.category_id= 0;
                    this.status_id= 1;
                    this.year= 0;
                    this.cover= '/image/default-movie.png';

                    this.$store.dispatch("setCover", { src: this.cover, data: '', update: 0});

                }
            },
            seasons_quantity_filter(event) {
                const value = event.target.value;
                // console.log(value, this.amount)
                    if (String(value).length <= 2) {
                        this.seasons_quantity = value
                    }
                this.$forceUpdate()
            }
        },
        watch: {
            updating: function(){
                this.syncData();
            },
            to_update_id: function(){
                this.syncData();
            },
            to_update: function(){
                this.errorMsg = '';
            },
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
            },
            validateBtn: function(){

                if(this.name != '' && this.synopsis && this.seasons_quantity > 0 && this.category_id > 0 && this.year != 0){
                    return false;
                }

                return true;
            }
        }
    }
</script>
