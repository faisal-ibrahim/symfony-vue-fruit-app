<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useFruitStore } from '../stores/fruit.store'
import { ref, onMounted } from 'vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

const fruitStore = useFruitStore()
const { data, networkMessage, totalRecords } = storeToRefs(fruitStore)

const nameFilter = ref('')
const familyFilter = ref('')

const nameFilterResult = ref('')
const familyFilterResult = ref('')

const searchLoading = ref(false)
const getFavoriteLoading = ref(false)
const getAllLoading = ref(false)

const search = async () => {
  searchLoading.value = true
  displayingAll.value = false
  displayingFavorites.value = false
  displayingFiltered.value = true
  page.value = 0
  loadLazyData()
  nameFilterResult.value = nameFilter.value
  familyFilterResult.value = familyFilter.value
  searchLoading.value = false
}

const getAll = async () => {
  nameFilter.value = ''
  familyFilter.value = ''
  getAllLoading.value = true
  displayingAll.value = true
  displayingFavorites.value = false
  displayingFiltered.value = false
  page.value = 0
  loadLazyData()
  getAllLoading.value = false
}

const geFavorites = async () => {
  nameFilter.value = ''
  familyFilter.value = ''
  getFavoriteLoading.value = true
  displayingAll.value = false
  displayingFavorites.value = true
  displayingFiltered.value = false
  page.value = 0
  loadLazyData()
  getFavoriteLoading.value = false
}

const addFavorite = async (fruit: any) => {
  try {
    await fruitStore.addFavorite(fruit.id)
    fruit.isFavorite = true
    toast(networkMessage.value, {
      autoClose: 3000,
      type: toast.TYPE.SUCCESS
    })
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR
    })
  }
  fruit.isLoading = false
}

const removeFavorite = async (fruit: any) => {
  try {
    await fruitStore.removeFavorite(fruit.id)
    fruit.isFavorite = false
    toast(networkMessage.value, {
      autoClose: 3000,
      type: toast.TYPE.SUCCESS
    })
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR
    })
  }
}

onMounted(() => {
  loadLazyData()
})

const loading = ref(false)
const page = ref(0)
const limit = 10

const displayingAll = ref(true)
const displayingFiltered = ref(false)
const displayingFavorites = ref(false)

const loadLazyData = async () => {
  loading.value = true
  try {
    if (displayingAll.value) {
      await fruitStore.getAll(page.value, limit)
    } else if (displayingFiltered.value) {
      await fruitStore.search(nameFilter.value, familyFilter.value, page.value, limit)
    } else if (displayingFavorites.value) {
      await fruitStore.getFavorites(page.value, limit)
    }
  } catch (error: any) {
    toast(error.message, {
      autoClose: 3000,
      type: toast.TYPE.ERROR
    })
  }
  loading.value = false
}

const onPage = (event: any) => {
  page.value = event.page
  loadLazyData()
}
</script>

<template>
  <div class="container">
    <div class="table">
      <DataTable
        :value="data"
        tableStyle="min-width: 50rem;"
        stripedRows
        scrollable
        scrollHeight="40rem"
        lazy
        paginator
        :rows="limit"
        :totalRecords="totalRecords"
        @page="onPage($event)"
      >
        <template #header>
          <h2>Fruits Data Table</h2>
          <h3 v-if="displayingAll">( Displaying all fruits )</h3>
          <h3 v-if="displayingFiltered">
            ( Displaying fruits filtered by name ={{ nameFilterResult }}, family={{
              familyFilterResult
            }}
            )
          </h3>
          <h3 v-if="displayingFavorites">( Displaying favorite fruits )</h3>

          <div class="overflow-auto">
            <div class="float-left">
              <InputText placeholder="Enter Name" type="text" class="m-1" v-model="nameFilter" />
              <InputText
                placeholder="Enter Family"
                type="text"
                class="m-1"
                v-model="familyFilter"
              />
              <Button
                type="button"
                class="m-1"
                label="Search"
                icon="pi pi-search"
                :loading="searchLoading"
                @click="search"
              />
            </div>

            <div class="float-right">
              <Button
                type="button"
                class="m-1"
                label="Get Favorites"
                icon="pi pi-search"
                :loading="getFavoriteLoading"
                @click="geFavorites"
              />
              <Button
                type="button"
                class="m-1"
                label="Get All"
                icon="pi pi-search"
                :loading="getAllLoading"
                @click="getAll"
              />
            </div>
          </div>
        </template>
        <Column field="isFavorite">
          <template #header>
            <div class="text-align-center">Favorite</div>
          </template>
          <template #body="{ data }">
            <div class="p-d-flex p-justify-center favorite-cell">
              <button
                @click="data.isFavorite ? removeFavorite(data) : addFavorite(data)"
                class="favorite-btn"
              >
                <i
                  class="pi"
                  :class="[data.isFavorite ? 'pi-heart-fill color-gold' : 'pi pi-heart color-gray']"
                ></i>
              </button>
            </div>
          </template>
        </Column>
        <Column field="name" header="Name"></Column>
        <Column field="family" header="Family"></Column>
        <Column field="fruitOrder" header="Order"></Column>
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
