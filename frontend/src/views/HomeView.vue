<script lang="ts" setup>
import {onBeforeMount, reactive, ref} from 'vue'
import type {FormInstance, FormRules} from 'element-plus'
import ElementBaseInput from "@/components/ElementBaseInput.vue";
import api from "../services/api";

const tableData = ref([])
const loading = ref(false)

const formRef = ref<FormInstance>()

const form = reactive({
    name: null,
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
        price_min: form.priceMin ?? null,
        price_max: form.priceMax ?? null,
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

const checkDigit = (rule: any, value: any, callback: any) => {
    if (value && !Number.isInteger(value)) {
        callback(new Error('Please input digits'))
    } else {
        if (value < 0) {
            callback(new Error('Input value must be greater than 0'))
        }
        callback()
    }
}

const validatePriceMin = (rule: any, value: any, callback: any) => {
    if (value && !Number.isInteger(value)) {
        callback(new Error('Please input digits'))
    } else {
        if (value && !form.priceMax) {
            callback(new Error('Price to is required'))
        } else if (value && value > form.priceMax) {
            callback(new Error('Price from must be less than Price to'))
        }
        callback()
    }
}

const validatePriceMax = (rule: any, value: any, callback: any) => {
    if (value && !Number.isInteger(value)) {
        callback(new Error('Please input digits'))
    } else {
        if (value && !form.priceMin) {
            callback(new Error('Price from is required'))
        } else if (value && value < form.priceMax) {
            callback(new Error('Price to must be greater than Price from'))
        }
        callback()
    }
}

const rules = reactive<FormRules<typeof formRef>>({
    priceMin: [{validator: validatePriceMin, trigger: 'blur'}],
    priceMax: [{validator: validatePriceMax, trigger: 'blur'}],
    garages: [{validator: checkDigit, trigger: 'blur'}],
    bedrooms: [{validator: checkDigit, trigger: 'blur'}],
    bathrooms: [{validator: checkDigit, trigger: 'blur'}],
    storeys: [{validator: checkDigit, trigger: 'blur'}]
})


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
                  :rules="rules"
                  label-width="100px"
                  class="demo-ruleForm"
              >
                  <ElementBaseInput :form="form" field-name="name" label-name="Name" form-input-type="text" field-type="string"/>
                  <ElementBaseInput :form="form" field-name="priceMin" label-name="Price from" />
                  <ElementBaseInput :form="form" field-name="priceMax" label-name="Price to" />
                  <ElementBaseInput :form="form" field-name="garages" label-name="Garages" />
                  <ElementBaseInput :form="form" field-name="bedrooms" label-name="Bedrooms" />
                  <ElementBaseInput :form="form" field-name="bathrooms" label-name="Bathrooms" />
                  <ElementBaseInput :form="form" field-name="storeys" label-name="Storeys"/>
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
