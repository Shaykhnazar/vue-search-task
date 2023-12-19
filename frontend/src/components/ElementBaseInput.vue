<template>
  <el-form-item
      :label="labelName"
      :prop="fieldName"
  >
    <el-input
        v-if="formInputType === 'number'"
        v-model.number="form[fieldName]"
        :type="formInputType"
        autocomplete="off"
    />
    <el-input
        v-else
        v-model="inputValue"
        :type="formInputType"
        autocomplete="off"
    />
  </el-form-item>
</template>
<script setup>
import { ref, watchEffect } from 'vue'

const props = defineProps({
    fieldName: {
        type: String,
        required: true
    },
    form: {
        type: Object,
        required: true
    },
    labelName: {
        type: String,
    },
    fieldType: {
        type: String,
        default: 'number'
    },
    formInputType: {
        type: String,
        default: 'number'
    }
})

const inputValue = ref(props.form[props.fieldName])

watchEffect(() => {
    props.form[props.fieldName] = inputValue.value
})
</script>
