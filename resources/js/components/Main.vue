<template>
    <div class='container'>
        <div class="card mb-3">
            <search-component
            @searchQueryChange="setSearchQuery($event)"
            @searchSelectionChange="setSearchSelection($event)"
            />
        </div>
        <div class="card my-3">
            <list-view-component 
            :cars="cars"
            @sortChange="setSort($event)"
            />
        </div>

        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="10"/>
        <div v-if="busy" class="text-center">
            <span>Loading... </span>
            <div class="spinner-border text-secondary" role="status">
                <span class="sr-only">Loading... </span>
            </div>
        </div>
        <div v-if="allLoaded && !busy" class="text-center">
            <span>All loaded</span>
        </div>
        
    </div >
</template>

<script>

import ListViewComponent from './ListView.vue'
import SearchComponent from './Search.vue'

export default {
components:{ ListViewComponent, SearchComponent },
created(){ this.getList() },

data: function() {
    return {
        cars: [],
        searchQuery: "",
        searchSelection: "nazwa",
        sortBy: "",
        sortDirection: "asc",
        page: 1,
        busy: false,
        allLoaded: false,
        }
},

methods: {
    loadMore() {
        if (!this.allLoaded) {
            this.busy = true;
            this.page += 1

            axios.get('/api/cars', {
                params: {
                    search: this.searchQuery,
                    searchBy: this.searchSelection,
                    sortBy: this.sortBy,
                    sortDir: this.sortDirection,
                    page: this.page,
                } 
            })
            .then( response => { 
            if (response.data.next_page_url == null) { this.allLoaded = true }
                this.cars = this.cars.concat(response.data.data)
                this.busy = false;
            })
            .catch( error => { console.log( error )})
        }
    },
    getList() {
        this.page = 1
        this.allLoaded = false,
        axios.get('/api/cars', {
            params: {
                search: this.searchQuery,
                searchBy: this.searchSelection,
                sortBy: this.sortBy,
                sortDir: this.sortDirection,
                page: 1,
            } 
        })
        .then( response => { 
            if (response.data.next_page_url == null) { this.allLoaded = true }
            this.cars = response.data.data
        })
        .catch( error => { console.log( error )})
    },
    setSearchQuery(query) {
        this.searchQuery = query
        this.getList()
        this.loadMore()
    },
    setSearchSelection(selection) {
        this.searchSelection = selection
        this.getList()
        this.loadMore()
    },
    setSort(sort) {
        this.sortBy = sort.by
        this.sortDirection = sort.dir
        this.getList()
        this.loadMore()
    },
},

}
</script>
