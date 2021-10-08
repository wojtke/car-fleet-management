<template>
    <div class='container'>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-inline lead">
                    Nowy samochód
                </div>
                <div class="d-inline float-right">
                    <button 
                        @click="save()"
                        type="button" 
                        class="btn btn-primary d-inline">
                        Dodaj samochód
                    </button>         
                </div>
            </div>
            <div class="card-body">
                <div v-for="field in fields" :key="field">
                    <car-details-item-component 
                    :field="fieldNames[field]" 
                    :mode="'edit'"
                    :showInvalid="(!isValid(field) && showHints)"
                    v-model="details[field]"/>
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

data() {
    return {
        details: {},
        showHints: false,
    };
},

computed: {
    fields: function() {
        return Object.keys(this.fieldNames)
    },
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
    fieldNames: function() {
        return {
            //id: "Id",
            nazwa: "Nazwa",
            rejestracja: "Rejestracja",
            stan_licznika: "Stan licznika",
            marka: "Marka",
            model: "Model",
            kolor: "Kolor",
            ostatni_przeglad_data: "Data ostatniego przeglądu",
            stan_licznika_wymiana_oleju: "Stan licznika przy ostatniej wymanie oleju",
            //created_at: "Utworzono",
            //updated_at: "Modyfikowano"
        }
    },
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
        if (this.number[field] && isNaN(this.details[field]) && this.details[field]) { return false }
        return true
    },
    save(){
        if (this.allValid()) {
            axios.post('/api/cars', this.details)
            .then( response => { window.location.href = '/cars/'+ response.data.id })
            .catch( error => { console.log( error )})
        } else { this.showHints = true }
    },
},

}
</script>