import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = "http://10.217.246.239/backend/public"; 
  // GANTI IP sesuai server kamu

  static String? token;

  static Map<String, String> headersJson() {
    return {
      "Content-Type": "application/json",
      if (token != null) "Authorization": "Bearer $token"
    };
  }

  // ===========================
  //           LOGIN
  // ===========================
  static Future<Map<String, dynamic>> login(String nik) async {
    final res = await http.post(
      Uri.parse("$baseUrl/login"),
      headers: headersJson(),
      body: jsonEncode({"nik": nik}),
    );

    return jsonDecode(res.body);
  }

  // ===========================
  //   AJUKAN SURAT (WARGA)
  // ===========================
  static Future<Map<String, dynamic>> ajukanSurat(
      String jenis, String keperluan) async {
    final res = await http.post(
      Uri.parse("$baseUrl/surat/ajukan"),
      headers: headersJson(),
      body: jsonEncode({
        "jenis": jenis,
        "keperluan": keperluan,
      }),
    );

    return jsonDecode(res.body);
  }

  // ===========================
  //   RIWAYAT SURAT USER
  // ===========================
  static Future<Map<String, dynamic>> getMySurat() async {
    final res = await http.get(
      Uri.parse("$baseUrl/surat/me"),
      headers: headersJson(),
    );

    return jsonDecode(res.body);
  }

  // ===========================
  //     UPDATE STATUS (LURAH)
  // ===========================
  static Future<Map<String, dynamic>> updateStatus(
      int id, String status) async {
    final res = await http.put(
      Uri.parse("$baseUrl/surat/update"),
      headers: headersJson(),
      body: jsonEncode({
        "id": id,
        "status": status,
      }),
    );

    return jsonDecode(res.body);
  }
}
