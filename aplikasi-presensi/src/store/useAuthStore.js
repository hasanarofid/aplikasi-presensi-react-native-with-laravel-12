import { create } from 'zustand';
import AsyncStorage from '@react-native-async-storage/async-storage';
import apiClient from '../api/client';

const useAuthStore = create((set) => ({
  user: null,
  token: null,
  isLoading: true,

  login: async (email, password) => {
    try {
      const response = await apiClient.post('/login', {
        email,
        password,
        device_name: 'mobile_app',
      });
      const { token, user } = response.data;
      await AsyncStorage.setItem('token', token);
      set({ token, user, isLoading: false });
      return { success: true };
    } catch (error) {
      console.error('Login error:', error.response?.data || error.message);
      return { success: false, message: error.response?.data?.message || 'Login failed' };
    }
  },

  logout: async () => {
    try {
      await apiClient.post('/logout');
    } catch (e) {}
    await AsyncStorage.removeItem('token');
    set({ token: null, user: null });
  },

  checkAuth: async () => {
    const token = await AsyncStorage.getItem('token');
    if (!token) {
      set({ isLoading: false });
      return;
    }

    try {
      const response = await apiClient.get('/me');
      set({ token, user: response.data, isLoading: false });
    } catch (error) {
      await AsyncStorage.removeItem('token');
      set({ token: null, user: null, isLoading: false });
    }
  },
}));

export default useAuthStore;
