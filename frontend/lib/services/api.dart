import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = "http://192.168.1.7/UAS5/backend/public";

  static String? token;

  static Map<String, String> headersJson() {
    return {
      "Content-Type": "application/json",
      if (token != null) "Authorization": "Bearer $token"
    };
  }

  static Future<Map<String, dynamic>> _handleResponse(http.Response res) async {
    try {
      return jsonDecode(res.body);
    } catch (e) {
      return {
        "success": false,
        "message": "Server tidak mengirim JSON. Mungkin error di PHP.",
        "raw": res.body
      };
    }
  }

  // LOGIN
  static Future<Map<String, dynamic>> login(String nik) async {
    try {
      final res = await http.post(
        Uri.parse("$baseUrl/login"),
        headers: {
          "Content-Type": "application/json",
        },
        body: jsonEncode({"nik": nik}),
      );

      print("STATUS: ${res.statusCode}");
      print("BODY: ${res.body}");

      // Jika backend tidak mengirim JSON → error
      return jsonDecode(res.body);

    } catch (e) {
      return {
        "status": "error",
        "message": "Server tidak mengirim JSON: $e"
      };
    }
  }

  // AJUKAN SURAT
  static Future<Map<String, dynamic>> ajukanSurat(
      String jenis, String keperluan) async {
    final res = await http.post(
      Uri.parse("$baseUrl/surat_ajukan.php"),
      headers: headersJson(),
      body: jsonEncode({
        "jenis": jenis,
        "keperluan": keperluan,
      }),
    );

    return _handleResponse(res);
  }

  // RIWAYAT SURAT
  static Future<Map<String, dynamic>> getMySurat() async {
    final res = await http.get(
      Uri.parse("$baseUrl/surat_me.php"),
      headers: headersJson(),
    );

    return _handleResponse(res);
  }

  // UPDATE STATUS
  static Future<Map<String, dynamic>> updateStatus(int id, String status) async {
    final res = await http.put(
      Uri.parse("$baseUrl/surat_update.php"),
      headers: headersJson(),
      body: jsonEncode({
        "id": id,
        "status": status,
      }),
    );

    return _handleResponse(res);
  }

  //USER
  // GET USERS
static Future<Map<String, dynamic>> getUsers() async {
  final res = await http.get(
    Uri.parse("$baseUrl/users"),
    headers: headersJson(),
  );
  return jsonDecode(res.body);
}

// CREATE USER
static Future<Map<String, dynamic>> createUser(Map data) async {
  final res = await http.post(
    Uri.parse("$baseUrl/users"),
    headers: headersJson(),
    body: jsonEncode(data),
  );
  return jsonDecode(res.body);
}

// UPDATE USER
static Future<Map<String, dynamic>> updateUser(int id, Map data) async {
  final res = await http.put(
    Uri.parse("$baseUrl/users/$id"),
    headers: headersJson(),
    body: jsonEncode(data),
  );
  return jsonDecode(res.body);
}

// DELETE USER
static Future<Map<String, dynamic>> deleteUser(int id) async {
  final res = await http.delete(
    Uri.parse("$baseUrl/users/$id"),
    headers: headersJson(),
  );
  return jsonDecode(res.body);
}

}
