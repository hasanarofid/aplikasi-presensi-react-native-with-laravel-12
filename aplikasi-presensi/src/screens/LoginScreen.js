import React from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, ActivityIndicator } from 'react-native';
import useAuthStore from '../store/useAuthStore';

const LoginScreen = () => {
  const [email, setEmail] = React.useState('employee@mail.com');
  const [password, setPassword] = React.useState('password');
  const [loading, setLoading] = React.useState(false);
  const [error, setError] = React.useState('');
  const login = useAuthStore((state) => state.login);

  const handleLogin = async () => {
    setLoading(true);
    setError('');
    const result = await login(email, password);
    if (!result.success) {
      setError(result.message);
    }
    setLoading(false);
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Presensi App</Text>
      <Text style={styles.subtitle}>Sign in to continue</Text>

      {error ? <Text style={styles.error}>{error}</Text> : null}

      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        onChangeText={setEmail}
        autoCapitalize="none"
      />
      <TextInput
        style={styles.input}
        placeholder="Password"
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />

      <TouchableOpacity style={styles.button} onPress={handleLogin} disabled={loading}>
        {loading ? (
          <ActivityIndicator color="#fff" />
        ) : (
          <Text style={styles.buttonText}>Login</Text>
        )}
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, padding: 30, justifyContent: 'center', backgroundColor: '#F3F4F6' },
  title: { fontSize: 32, fontWeight: 'bold', color: '#312E81', textAlign: 'center' },
  subtitle: { fontSize: 16, color: '#6B7280', textAlign: 'center', marginBottom: 40 },
  error: { color: '#EF4444', marginBottom: 20, textAlign: 'center' },
  input: { backgroundColor: '#fff', padding: 15, borderRadius: 10, marginBottom: 15, borderWidth: 1, borderColor: '#E5E7EB' },
  button: { backgroundColor: '#312E81', padding: 15, borderRadius: 10, alignItems: 'center', marginTop: 10 },
  buttonText: { color: '#fff', fontSize: 18, fontWeight: 'bold' },
});

export default LoginScreen;
