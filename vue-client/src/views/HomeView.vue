<script setup lang="ts">
import { storeToRefs } from "pinia";
import { useFruitStore } from "../stores/fruit.store";
import { ref, onMounted } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const fruitStore = useFruitStore();
const { data, networkMessage } = storeToRefs(fruitStore);

const nameFilter = ref("");
const familyFilter = ref("");

const searchLoading = ref(false);
const getFavoriteLoading = ref(false);
const getAllLoading = ref(false);

const search = async () => {
  searchLoading.value = true;
  try {
    await fruitStore.search(nameFilter.value, familyFilter.value);
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR,
    });
  }
  searchLoading.value = false;
};


const getAll = async () => {
  nameFilter.value = "";
  familyFilter.value = "";
  getAllLoading.value = true;
  try {
    await fruitStore.getAll();
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR,
    });
  }
  getAllLoading.value = false;
};

const geFavorites = async () => {
  nameFilter.value = "";
  familyFilter.value = "";
  getFavoriteLoading.value = true;
  try {
    await fruitStore.getFavorites();
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR,
    });
  }
  getFavoriteLoading.value = false;
};

const addFavorite = async (fruit: any) => {
  try {
    await fruitStore.addFavorite(fruit.id);
    fruit.isFavorite = true;
    toast(networkMessage.value, {
      autoClose: 3000,
      type: toast.TYPE.SUCCESS,
    });

  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR,
    });
  }
  fruit.isLoading = false;
};

const removeFavorite = async (fruit: any) => {
  try {
    await fruitStore.removeFavorite(fruit.id);
    fruit.isFavorite = false;
    toast(networkMessage.value, {
      autoClose: 3000,
      type: toast.TYPE.SUCCESS,
    });

  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR,
    });
  }

};

onMounted(() => {
  getAll();
});

</script>

<template>
  <div class="container">
    <div class="table">
      <DataTable :value="data" tableStyle="min-width: 50rem" stripedRows paginator :rows="10" showGridlines>
        <template #header>

          <h2>Fruits Data Table</h2>

          <div class="overflow-auto">
            <div class="float-left">
              <InputText placeholder="Enter Name" type="text" class="m-1" v-model="nameFilter" />
              <InputText placeholder="Enter Family" type="text" class="m-1" v-model="familyFilter" />
              <Button type="button" class="m-1" label="Search" icon="pi pi-search" :loading="searchLoading"
                @click="search" />
            </div>

            <div class="float-right">
              <Button type="button" class="m-1" label="Get Favorites" icon="pi pi-search" :loading="getFavoriteLoading"
                @click="geFavorites" />
              <Button type="button" class="m-1" label="Get All" icon="pi pi-search" :loading="getAllLoading"
                @click="getAll" />
            </div>

          </div>
        </template>
        <Column field="isFavorite">
          <template #header>
            <div class="text-align-center">Favorite</div>
          </template>
          <template #body="{ data }">
            <div class="p-d-flex p-justify-center favorite-cell">
              <button @click="data.isFavorite ? removeFavorite(data) : addFavorite(data)" class="favorite-btn">
                <i class="pi" :class="[data.isFavorite ? 'pi-heart-fill color-gold' : 'pi pi-heart color-gray']"></i>
              </button>
            </div>
          </template>
        </Column>
        <Column field="name" header="Name"></Column>
        <Column field="family" header="Family"></Column>
        <Column field="fruit_order" header="Order"></Column>
        <Column field="genus" header="Genus"></Column>
        <Column field="calories" header="Calories"></Column>
        <Column field="fat" header="Fat"></Column>
        <Column field="sugar" header="Sugar"></Column>
        <Column field="carbohydrates" header="Carbohydrates"></Column>
        <Column field="protein" header="Protein"></Column>
      </DataTable>
    </div>
  </div>
</template>
