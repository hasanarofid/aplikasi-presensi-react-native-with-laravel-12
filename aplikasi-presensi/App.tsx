import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import AppNavigator from './src/navigation/AppNavigator';
import useAuthStore from './src/store/useAuthStore';

const App = () => {
  const checkAuth = useAuthStore((state) => state.checkAuth);

  React.useEffect(() => {
    checkAuth();
  }, []);

  return (
    <NavigationContainer>
      <AppNavigator />
    </NavigationContainer>
  );
};

export default App;
