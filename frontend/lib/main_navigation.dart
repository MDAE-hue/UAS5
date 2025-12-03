import 'package:flutter/material.dart';
import 'pages/dashboard_page.dart';
import 'pages/user_page.dart';
import 'pages/log_page.dart';
import 'pages/surat_setting_page.dart';
import 'pages/setting_page.dart';

class MainNavigation extends StatefulWidget {
  @override
  _MainNavigationState createState() => _MainNavigationState();
}

class _MainNavigationState extends State<MainNavigation> {
  int _currentIndex = 0;

  final List<Widget> _pages = [
    SuratSettingPage(),
    LogPage(),
    DashboardPage(),
    UserPage(),
    SettingPage(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _pages[_currentIndex],

      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (index) {
          setState(() => _currentIndex = index);
        },
        type: BottomNavigationBarType.fixed,
        selectedItemColor: Colors.blue,
        unselectedItemColor: Colors.grey,

        items: const [
                    BottomNavigationBarItem(
            icon: Icon(Icons.edit_document),
            label: "Surat",
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.receipt_long),
            label: "Aktivitas",
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.dashboard),
            label: "Dashboard",
          ),
                    BottomNavigationBarItem(
            icon: Icon(Icons.people),
            label: "User",
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.settings),
            label: "Setting",
          ),
        ],
      ),
    );
  }
}
