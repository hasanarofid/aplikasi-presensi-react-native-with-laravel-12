import React from 'react';
import { View, Text, FlatList, StyleSheet } from 'react-native';
import apiClient from '../api/client';

const HistoryScreen = () => {
  const [history, setHistory] = React.useState([]);

  React.useEffect(() => {
    fetchHistory();
  }, []);

  const fetchHistory = async () => {
    try {
      const res = await apiClient.get('/attendance-history');
      setHistory(res.data);
    } catch (e) {}
  };

  const renderItem = ({ item }) => (
    <View style={styles.item}>
      <View>
        <Text style={styles.date}>{item.date}</Text>
        <Text style={styles.time}>In: {item.clock_in || '--'} | Out: {item.clock_out || '--'}</Text>
      </View>
      <View style={[styles.badge, item.clock_out ? styles.badgeSuccess : styles.badgeWarning]}>
        <Text style={styles.badgeText}>{item.clock_out ? 'Done' : 'Partial'}</Text>
      </View>
    </View>
  );

  return (
    <View style={styles.container}>
      <FlatList
        data={history}
        keyExtractor={(item) => item.id.toString()}
        renderItem={renderItem}
        contentContainerStyle={{ padding: 20 }}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#F9FAFB' },
  item: { backgroundColor: '#fff', padding: 15, borderRadius: 10, marginBottom: 10, flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', elevation: 2 },
  date: { fontSize: 16, fontWeight: 'bold', color: '#111827' },
  time: { fontSize: 13, color: '#6B7280', marginTop: 5 },
  badge: { paddingHorizontal: 10, paddingVertical: 5, borderRadius: 20 },
  badgeSuccess: { backgroundColor: '#D1FAE5' },
  badgeWarning: { backgroundColor: '#FEF3C7' },
  badgeText: { fontSize: 12, fontWeight: '600' },
});

export default HistoryScreen;
