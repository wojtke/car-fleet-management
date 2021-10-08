<template>
    <div>
        <div class="card-header">
            <div class='container'>
                <div class='row no-gutters'>
                    <div class='col-6 col-md-3 px-2 py-1' @click="setSort('nazwa')">
                        <span class='header'>Nazwa</span>
                        <span v-if="sort.by === 'nazwa'">
                            <span v-if="sort.dir === 'asc'">&uarr;</span>
                            <span v-else>&darr;</span>
                        </span>
                        <span v-if="sort.by === ''">&uarr;&darr;</span>
                    </div>
                    <div class='col-6 col-md-3 px-2 py-1' @click="setSort('rejestracja')">
                        <span class='header'>Rejestracja</span>
                        <span v-if="sort.by === 'rejestracja'">
                            <span v-if="sort.dir === 'asc'">&uarr;</span>
                            <span v-else>&darr;</span>
                        </span>
                        <span v-if="sort.by === ''">&uarr;&darr;</span>
                    </div>
                    <div class='col-6 col-md-3 px-2 py-1' @click="setSort('stan_licznika')">
                        <span class='header'>Stan licznika</span>
                        <span v-if="sort.by === 'stan_licznika'">
                            <span v-if="sort.dir === 'asc'">&uarr;</span>
                            <span v-else>&darr;</span>
                        </span>
                        <span v-if="sort.by === ''">&uarr;&darr;</span>
                    </div>
                    <div class='col-6 col-md-3 px-2 py-1'>
                        <span class='header'>Marka/model</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class='container py-1' v-for="(car, index) in cars" :key="index">
                <list-item-component :car="car"/>
            </div>
        </div>
    </div>
</template>

<script>
import ListItemComponent from './ListItem.vue'

export default {
props: ['cars'],
components: { ListItemComponent },

data() {
    return {
        sort: {
            by: "",
            dir: "asc"
        }
    };
},

methods: {
    setSort(by) {
        if (by == this.sort.by) {
            if (this.sort.dir === 'asc'){
                this.sort.dir = 'desc'
            } else {
                this.sort.by = ''
            }
        } else {
            this.sort.by = by
            this.sort.dir = 'asc'
        }

        this.$emit('sortChange', this.sort)
    },
}

}
</script>

<style scoped>
.col-6:hover {
    background-color: rgb(231, 234, 235);
}
.header {
    font-size: 15px;
}
</style>