<template>
    <div class='row py-2 mt-n2 hover' style="border-bottom: solid #e1e1e1; border-width: 1px;" @click="hrefCarDetails()" >
        <div class='col-6 col-sm-3'>
            {{ car.nazwa }}
        </div>
        <div class='col-6 col-sm-3'>
            {{ car.rejestracja }}
        </div>
        <div class='col-6 col-sm-3'>
            {{ car.stan_licznika }}
        </div>
        <div class='col-6 col-sm-3'>
            {{ car.marka }} {{ car.model }}
        </div>
    </div>
</template>

<script>
export default {
    props: ['car'],
    
    methods: {
        hrefCarDetails(){
            window.location.href = '/cars/' + this.car.id;
        }
    }
}
</script>

<style scoped>
.row:hover {
    background-color: rgb(231, 234, 235);
}
</style>
