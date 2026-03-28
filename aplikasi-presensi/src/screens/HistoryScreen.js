import React from 'react';
import { View, Text, FlatList, StyleSheet, SafeAreaView, StatusBar } from 'react-native';
import apiClient from '../api/client';
import { COLORS, SPACING, FONTS, SHADOWS } from '../constants/theme';

const HistoryScreen = () => {
  const [history, setHistory] = React.useState([]);
  const [refreshing, setRefreshing] = React.useState(false);

  React.useEffect(() => {
    fetchHistory();
  }, []);

  const fetchHistory = async () => {
    setRefreshing(true);
    try {
      const res = await apiClient.get('/attendance-history');
      setHistory(res.data);
    } catch (e) {
    } finally {
      setRefreshing(false);
    }
  };

  const renderItem = ({ item }) => (
    <View style={styles.card}>
      <View style={styles.cardHeader}>
        <View style={styles.dateContainer}>
          <Text style={styles.dayText}>{new Date(item.date).toLocaleDateString('en-US', { weekday: 'short' })}</Text>
          <Text style={styles.dateText}>{item.date}</Text>
        </View>
        <View style={[styles.badge, item.clock_out ? styles.badgeSuccess : styles.badgeWarning]}>
          <Text style={[styles.badgeText, item.clock_out ? styles.textSuccess : styles.textWarning]}>
            {item.clock_out ? 'Completed' : 'Partial'}
          </Text>
        </View>
      </View>
      
      <View style={styles.divider} />
      
      <View style={styles.timeRow}>
        <View style={styles.timeBlock}>
          <Text style={styles.timeLabel}>Clock In</Text>
          <Text style={styles.timeValue}>{item.clock_in || '--:--'}</Text>
        </View>
        <View style={styles.verticalDivider} />
        <View style={styles.timeBlock}>
          <Text style={styles.timeLabel}>Clock Out</Text>
          <Text style={styles.timeValue}>{item.clock_out || '--:--'}</Text>
        </View>
      </View>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor={COLORS.background} />
      <View style={styles.header}>
        <Text style={styles.title}>Attendance History</Text>
        <Text style={styles.subtitle}>Check your previous work logs</Text>
      </View>
      
      <FlatList
        data={history}
        keyExtractor={(item) => item.id.toString()}
        renderItem={renderItem}
        contentContainerStyle={styles.listContent}
        onRefresh={fetchHistory}
        refreshing={refreshing}
        showsVerticalScrollIndicator={false}
        ListEmptyComponent={
          <View style={styles.emptyState}>
            <Text style={styles.emptyText}>No logs found yet.</Text>
          </View>
        }
      />
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.background,
  },
  header: {
    padding: SPACING.lg,
    backgroundColor: COLORS.background,
  },
  title: {
    fontSize: 24,
    fontWeight: FONTS.bold,
    color: COLORS.primary,
  },
  subtitle: {
    fontSize: 14,
    color: COLORS.textLight,
    marginTop: 4,
  },
  listContent: {
    padding: SPACING.lg,
    paddingTop: 0,
  },
  card: {
    backgroundColor: COLORS.white,
    borderRadius: 20,
    padding: SPACING.md,
    marginBottom: SPACING.md,
    borderWidth: 1,
    borderColor: COLORS.border,
    ...SHADOWS.light,
  },
  cardHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: SPACING.sm,
  },
  dateContainer: {
    flex: 1,
  },
  dayText: {
    fontSize: 12,
    fontWeight: FONTS.bold,
    color: COLORS.secondary,
    textTransform: 'uppercase',
  },
  dateText: {
    fontSize: 16,
    fontWeight: FONTS.semiBold,
    color: COLORS.text,
  },
  badge: {
    paddingHorizontal: 12,
    paddingVertical: 4,
    borderRadius: 12,
  },
  badgeSuccess: {
    backgroundColor: '#DCFCE7',
  },
  badgeWarning: {
    backgroundColor: '#FEF3C7',
  },
  badgeText: {
    fontSize: 11,
    fontWeight: FONTS.bold,
  },
  textSuccess: {
    color: COLORS.success,
  },
  textWarning: {
    color: '#D97706',
  },
  divider: {
    height: 1,
    backgroundColor: COLORS.border,
    marginVertical: SPACING.sm,
  },
  timeRow: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 5,
  },
  timeBlock: {
    flex: 1,
    alignItems: 'center',
  },
  verticalDivider: {
    width: 1,
    height: 30,
    backgroundColor: COLORS.border,
  },
  timeLabel: {
    fontSize: 10,
    color: COLORS.textLight,
    textTransform: 'uppercase',
    marginBottom: 4,
  },
  timeValue: {
    fontSize: 16,
    fontWeight: FONTS.bold,
    color: COLORS.text,
  },
  emptyState: {
    marginTop: 100,
    alignItems: 'center',
  },
  emptyText: {
    color: COLORS.textLight,
    fontSize: 16,
  },
});

export default HistoryScreen;

