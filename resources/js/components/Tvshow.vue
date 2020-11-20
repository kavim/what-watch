<template>
    <div class="row justify-content-center">
        <div class="col-8">
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
                        <label for="sq">Quantidade de temporadas</label>
                        <input v-model="season_qty" type="number" class="form-control" id="sq">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sq">Categoria</label>
                        <select v-model="category_id" class="form-control">
                            <option disabled hidden value="0">Categoria</option>
                            <option v-for="option in categoriesAs" v-bind:value="option.value" :key="option.value">
                                {{ option.text }}
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
                </div>
                <button @click="submit" type="submit" class="btn btn-outline-dark">DALE</button>
            <!-- </form> -->
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: 0,
                name: '',
                year: null,
                synopsis: '',
                season_qty: null,
                category_id: 0,
                status_id: 0,
                year: 0
            }
        },
        methods: {
            submit: function(){
                let ts = {
                    id: 0,
                    name: this.name,
                    year: this.year,
                    synopsis: this.synopsis,
                    season_qty: this.season_qty,
                    category_id: this.category_id,
                    status_id: this.status_id,
                    year: this.year
                }

                this.$store.dispatch("saveTvShow", ts);
            }
        },
        mounted() {
            
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
