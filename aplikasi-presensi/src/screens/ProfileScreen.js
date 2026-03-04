import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import useAuthStore from '../store/useAuthStore';

const ProfileScreen = () => {
  const { user, logout } = useAuthStore();

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <View style={styles.avatar}>
          <Text style={styles.avatarText}>{user?.name?.charAt(0)}</Text>
        </View>
        <Text style={styles.name}>{user?.name}</Text>
        <Text style={styles.email}>{user?.email}</Text>
      </View>

      <View style={styles.menu}>
        <TouchableOpacity style={styles.menuItem}>
          <Text style={styles.menuText}>Edit Profile (Pending Acc)</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.menuItem}>
          <Text style={styles.menuText}>Change Password</Text>
        </TouchableOpacity>
        <TouchableOpacity style={[styles.menuItem, { borderBottomWidth: 0 }]} onPress={logout}>
          <Text style={[styles.menuText, { color: '#EF4444' }]}>Logout</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#F9FAFB' },
  header: { backgroundColor: '#312E81', padding: 40, alignItems: 'center' },
  avatar: { width: 80, height: 80, borderRadius: 40, backgroundColor: '#818CF8', justifyContent: 'center', alignItems: 'center', marginBottom: 15 },
  avatarText: { fontSize: 32, color: '#fff', fontWeight: 'bold' },
  name: { fontSize: 22, fontWeight: 'bold', color: '#fff' },
  email: { fontSize: 14, color: '#C7D2FE', marginTop: 5 },
  menu: { marginTop: 20, backgroundColor: '#fff', marginHorizontal: 20, borderRadius: 15, padding: 5 },
  menuItem: { padding: 20, borderBottomWidth: 1, borderBottomColor: '#F3F4F6' },
  menuText: { fontSize: 16, color: '#374151', fontWeight: '500' },
});

export default ProfileScreen;
