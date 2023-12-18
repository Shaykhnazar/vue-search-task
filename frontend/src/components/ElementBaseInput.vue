<template>
  <el-form-item
      :label="fieldName"
      prop="age"
      :rules="[
        { required: fieldRequired, message: `${fieldName} is required` },
        { type: fieldType, message: `${fieldName} must be a ${fieldType}` },
      ]"
  >
    <el-input
        v-model="form[fieldName]"
        :type="formInputType"
        autocomplete="off"
    />
  </el-form-item>
</template>
<script setup>
defineProps({
    fieldName: {
        type: String,
        required: true
    },
    form: {
        type: Object,
        required: true
    },
    fieldType: {
        type: String,
        default: 'number'
    },
    fieldRequired: {
        type: Boolean,
        default: false
    },
    formInputType: {
        type: String,
        default: 'number'
    }
})
</script>
