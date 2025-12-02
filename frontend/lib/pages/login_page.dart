import 'package:flutter/material.dart';
import '../services/api.dart';
import 'home_page.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final nikController = TextEditingController();
  bool loading = false;

  Future<void> login() async {
    setState(() => loading = true);

    final res = await ApiService.login(nikController.text);

    setState(() => loading = false);

    if (res['success'] == true) {
      ApiService.token = res['data']['token'];

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => HomeScreen()),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(res['message'])),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Login Dengan NIK")),
      body: Padding(
        padding: EdgeInsets.all(20),
        child: Column(
          children: [
            TextField(
              controller: nikController,
              decoration: InputDecoration(labelText: "Masukkan NIK"),
              keyboardType: TextInputType.number,
            ),
            SizedBox(height: 20),
            ElevatedButton(
              child: loading ? CircularProgressIndicator() : Text("Login"),
              onPressed: loading ? null : login,
            ),
          ],
        ),
      ),
    );
  }
}
