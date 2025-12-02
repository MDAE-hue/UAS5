import 'package:flutter/material.dart';
import '../services/api.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  List suratSaya = [];

  @override
  void initState() {
    super.initState();
    loadSurat();
  }

  Future<void> loadSurat() async {
    final res = await ApiService.getMySurat();
    if (res['success'] == true) {
      setState(() => suratSaya = res['data']);
    }
  }

  Future<void> ajukanSurat() async {
    final res = await ApiService.ajukanSurat(
      "Surat Keterangan Usaha",
      "Untuk pengajuan modal",
    );

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(res['message'])),
    );

    loadSurat();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Dashboard Warga")),
      floatingActionButton: FloatingActionButton(
        onPressed: ajukanSurat,
        child: Icon(Icons.add),
      ),
      body: ListView.builder(
        itemCount: suratSaya.length,
        itemBuilder: (context, index) {
          final s = suratSaya[index];
          return ListTile(
            title: Text(s['jenis']),
            subtitle: Text("Status: ${s['status']}"),
          );
        },
      ),
    );
  }
}
