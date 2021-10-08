<template>
    <div class='container'>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="lead">Samochód #{{ this.id }}</span>
                <div class="d-inline float-right">
                    <button v-if="mode==='view'"
                        @click="edit()"
                        type="button" 
                        class="btn btn-primary d-inline">
                        Edytuj
                    </button> 
                    <button v-if="mode==='edit'"
                        @click="save()"
                        type="button" 
                        class="btn btn-primary d-inline">
                        Zapisz
                    </button> 
                    <button v-if="mode==='edit'"
                        @click="cancel()"
                        type="button" 
                        class="btn btn-outline-primary d-inline">
                        Anuluj
                    </button>            
                    <button v-if="!del_started"
                        @click="del('start')"
                        type="button" 
                        class="btn btn-secondary d-inline">
                        Usuń
                    </button> 
                    <button v-if="del_started"
                        @click="del('del')"
                        type="button" 
                        class="btn btn-danger d-inline">
                        Usuń
                    </button> 
                    <button v-if="del_started"
                        @click="del('undo')"
                        type="button" 
                        class="btn btn-outline-danger d-inline">
                        Anuluj
                    </button> 
                </div>
            </div>
            <div v-if="loaded" class="card-body">
                <div v-for="field in fields" :key="field">
                    <car-details-item-component 
                    :field="fieldNames[field]" 
                    :mode="editable[field] ? mode : 'view'"
                    :showInvalid="(!isValid(field) && showHints)"
                    v-model="details[field]"/>
                </div>
            </div>
            <div v-else class="card-body text-center">
                <div class="spinner-border text-secondary" role="status">
                    <span class="sr-only">Loading... </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CarDetailsItemComponent from './CarDetailsItem.vue'

export default {
props: ['id'],
components: { CarDetailsItemComponent },
created() { this.getDetails() },

data() {
    return {
        mode: 'view',
        details: {},
        del_started: false,
        loaded: false,
        showHints: false,
    };
},

computed: {
    required: function() {
        return {
            nazwa: true,
            rejestracja: true,
            stan_licznika: true,
        }
    },
    number: function() {
        return {
            stan_licznika: true,
            stan_licznika_wymiana_oleju: true,
        }
    },
    fields: function() {
        return Object.keys(this.details)
    },
    fieldNames: function() {
        return {
            id: "Id",
            nazwa: "Nazwa",
            rejestracja: "Rejestracja",
            stan_licznika: "Stan licznika",
            marka: "Marka",
            model: "Model",
            kolor: "Kolor",
            ostatni_przeglad_data: "Data ostatniego przeglądu",
            stan_licznika_wymiana_oleju: "Ostatnia wymiana oleju (stan licznika)",
            created_at: "Utworzono",
            updated_at: "Modyfikowano"
        }
    },
    editable: function() {
        return {
            nazwa: true,
            rejestracja: true,
            stan_licznika: true,
            marka: true,
            model: true,
            ostatni_przeglad_data: true,
            stan_licznika_wymiana_oleju: true,
            kolor: true,
        }
    }
},

methods: {
    allValid() {
        for (const field of this.fields) {
            if (!this.isValid(field)) { return false }
        }
        return true
    },
    isValid(field) {
        if (this.required[field] && !this.details[field]) { return false }
        if (this.number[field] && isNaN(this.details[field])) { return false }
        return true
    },
    del(action) {
        if (action=='start') { this.del_started=true }
        if (action=='undo') { this.del_started=false }
        if (action=='del') { 
            axios.delete('/api/cars/' + this.id)
            .then( window.location.href = '/cars/')
            .catch( error => { console.log( error )})
         }
    },
    edit(){
        this.mode = 'edit'
    },
    save(){
        if (this.allValid()) {
            this.loaded = false,
            axios.put('/api/cars/' + this.id, this.details)
            .then( response => { 
                this.details = response.data 
                this.loaded = true
            })
            .catch( error => { console.log( error )})
            this.mode = 'view'
        } else { this.showHints = true }
    },
    cancel(){
        this.loaded = false,
        this.getDetails()
        this.mode = 'view'
    },

    getDetails() {
        axios.get('/api/cars/' + this.id)
        .then( response => { 
            this.details = response.data 
            this.loaded = true
        })
        .catch( error => { console.log( error )})
    },
},

}
</script>