import 'package:flutter/material.dart';
import '../services/api.dart'; // pastikan sesuai path kamu

class UserPage extends StatefulWidget {
  @override
  _UserPageState createState() => _UserPageState();
}

class _UserPageState extends State<UserPage> {
  List users = [];
  bool loading = true;

  @override
  void initState() {
    super.initState();
    fetchUsers();
  }

  Future fetchUsers() async {
    final res = await ApiService.getUsers();
    setState(() {
      users = res["data"] ?? [];
      loading = false;
    });
  }

  Future deleteUser(int id) async {
    final res = await ApiService.deleteUser(id);
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(res["message"] ?? "User deleted")),
    );
    fetchUsers();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("User Management")),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () {
          Navigator.pushNamed(context, "/addUser").then((_) => fetchUsers());
        },
      ),
      body: loading
          ? Center(child: CircularProgressIndicator())
          : users.isEmpty
              ? Center(child: Text("Tidak ada user"))
              : ListView.builder(
                  padding: EdgeInsets.all(12),
                  itemCount: users.length,
                  itemBuilder: (context, index) {
                    final u = users[index];
                    return Card(
                      margin: EdgeInsets.only(bottom: 12),
                      child: ListTile(
                        title: Text(u["name"]),
                        subtitle: Text("NIK: ${u["nik"]} | Role: ${u["role_id"]}"),
                        trailing: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            IconButton(
                              icon: Icon(Icons.edit, color: Colors.blue),
                              onPressed: () {
                                Navigator.pushNamed(
                                  context,
                                  "/editUser",
                                  arguments: u,
                                ).then((_) => fetchUsers());
                              },
                            ),
                            IconButton(
                              icon: Icon(Icons.delete, color: Colors.red),
                              onPressed: () => deleteUser(u["id"]),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}
