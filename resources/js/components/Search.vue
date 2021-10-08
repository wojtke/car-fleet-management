<template>
    <div class="card-body my-n2 mx-n3 ">
        <div class="container">
            <div class="row">
                <div class="col-sm my-1">
                    <input type="text" 
                    maxlength=30
                    class="form-control mr-2" 
                    placeholder="Szukaj pojazdów" 
                    v-model="query"
                    />
                </div>
                
                <div class="text-right py-2 my-1 col-6 col-sm-3 ">Szukaj po: </div>
                <div class="col-6 col-sm-4 my-1">
                    <select class="custom-select " v-model="selection">
                    <option value="nazwa">nazwie</option>
                    <option value="rejestracja">rejestracji</option>
                </select> 
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: "",
            selection: 'nazwa',
        };
    },
    watch: {
        query: function (after, before) {
            this.$emit('searchQueryChange', after)
        },
        selection: function (after, before) {
            this.$emit('searchSelectionChange', after)
        }
    },
    }
</script>