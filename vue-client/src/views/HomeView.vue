<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { ref, onMounted } from 'vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import { useFruitStore } from '../stores/fruit.store'
import { showToast, showErrorToast } from '../helpers/toast-helper'

const fruitStore = useFruitStore()
const { data, networkMessage, totalRecords } = storeToRefs(fruitStore)
type DisplayType = 'Filter' | 'All' | 'Favorites'

const nameFilter = ref('')
const familyFilter = ref('')

const nameFilterResult = ref('')
const familyFilterResult = ref('')

const searchLoading = ref(false)
const getFavoriteLoading = ref(false)

const displayType = ref<DisplayType>('All')

const page = ref(0)
const limit = 10

const clearFilter = async () => {
  nameFilter.value = ''
  familyFilter.value = ''
  search()
}

const search = async () => {
  //Store the filter and use it as the result heading
  nameFilterResult.value = nameFilter.value
  familyFilterResult.value = familyFilter.value

  displayType.value = nameFilter.value == '' && familyFilter.value == '' ? 'All' : 'Filter'
  page.value = 0
  searchLoading.value = true
  loadLazyData()
  searchLoading.value = false
}

const geFavorites = async () => {
  //Clear the filter
  nameFilter.value = ''
  familyFilter.value = ''

  displayType.value = 'Favorites'
  page.value = 0
  getFavoriteLoading.value = true
  loadLazyData()
  getFavoriteLoading.value = false
}

const addFavorite = async (fruit: any) => {
  try {
    await fruitStore.addFavorite(fruit.id)
    fruit.isFavorite = true
    showToast(networkMessage.value)
  } catch (error: any) {
    showErrorToast(error.message)
  }
}

const removeFavorite = async (fruit: any) => {
  try {
    await fruitStore.removeFavorite(fruit.id)
    fruit.isFavorite = false
    showToast(networkMessage.value)
  } catch (error: any) {
    showErrorToast(error.message)
  }
}

const loadLazyData = async () => {
  try {
    if (displayType.value == 'All' || displayType.value == 'Filter') {
      await fruitStore.search(nameFilter.value, familyFilter.value, page.value, limit)
    } else {
      await fruitStore.getFavorites(page.value, limit)
    }
  } catch (error: any) {
    showErrorToast(error.message)
  }
}

const onPage = (event: any) => {
  page.value = event.page
  loadLazyData()
}

onMounted(() => {
  loadLazyData()
})
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
          <h3 v-if="displayType == 'All'">( Displaying all fruits )</h3>
          <h3 v-if="displayType == 'Filter'">
            ( Displaying fruits filtered by name = '{{ nameFilterResult }}', family = '{{
              familyFilterResult
            }}' )
          </h3>
          <h3 v-if="displayType == 'Favorites'">( Displaying favorite fruits )</h3>

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
              <Button type="button" class="m-1" label="Clear Filter" @click="clearFilter" />
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
