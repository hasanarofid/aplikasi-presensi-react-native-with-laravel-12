import React, { useRef, useState, useEffect } from 'react';
import { View, StyleSheet, TouchableOpacity, Text, SafeAreaView, Alert } from 'react-native';
import { Camera, useCameraDevice, useCameraPermission } from 'react-native-vision-camera';
import Ionicons from 'react-native-vector-icons/Ionicons';
import { COLORS } from '../constants/theme';

const CameraScreen = ({ navigation, route }) => {
  const { type } = route.params; // 'in' or 'out'
  const device = useCameraDevice('front');
  const { hasPermission, requestPermission } = useCameraPermission();
  const camera = useRef(null);
  const [isActive, setIsActive] = useState(true);

  useEffect(() => {
    if (!hasPermission) {
      requestPermission();
    }
  }, [hasPermission]);

  const takePhoto = async () => {
    try {
      if (camera.current) {
        const photo = await camera.current.takePhoto({
          flash: 'off',
        });
        setIsActive(false);
        navigation.navigate('Home', { 
          photo: photo,
          type: type 
        });
      }
    } catch (e) {
      Alert.alert('Error', 'Failed to take photo');
    }
  };

  if (!hasPermission) return <View style={styles.container}><Text>No Camera Permission</Text></View>;
  if (!device) return <View style={styles.container}><Text>No Camera Device</Text></View>;

  return (
    <SafeAreaView style={styles.container}>
      <Camera
        ref={camera}
        style={StyleSheet.absoluteFill}
        device={device}
        isActive={isActive}
        photo={true}
      />
      
      <View style={styles.overlay}>
        <TouchableOpacity 
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <Ionicons name="close" size={30} color={COLORS.white} />
        </TouchableOpacity>

        <View style={styles.controls}>
          <Text style={styles.hint}>Align your face within the frame</Text>
          <TouchableOpacity 
            style={styles.captureBtn} 
            onPress={takePhoto}
          >
            <View style={styles.captureBtnInner} />
          </TouchableOpacity>
        </View>
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#000',
  },
  overlay: {
    flex: 1,
    justifyContent: 'space-between',
    padding: 20,
  },
  backBtn: {
    width: 50,
    height: 50,
    justifyContent: 'center',
    alignItems: 'center',
  },
  controls: {
    alignItems: 'center',
    marginBottom: 40,
  },
  hint: {
    color: '#fff',
    marginBottom: 20,
    fontSize: 14,
    fontWeight: 'bold',
    textShadowColor: 'rgba(0,0,0,0.5)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 5,
  },
  captureBtn: {
    width: 80,
    height: 80,
    borderRadius: 40,
    borderWidth: 4,
    borderColor: '#fff',
    justifyContent: 'center',
    alignItems: 'center',
  },
  captureBtnInner: {
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: '#fff',
  },
});

export default CameraScreen;
