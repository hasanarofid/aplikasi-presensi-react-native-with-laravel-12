import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity, SafeAreaView, StatusBar, ScrollView } from 'react-native';
import useAuthStore from '../store/useAuthStore';
import { COLORS, SPACING, FONTS, SHADOWS } from '../constants/theme';

const ProfileScreen = () => {
  const { user, logout } = useAuthStore();

  const menuItems = [
    { title: 'Edit Profile', subtitle: 'Update your personal information', icon: '👤' },
    { title: 'Change Password', subtitle: 'Secure your account', icon: '🔒' },
    { title: 'Notifications', subtitle: 'Manage app alerts', icon: '🔔' },
    { title: 'Privacy Policy', subtitle: 'Read our terms', icon: '📄' },
  ];

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />
      <ScrollView showsVerticalScrollIndicator={false}>
        <View style={styles.header}>
          <View style={styles.avatarBorder}>
            <View style={styles.avatar}>
              <Text style={styles.avatarText}>{user?.name?.charAt(0)}</Text>
            </View>
          </View>
          <Text style={styles.name}>{user?.name}</Text>
          <Text style={styles.email}>{user?.email}</Text>
          <View style={styles.badge}>
            <Text style={styles.badgeText}>Employee ID: 12345</Text>
          </View>
        </View>

        <View style={styles.content}>
          <Text style={styles.sectionTitle}>Account Settings</Text>
          <View style={styles.menuContainer}>
            {menuItems.map((item, index) => (
              <TouchableOpacity 
                key={index} 
                style={[styles.menuItem, index === menuItems.length - 1 && { borderBottomWidth: 0 }]}
              >
                <View style={styles.menuIconContainer}>
                  <Text style={styles.menuIconText}>{item.icon}</Text>
                </View>
                <View style={styles.menuTextContainer}>
                  <Text style={styles.menuTitle}>{item.title}</Text>
                  <Text style={styles.menuSubtitle}>{item.subtitle}</Text>
                </View>
                <Text style={styles.arrow}>›</Text>
              </TouchableOpacity>
            ))}
          </View>

          <TouchableOpacity style={styles.logoutBtn} onPress={logout}>
            <Text style={styles.logoutText}>Sign Out</Text>
          </TouchableOpacity>
          
          <Text style={styles.versionText}>Version 1.0.0 (FMS-2026)</Text>
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
    paddingTop: SPACING.xl,
    paddingBottom: SPACING.xl * 2,
    alignItems: 'center',
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
  },
  avatarBorder: {
    padding: 4,
    borderRadius: 60,
    borderWidth: 2,
    borderColor: 'rgba(255,255,255,0.3)',
    marginBottom: SPACING.md,
  },
  avatar: {
    width: 100,
    height: 100,
    borderRadius: 50,
    backgroundColor: COLORS.white,
    justifyContent: 'center',
    alignItems: 'center',
    ...SHADOWS.medium,
  },
  avatarText: {
    fontSize: 40,
    color: COLORS.primary,
    fontWeight: FONTS.bold,
  },
  name: {
    fontSize: 24,
    fontWeight: FONTS.bold,
    color: COLORS.white,
  },
  email: {
    fontSize: 14,
    color: 'rgba(255,255,255,0.7)',
    marginTop: 4,
  },
  badge: {
    backgroundColor: 'rgba(255,255,255,0.15)',
    paddingHorizontal: 12,
    paddingVertical: 4,
    borderRadius: 20,
    marginTop: SPACING.md,
  },
  badgeText: {
    color: COLORS.white,
    fontSize: 12,
    fontWeight: FONTS.medium,
  },
  content: {
    paddingHorizontal: SPACING.lg,
    marginTop: -30,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: FONTS.bold,
    color: COLORS.text,
    marginBottom: SPACING.md,
    marginLeft: SPACING.xs,
  },
  menuContainer: {
    backgroundColor: COLORS.white,
    borderRadius: 24,
    padding: SPACING.sm,
    ...SHADOWS.light,
    borderWidth: 1,
    borderColor: COLORS.border,
  },
  menuItem: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: SPACING.md,
    borderBottomWidth: 1,
    borderBottomColor: COLORS.border,
  },
  menuIconContainer: {
    width: 45,
    height: 45,
    borderRadius: 12,
    backgroundColor: '#F1F5F9',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: SPACING.md,
  },
  menuIconText: {
    fontSize: 20,
  },
  menuTextContainer: {
    flex: 1,
  },
  menuTitle: {
    fontSize: 16,
    fontWeight: FONTS.semiBold,
    color: COLORS.text,
  },
  menuSubtitle: {
    fontSize: 12,
    color: COLORS.textLight,
    marginTop: 2,
  },
  arrow: {
    fontSize: 24,
    color: COLORS.border,
    fontWeight: '300',
  },
  logoutBtn: {
    marginTop: SPACING.xl,
    backgroundColor: '#FEE2E2',
    padding: SPACING.md,
    borderRadius: 16,
    alignItems: 'center',
    borderWidth: 1,
    borderColor: '#FCA5A5',
  },
  logoutText: {
    color: COLORS.error,
    fontSize: 16,
    fontWeight: FONTS.bold,
  },
  versionText: {
    textAlign: 'center',
    marginTop: SPACING.xl,
    marginBottom: SPACING.xl,
    color: COLORS.textLight,
    fontSize: 12,
  },
});

export default ProfileScreen;

