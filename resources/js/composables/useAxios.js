// resources/js/composables/useAxios.js
import { inject } from 'vue';
import axios from "axios"
export function useAxios() {

    const baseURL = "http://exercice.test/api/"
    const get = async (url, config = {}) => {
        try {
            const response = await axios.get(baseURL+url, config);
            return response.data;
        } catch (error) {
            console.error('Error in GET request:', error);
            throw error;
        }
    };

    const post = async (url, data = {}, config = {'Access-Control-Allow-Origin':'*'}) => {
        try {
            const response = await axios.post(baseURL+url, data, config);
            return response.data;
        } catch (error) {
            console.error('Error in POST request:', error);
            throw error;
        }
    };

    return {
        get,
        post,
    };
}
