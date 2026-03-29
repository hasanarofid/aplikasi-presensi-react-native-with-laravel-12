import React from 'react';
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  ScrollView,
  Alert,
  SafeAreaView,
  StatusBar,
  Image,
} from 'react-native';
import useAuthStore from '../store/useAuthStore';
import apiClient from '../api/client';
import GetLocation from 'react-native-get-location';
import { WebView } from 'react-native-webview';
import { COLORS, SPACING, FONTS, SHADOWS } from '../constants/theme';
import Ionicons from 'react-native-vector-icons/Ionicons';

const HomeScreen = ({ navigation, route }) => {
  const { user } = useAuthStore();
  const [settings, setSettings] = React.useState(null);
  const [location, setLocation] = React.useState(null);
  const [distance, setDistance] = React.useState(null);
  const [loading, setLoading] = React.useState(false);
  const [locationLoading, setLocationLoading] = React.useState(false);
  const [todayAttendance, setTodayAttendance] = React.useState(null);

  React.useEffect(() => {
    fetchSettings();
    getCurrentLocation();
    fetchTodayStatus();
  }, []);

  // Handle photo returned from CameraScreen
  React.useEffect(() => {
    if (route.params?.photo && route.params?.type) {
      submitPresence(route.params.type, route.params.photo);
      // Reset params so it doesn't trigger again on re-render
      navigation.setParams({ photo: null, type: null });
    }
  }, [route.params?.photo]);

  const fetchSettings = async () => {
    try {
      const res = await apiClient.get('/presence-settings');
      setSettings(res.data);
    } catch (e) {}
  };

  const calculateDistance = (lat1, lon1, lat2, lon2) => {
    const R = 6371e3; // metres
    const φ1 = (lat1 * Math.PI) / 180;
    const φ2 = (lat2 * Math.PI) / 180;
    const Δφ = ((lat2 - lat1) * Math.PI) / 180;
    const Δλ = ((lon2 - lon1) * Math.PI) / 180;

    const a =
      Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
      Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return Math.round(R * c);
  };

  const getCurrentLocation = async () => {
    setLocationLoading(true);
    try {
      const loc = await GetLocation.getCurrentPosition({
        enableHighAccuracy: true,
        timeout: 15000,
      });
      setLocation(loc);
      if (settings) {
        const d = calculateDistance(
          loc.latitude,
          loc.longitude,
          settings.office_latitude,
          settings.office_longitude
        );
        setDistance(d);
      }
    } catch (error) {
      console.log('Location error:', error);
    } finally {
      setLocationLoading(false);
    }
  };

  const handlePresence = async (type) => {
    if (!location) {
      setLocationLoading(true);
      try {
        const loc = await GetLocation.getCurrentPosition({
          enableHighAccuracy: true,
          timeout: 10000,
        });
        setLocation(loc);
        if (settings) {
          const d = calculateDistance(
            loc.latitude,
            loc.longitude,
            settings.office_latitude,
            settings.office_longitude
          );
          setDistance(d);
          if (d > settings.radius_meters) {
            Alert.alert('Outside Radius', `You are ${d}m away. Max radius is ${settings.radius_meters}m.`);
            return;
          }
          navigation.navigate('Camera', { type });
        }
      } catch (error) {
        Alert.alert('Location Error', 'Failed to get location. Enable GPS and try again.');
      } finally {
        setLocationLoading(false);
      }
      return;
    }

    if (settings && distance > settings.radius_meters) {
      Alert.alert('Outside Radius', `You are ${distance}m away. Max radius is ${settings.radius_meters}m.`);
      return;
    }

    navigation.navigate('Camera', { type });
  };

  const fetchTodayStatus = async () => {
    try {
      const today = new Date().toISOString().split('T')[0];
      const res = await apiClient.get(`/attendance-history?start_date=${today}&end_date=${today}`);
      if (res.data && res.data.length > 0) {
        setTodayAttendance(res.data[0]);
      } else {
        setTodayAttendance(null);
      }
    } catch (e) {}
  };

  const submitPresence = async (type, photo) => {
    setLoading(true);
    try {
      const formData = new FormData();
      formData.append('lat', location.latitude);
      formData.append('lng', location.longitude);
      
      const photoName = photo.path.split('/').pop();
      formData.append('photo', {
        uri: `file://${photo.path}`,
        type: 'image/jpeg',
        name: photoName,
      });

      const endpoint = type === 'in' ? '/clock-in' : '/clock-out';
      const res = await apiClient.post(endpoint, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      Alert.alert('Success', res.data.message);
      fetchTodayStatus();
    } catch (error) {
      const msg = error.response?.data?.message || 'Failed to submit presence';
      Alert.alert('Error', msg);
    } finally {
      setLoading(false);
    }
  };

  const mapHtml = `
    <!DOCTYPE html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
          body { margin: 0; padding: 0; }
          #map { height: 100vh; width: 100vw; }
          .marker-pin {
            width: 30px;
            height: 30px;
            border-radius: 50% 50% 50% 0;
            background: #1E3A8A;
            position: absolute;
            transform: rotate(-45deg);
            left: 50%;
            top: 50%;
            margin: -15px 0 0 -15px;
          }
          .marker-pin::after {
            content: '';
            width: 14px;
            height: 14px;
            margin: 8px 0 0 8px;
            background: #fff;
            position: absolute;
            border-radius: 50%;
          }
        </style>
      </head>
      <body>
        <div id="map"></div>
        <script>
          const lat = ${location?.latitude || -7.250445};
          const lng = ${location?.longitude || 112.768845};
          const officeLat = ${settings?.office_latitude || -7.250445};
          const officeLng = ${settings?.office_longitude || 112.768845};
          const radius = ${settings?.radius_meters || 100};

          const map = L.map('map', { zoomControl: false }).setView([lat, lng], 15);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
          }).addTo(map);

          // User Marker
          L.circleMarker([lat, lng], {
            radius: 8,
            fillColor: "#3B82F6",
            color: "#fff",
            weight: 3,
            opacity: 1,
            fillOpacity: 1
          }).addTo(map);

          // Office Marker & Radius
          L.circle([officeLat, officeLng], {
            color: '#1E3A8A',
            fillColor: '#3B82F6',
            fillOpacity: 0.3,
            radius: radius
          }).addTo(map);
          
          L.marker([officeLat, officeLng]).addTo(map);

          // Focus both markers if visible
          const bounds = L.latLngBounds([[lat, lng], [officeLat, officeLng]]);
          map.fitBounds(bounds, { padding: [50, 50] });
        </script>
      </body>
    </html>
  `;

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />
      <ScrollView showsVerticalScrollIndicator={false}>
        {/* Header Section */}
        <View style={styles.header}>
          <View style={styles.headerContent}>
            <View>
              <Text style={styles.greeting}>Welcome back,</Text>
              <Text style={styles.userName}>{user?.name}</Text>
            </View>
            <View style={styles.avatar}>
              <Text style={styles.avatarText}>{user?.name?.charAt(0)}</Text>
            </View>
          </View>
          
          <View style={styles.shiftCard}>
            <View style={styles.shiftInfo}>
              <Text style={styles.shiftLabel}>Current Shift</Text>
              <Text style={styles.shiftName}>{user?.shift?.name || 'General'}</Text>
            </View>
            <View style={styles.shiftDivider} />
            <View style={styles.shiftTime}>
              <Text style={styles.shiftLabel}>Schedule</Text>
              <Text style={styles.shiftHours}>
                {user?.shift?.start_time || '08:00'} - {user?.shift?.end_time || '17:00'}
              </Text>
            </View>
          </View>
        </View>

        <View style={styles.body}>
          {/* Map Card */}
          <Text style={styles.sectionTitle}>Your Location</Text>
          <View style={styles.mapCard}>
            <View style={styles.mapWrapper}>
              <WebView
                originWhitelist={['*']}
                source={{ html: mapHtml }}
                style={styles.map}
                scrollEnabled={false}
              />
              <View style={styles.mapOverlay}>
                <TouchableOpacity 
                  style={styles.distanceBadge} 
                  onPress={getCurrentLocation}
                  disabled={locationLoading}
                >
                  {locationLoading ? (
                    <Text style={styles.distanceValue}>...</Text>
                  ) : (
                    <Text style={styles.distanceValue}>{distance !== null ? distance : '--'}</Text>
                  )}
                  <Text style={styles.distanceLabel}>m to office</Text>
                  <Ionicons name="refresh-outline" size={12} color="rgba(255,255,255,0.7)" style={{ marginLeft: 4 }} />
                </TouchableOpacity>
                <View style={styles.radiusLegend}>
                  <View style={styles.dot} />
                  <Text style={styles.legendText}>Radius: {settings?.radius_meters || 100}m</Text>
                </View>
              </View>
            </View>
          </View>

          {/* Action Buttons */}
          <Text style={styles.sectionTitle}>Attendance Actions</Text>
          <View style={styles.actionsGrid}>
            <TouchableOpacity 
              style={[
                styles.actionBtn, 
                styles.btnIn,
                todayAttendance?.clock_in && styles.btnDisabled
              ]} 
              onPress={() => handlePresence('in')}
              disabled={!!todayAttendance?.clock_in || loading}
            >
              <View style={styles.iconCircle}>
                <Ionicons name="log-in-outline" size={24} color={COLORS.white} />
              </View>
              <Text style={styles.actionBtnText}>
                {todayAttendance?.clock_in ? `In at ${todayAttendance.clock_in.substring(0, 5)}` : 'Clock In'}
              </Text>
            </TouchableOpacity>

            <TouchableOpacity 
              style={[
                styles.actionBtn, 
                styles.btnOut,
                (!todayAttendance?.clock_in || todayAttendance?.clock_out) && styles.btnDisabled
              ]} 
              onPress={() => handlePresence('out')}
              disabled={!todayAttendance?.clock_in || !!todayAttendance?.clock_out || loading}
            >
              <View style={styles.iconCircle}>
                <Ionicons name="log-out-outline" size={24} color={COLORS.white} />
              </View>
              <Text style={styles.actionBtnText}>
                {todayAttendance?.clock_out ? `Out at ${todayAttendance.clock_out.substring(0, 5)}` : 'Clock Out'}
              </Text>
            </TouchableOpacity>
          </View>

          {/* Info Section */}
          <View style={styles.infoBox}>
            <Text style={styles.infoText}>
              Please ensure your GPS is active and you are within the allowed radius to record your attendance.
            </Text>
          </View>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};


const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.background,
  },
  header: {
    backgroundColor: COLORS.primary,
    paddingTop: SPACING.lg,
    paddingHorizontal: SPACING.lg,
    paddingBottom: 60,
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
  },
  headerContent: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: SPACING.xl,
  },
  greeting: {
    fontSize: 14,
    color: '#CBD5E1',
    fontWeight: FONTS.medium,
  },
  userName: {
    fontSize: 22,
    fontWeight: FONTS.bold,
    color: COLORS.white,
  },
  avatar: {
    width: 45,
    height: 45,
    borderRadius: 25,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent: 'center',
    alignItems: 'center',
    borderWidth: 1,
    borderColor: 'rgba(255,255,255,0.3)',
  },
  avatarText: {
    color: COLORS.white,
    fontSize: 18,
    fontWeight: FONTS.bold,
  },
  shiftCard: {
    position: 'absolute',
    bottom: -40,
    left: SPACING.lg,
    right: SPACING.lg,
    backgroundColor: COLORS.white,
    borderRadius: 20,
    padding: SPACING.lg,
    flexDirection: 'row',
    alignItems: 'center',
    ...SHADOWS.medium,
  },
  shiftInfo: {
    flex: 1,
  },
  shiftTime: {
    flex: 1,
    alignItems: 'flex-end',
  },
  shiftDivider: {
    width: 1,
    height: '100%',
    backgroundColor: COLORS.border,
    marginHorizontal: SPACING.md,
  },
  shiftLabel: {
    fontSize: 12,
    color: COLORS.textLight,
    marginBottom: 4,
  },
  shiftName: {
    fontSize: 16,
    fontWeight: FONTS.semiBold,
    color: COLORS.primary,
  },
  shiftHours: {
    fontSize: 16,
    fontWeight: FONTS.semiBold,
    color: COLORS.secondary,
  },
  body: {
    marginTop: 60,
    paddingHorizontal: SPACING.lg,
  },
  mapCard: {
    backgroundColor: COLORS.white,
    borderRadius: 24,
    height: 220,
    overflow: 'hidden',
    borderWidth: 1,
    borderColor: COLORS.border,
    ...SHADOWS.medium,
  },
  mapWrapper: {
    flex: 1,
  },
  map: {
    flex: 1,
  },
  mapOverlay: {
    position: 'absolute',
    bottom: SPACING.md,
    left: SPACING.md,
    right: SPACING.md,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  distanceBadge: {
    backgroundColor: COLORS.primary,
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 16,
    flexDirection: 'row',
    alignItems: 'baseline',
    ...SHADOWS.light,
  },
  distanceValue: {
    color: COLORS.white,
    fontSize: 18,
    fontWeight: FONTS.bold,
  },
  distanceLabel: {
    color: 'rgba(255,255,255,0.7)',
    fontSize: 10,
    marginLeft: 4,
    fontWeight: FONTS.medium,
  },
  radiusLegend: {
    backgroundColor: 'rgba(255,255,255,0.9)',
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 12,
    flexDirection: 'row',
    alignItems: 'center',
    borderWidth: 1,
    borderColor: COLORS.border,
  },
  dot: {
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: COLORS.primary,
    marginRight: 6,
    opacity: 0.6,
  },
  legendText: {
    color: COLORS.text,
    fontSize: 10,
    fontWeight: FONTS.bold,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: FONTS.bold,
    color: COLORS.text,
    marginTop: SPACING.xl,
    marginBottom: SPACING.md,
  },
  actionsGrid: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  actionBtn: {
    flex: 1,
    padding: SPACING.lg,
    borderRadius: 20,
    alignItems: 'center',
    marginHorizontal: 5,
    ...SHADOWS.medium,
  },
  btnIn: {
    backgroundColor: COLORS.primary,
  },
  btnOut: {
    backgroundColor: COLORS.error,
  },
  btnDisabled: {
    backgroundColor: '#94A3B8',
    opacity: 0.8,
  },
  iconCircle: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: SPACING.sm,
  },
  btnIcon: {
    color: COLORS.white,
    fontSize: 20,
    fontWeight: FONTS.bold,
  },
  actionBtnText: {
    color: COLORS.white,
    fontSize: 16,
    fontWeight: FONTS.bold,
  },
  infoBox: {
    marginTop: SPACING.xl,
    backgroundColor: '#EFF6FF',
    padding: SPACING.md,
    borderRadius: 12,
    borderLeftWidth: 4,
    borderLeftColor: COLORS.secondary,
    marginBottom: SPACING.xl,
  },
  infoText: {
    fontSize: 13,
    color: COLORS.secondary,
    lineHeight: 18,
  },
});

export default HomeScreen;

