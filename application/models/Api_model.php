<?php
class Api_model extends CI_Model {

    private $base_url = "http://10.51.0.24:8091/api/";

    // Genel cURL fonksiyonu (Kod tekrarını önlemek için)
    private function call_api($endpoint, $params = []) {
        $oturum = $this->session->userdata('oturum_data');
        $token = $oturum['access_token'] ?? '';
        
        $url = $this->base_url . $endpoint . (empty($params) ? '' : '?' . http_build_query($params));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return json_decode($response, true);
        }
        
        return [];
    }

    // Açık irsaliyeleri getir
    public function get_acik_irsaliyeler($cariRef) {
        return $this->call_api('irsaliye/GetCariAcikIrsaliye', ['cariRef' => $cariRef]);
    }

    // Açık irsaliye sayısını getir
    public function get_irsaliye_count($cariRef) {
        $liste = $this->get_acik_irsaliyeler($cariRef);
        return is_array($liste) ? count($liste) : 0;
    }

    // Açık siparişleri getir
    public function get_acik_siparisler($cariRef) {
        return $this->call_api('siparis/GetCariAcikSiparis', ['cariRef' => $cariRef]);
    }

    // Açık sipariş sayısını getir
    public function get_siparis_count($cariRef) {
        $liste = $this->get_acik_siparisler($cariRef);
        return is_array($liste) ? count($liste) : 0;
    }

    public function get_cari_risk($cariRef) {
    // Controller'daki URL yapısına uygun olarak 'risk/GetCariRisk' kullanıyoruz
    return $this->call_api('risk/GetCariRisk', ['cariRef' => $cariRef]);
    }
}