import { defineStore } from "pinia";

import { httpWrapper } from "../helpers/http-wrapper";

const baseUrl = `${import.meta.env.VITE_API_URL}`;

export const useFruitStore = defineStore({
    id: "fruit",
    state: () => ({
        data: [],
        networkMessage: "",
    }),
    actions: {
        async getAll() {
            const response = await httpWrapper.get(`${baseUrl}/fruit`);
            this.updateData(response.data);
            this.networkMessage = response.message;
        },

        async search(name?: string, family?: string) {
            const response = await httpWrapper.get(`${baseUrl}/fruit`, {
                name,
                family
            });
            this.updateData(response.data);
            this.networkMessage = response.message;
        },

        async getFavorites() {
            const response = await httpWrapper.get(`${baseUrl}/favorite`);
            this.updateData(response.data);
            this.networkMessage = response.message;
        },

        async addFavorite(fruitId: number) {
            const response = await httpWrapper.post(`${baseUrl}/favorite/${fruitId}`);
            this.networkMessage = response.message;
        },

        async removeFavorite(fruitId: number) {
            const response = await httpWrapper.delete(`${baseUrl}/favorite/${fruitId}`);
            this.networkMessage = response.message;
        },

        updateData(data: []) {
            this.data.splice(0, this.data.length);
            this.data.push(...data);
        },
    },
});
