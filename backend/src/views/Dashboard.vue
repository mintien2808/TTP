<template>
  <div class="mb-2 flex items-center justify-between">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <!-- Active Customers -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="text-lg font-semibold block mb-2">Active Customers</label>
      <template v-if="!loading.customersCount">
        <span class="text-3xl font-semibold">{{ customersCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
    <!-- Active Products -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
         style="animation-delay: 0.1s">
      <label class="text-lg font-semibold block mb-2">Active Products</label>
      <template v-if="!loading.productsCount">
        <span class="text-3xl font-semibold">{{ productsCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
    <!-- Active Categories -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
         style="animation-delay: 0.2s">
      <label class="text-lg font-semibold block mb-2">Active Categories</label>
      <template v-if="!loading.categoriesCount">
        <span class="text-3xl font-semibold">{{ categoriesCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
  </div>
</template>

<script setup>
import axiosClient from "../axios.js";
import { onMounted, ref } from "vue";

const chosenDate = ref('all');

const loading = ref({
  customersCount: true,
  productsCount: true,
  categoriesCount: true,
});

const customersCount = ref(0);
const productsCount = ref(0);
const categoriesCount = ref(0);

function updateDashboard() {
  const d = chosenDate.value;
  loading.value = {
    customersCount: true,
    productsCount: true,
    categoriesCount: true,
  };
  
  axiosClient.get(`/dashboard/customers-count`, { params: { d } }).then(({ data }) => {
    customersCount.value = data;
    loading.value.customersCount = false;
  });
  
  axiosClient.get(`/dashboard/products-count`, { params: { d } }).then(({ data }) => {
    productsCount.value = data;
    loading.value.productsCount = false;
  });
  
  axiosClient.get(`/dashboard/categories-count`, { params: { d } }).then(({ data }) => {
    categoriesCount.value = data;
    loading.value.categoriesCount = false;
  });
}

onMounted(() => updateDashboard());
</script>

<style scoped>
.grid {
  gap: 1.5rem; 
}

.animate-fade-in-down {
  animation: fadeInDown 0.4s ease-in-out;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
