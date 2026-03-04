import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Alert } from 'react-native';
import useAuthStore from '../store/useAuthStore';
import apiClient from '../api/client';
import GetLocation from 'react-native-get-location';
import { WebView } from 'react-native-webview';

const HomeScreen = () => {
  const { user } = useAuthStore();
  const [settings, setSettings] = React.useState(null);
  const [location, setLocation] = React.useState(null);

  React.useEffect(() => {
    fetchSettings();
  }, []);

  const fetchSettings = async () => {
    try {
      const res = await apiClient.get('/presence-settings');
      setSettings(res.data);
    } catch (e) {}
  };

  const handlePresence = async (type) => {
    try {
      const loc = await GetLocation.getCurrentPosition({
        enableHighAccuracy: true,
        timeout: 15000,
      });
      setLocation(loc);

      // Simple radius check (Haversine or similar usually, but keeping it simple for now)
      // Logic would go here to compare loc with settings.office_lat/lng
      // and either allow clock-in or redirect to submission form.
      
      Alert.alert('Info', `Location: ${loc.latitude}, ${loc.longitude}. Radius check would happen here.`);
    } catch (error) {
      Alert.alert('Error', 'Could not get location. Enable GPS.');
    }
  };

  return (
    <ScrollView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.welcome}>Hello, {user?.name}</Text>
        <Text style={styles.shift}>Shift: {user?.shift?.name} ({user?.shift?.start_time} - {user?.shift?.end_time})</Text>
      </View>

      <View style={styles.card}>
        <Text style={styles.cardTitle}>Distance to Office</Text>
        <Text style={styles.distance}>-- m</Text>
        <Text style={styles.radiusNote}>Radius permit: {settings?.radius_meters}m</Text>
      </View>

      <View style={styles.actions}>
        <TouchableOpacity 
          style={[styles.btn, styles.btnIn]} 
          onPress={() => handlePresence('in')}
        >
          <Text style={styles.btnText}>Clock In</Text>
        </TouchableOpacity>

        <TouchableOpacity 
          style={[styles.btn, styles.btnOut]} 
          onPress={() => handlePresence('out')}
        >
          <Text style={styles.btnText}>Clock Out</Text>
        </TouchableOpacity>
      </View>
      
      {/* WebView for Leaflet Map would be integrated here */}
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#F9FAFB', padding: 20 },
  header: { marginBottom: 30 },
  welcome: { fontSize: 24, fontWeight: 'bold', color: '#111827' },
  shift: { fontSize: 14, color: '#6B7280' },
  card: { backgroundColor: '#fff', pading: 20, borderRadius: 15, alignItems: 'center', shadowColor: '#000', shadowOpacity: 0.1, elevation: 3, paddingVertical: 20 },
  cardTitle: { color: '#6B7280', fontSize: 16 },
  distance: { fontSize: 36, fontWeight: 'bold', color: '#312E81', marginVertical: 10 },
  radiusNote: { color: '#10B981', fontWeight: '500' },
  actions: { flexDirection: 'row', justifyContent: 'space-between', marginTop: 20 },
  btn: { flex: 1, padding: 20, borderRadius: 12, alignItems: 'center', marginHorizontal: 5 },
  btnIn: { backgroundColor: '#312E81' },
  btnOut: { backgroundColor: '#EF4444' },
  btnText: { color: '#fff', fontSize: 18, fontWeight: 'bold' },
});

export default HomeScreen;
