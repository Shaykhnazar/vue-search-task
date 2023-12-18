<script lang="ts" setup>
import {onBeforeMount, reactive, ref} from 'vue'
import type {FormInstance} from 'element-plus'
import ElementBaseInput from "@/components/ElementBaseInput.vue";
import api from "../services/api";

const tableData = ref([])
const loading = ref(false)

const formRef = ref<FormInstance>()

const form = reactive({
    name: '',
    priceMin: null,
    priceMax: null,
    garages: null,
    bedrooms: null,
    bathrooms: null,
    storeys: null,
})

onBeforeMount(() => {
    getPropertyData()
})

function getPropertyData() {
    loading.value = true
    api.properties.listWithFilter({
        name: form.name ?? null,
        price: [form.priceMin, form.priceMax] ?? null,
        garages: form.garages ?? null,
        bedrooms: form.bedrooms ?? null,
        bathrooms: form.bathrooms ?? null,
        storeys: form.storeys ?? null
    }).then(response => {
        tableData.value = response.data.data
        loading.value = false
    })
}
const submitForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            getPropertyData()
        } else {
            console.log('error submit!')
            return false
        }
    })
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
}

const columns = [
    {
        prop: 'name',
        label: 'Name',
        width: 200,
    },
    {
        prop: 'price',
        label: 'Price',
    },
    {
        prop: 'garages',
        label: 'Garages',
    },
    {
        prop: 'bedrooms',
        label: 'Bedrooms',
    },
    {
        prop: 'bathrooms',
        label: 'Bathrooms',
    },
    {
        prop: 'storeys',
        label: 'Storeys',
    },
];

</script>

<template>
  <el-container>
      <el-header>
          <h1><span style="text-align: center">Property Search Form</span></h1>
      </el-header>
      <el-container>
          <el-aside width="300px">
              <el-form
                  ref="formRef"
                  :model="form"
                  label-width="100px"
                  class="demo-ruleForm"
              >
                  <ElementBaseInput :form="form" field-name="name" form-input-type="text" field-type="string"/>
                  <ElementBaseInput :form="form" field-name="priceMin" />
                  <ElementBaseInput :form="form" field-name="priceMax" />
                  <ElementBaseInput :form="form" field-name="garages" />
                  <ElementBaseInput :form="form" field-name="bedrooms" />
                  <ElementBaseInput :form="form" field-name="bathrooms" />
                  <ElementBaseInput :form="form" field-name="storeys" />
                  <el-form-item>
                      <el-button type="primary" @click="submitForm(formRef)">Submit</el-button>
                      <el-button @click="resetForm(formRef)">Reset</el-button>
                  </el-form-item>
              </el-form>
          </el-aside>
          <el-main style="margin-left: 100px;">
              <span style="text-align: center"><h1>Result</h1></span>
              <el-table v-loading="loading" :data="tableData" style="width: 100%" height="400">
                  <template v-for="column in columns">
                      <el-table-column :prop="column.prop" :label="column.label" :width="column.width ?? 120"/>
                  </template>
              </el-table>
          </el-main>
      </el-container>
  </el-container>
</template>
