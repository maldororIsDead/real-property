<template>
    <div class="mt-5 container text-center justify-content-center align-items-center">
        <img class="mb-4" src="https://skyup.studio/wp-content/uploads/2019/02/logo.png" alt="">
        <div class="m-auto d-flex justify-content-center align-items-center flex-column">
            <div class="d-flex col-8 flex-column mt-2 mt-md-0">
                <div v-if="~parameters.indexOf('name')" class="form-group">
                    <input class="form-control mr-sm-2" type="text" v-model="query.name" placeholder="Name"
                           aria-label="Search">
                </div>
                <div v-if="~parameters.indexOf('price')" class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">First and last name</span>
                        </div>
                        <input type="number" v-model="query.price.from" min="0" class="form-control">
                        <input type="number" v-model="query.price.to" class="form-control">
                    </div>
                </div>
                <div v-if="~parameters.indexOf('bedrooms')" class="form-group">
                    <input class="form-control mr-sm-2" type="number" v-model="query.bedrooms" placeholder="Bedrooms"
                           aria-label="Search">
                </div>
                <div v-if="~parameters.indexOf('bathrooms')" class="form-group">
                    <input class="form-control mr-sm-2" type="number" v-model="query.bathrooms" placeholder="Bathrooms"
                           aria-label="Search">
                </div>
                <div v-if="~parameters.indexOf('storeys')" class="form-group">
                    <input class="form-control mr-sm-2" type="number" v-model="query.storeys" placeholder="Storeys"
                           aria-label="Search">
                </div>
                <div v-if="~parameters.indexOf('garages')" class="form-group">
                    <input class="form-control mr-sm-2" type="number" v-model="query.garages" placeholder="Storeys"
                           aria-label="Search">
                </div>
                <button v-if="parameters.length" @click="search" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
        </div>
        <div class="checkbox mb-3">
            <label class="p-2" v-for="column in columns">
                <input type="checkbox" @change="check($event)" v-model="parameters" :value="column" :checked="column === 'name'"> {{ column }}
            </label>
        </div>
        <div v-if="searching">
            <b-spinner label="Loading..."></b-spinner>
        </div>
        <table v-if="results && results.length" class="m-3 table table-dark">
            <thead>
            <tr>
                <th scope="col" v-for="column in columns">{{ column }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="result in results">
                <td>{{ result.name }}</td>
                <td>{{ result.price }}</td>
                <td>{{ result.bedrooms }}</td>
                <td>{{ result.bathrooms }}</td>
                <td>{{ result.storeys }}</td>
                <td>{{ result.garages }}</td>
            </tr>
            </tbody>
        </table>
        <div class="alert alert-danger" role="alert" v-if="noResults">
            Sorry, but no results were found.
        </div>
    </div>
</template>

<script>
    export default {
        name: "home",
        data() {
            return {
                columns: ['name', 'price', 'bedrooms', 'bathrooms', 'storeys', 'garages'],
                query: {
                    price: {}
                },
                results: [],
                parameters: [],
                value: 0,
                noResults: false,
                searching: false
            }
        },
        methods: {
            search: function () {
                this.searching = true;
                fetch('/api/search', {
                    method: 'post',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.query)
                }).then(res => res.json())
                    .then(res => {
                        this.searching = false;
                        this.results = res.data;
                        this.noResults = this.results.length === 0;
                    });
            },
        }
    }
</script>