<template>
    <div class='row py-2'>
        <div class="col-5 text-right py-1" style="width: 50%">{{ field }}: </div>
        <div v-if="mode==='view'" 
            class="col-5 text-left py-1" 
            style="width: 40%"> 
            {{ value }}
        </div>
        <div v-else class="col-7 text-left py-1" >

            <input v-if="mode==='edit' && !showInvalid" class="form-control my-n2 ml-n3" type="text" 
                maxlength=30
                style="width: 60%"
                v-bind:value="value"
                v-on:input="$emit('input', $event.target.value)"> 

            <input v-else class="form-control my-n2 ml-n3 is-invalid" type="text" 
                maxlength=30
                style="width: 60%"
                v-bind:value="value"
                v-on:input="$emit('input', $event.target.value)"> 
        </div>
    </div>
</template>

<script>

export default {
    props: ['field', 'mode', 'value', 'showInvalid'],
}
</script>
