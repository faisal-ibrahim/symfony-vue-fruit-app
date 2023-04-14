import { defineStore } from 'pinia'

import { httpWrapper } from '../helpers/http-wrapper'

const baseUrl = `${import.meta.env.VITE_API_URL}`

interface IFruitState {
  data: any[]
  networkMessage: string
  totalRecords: number
}

export const useFruitStore = defineStore({
  id: 'fruit',
  state: (): IFruitState => ({
    data: [],
    networkMessage: '',
    totalRecords: 0
  }),
  actions: {
    async search(name?: string, family?: string, page?: number, limit?: number) {
      const url = `${baseUrl}/fruits?name=${name}&family=${family}&page=${page}&limit=${limit}`
      const response = await httpWrapper.get(url)
      this.updateData(response)
    },

    async getFavorites(page?: number, limit?: number) {
      const url = `${baseUrl}/favorites?page=${page}&limit=${limit}`
      const response = await httpWrapper.get(url)
      this.updateData(response)
    },

    async addFavorite(fruitId: number) {
      const response = await httpWrapper.post(`${baseUrl}/favorites/${fruitId}`)
      this.networkMessage = response.message
    },

    async removeFavorite(fruitId: number) {
      const response = await httpWrapper.delete(`${baseUrl}/favorites/${fruitId}`)
      this.networkMessage = response.message
    },

    updateData(response: any) {
      this.data.splice(0, this.data.length)
      const result = response.data.data
      this.data.push(...result)
      this.networkMessage = response.message
      this.totalRecords = response.data.totalResult
    }
  }
})
