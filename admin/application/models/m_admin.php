<?php

class m_admin extends CI_Model{
    
    function __construct()
    {
        parent::__construct();

    }

    //Login
    function login_admin($where){
        return $this->db->get_where('admin', $where);
    }
    function login_guru($where){
        //return $this->db->get_where('guru', $where);
        $this->db->select('*');
        $this->db->from('guru');
        $this->db->join('mapel', 'guru.mapel=mapel.id_mapel');
        $this->db->where($where);
        return $this->db->get();
    }

    //Cek Password Default Guru
    function cek_passwd_guru($where){
        $this->db->select('guru.username, guru.password');
        return $this->db->get_where('guru', $where);
    }
    //Ganti Password Guru
    function update_passwd_guru($table, $data, $where){
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    //Halaman Utama

    //Guru
    function list_guru(){
        //return $this->db->get('guru');
        $this->db->select('guru.*, mapel.*');
        $this->db->from('guru');
        $this->db->join('mapel', 'mapel.id_mapel=guru.mapel');
        $this->db->order_by('mapel.mapel', 'asc');
        $query = $this->db->get();
        return $query;
    }
    function insert_guru($table, $data){
        $this->db->insert($table, $data);
    }
    function update_guru($where, $table, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function delete_guru($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    //Mapel
    function list_mapel(){
        $this->db->order_by('mapel');
        return $this->db->get('mapel');
    }
    function insert_mapel($table, $data){
        $this->db->insert($table, $data);
    }
    function update_mapel($where, $table, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function delete_mapel($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    //Siswa
    function list_siswa(){
        return $this->db->query('select siswa.*, kelas.kode_kelas from siswa join kelas on siswa.kelas=kelas.id_kelas order by nis');
    }
    function insert_siswa($table, $data){
        $this->db->insert($table, $data);
    }
    function update_siswa($table, $data, $where){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function delete_siswa($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    //Kelas
    function list_kelas(){
        //return $this->db->get('kelas');
        $this->db->select('kelas.*, jurusan.*');
        $this->db->from('kelas');
        $this->db->join('jurusan', 'jurusan.id_jurusan=kelas.jurusan');
        $this->db->order_by('kode_kelas');
        $query = $this->db->get();
        return $query;
    }
    function insert_kelas($table, $data){
        $this->db->insert($table, $data);
    }
    function update_kelas($where, $table, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function delete_kelas($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    function pilih_kelas($where){
        $this->db->where($where);
        return $this->db->get('kelas');
    }
    //Jurusan
    function list_jurusan(){
        return $this->db->get('jurusan');
    }
    function insert_jurusan($table, $data){
        $this->db->insert($table, $data);
    }
    function update_jurusan($where, $table, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function delete_jurusan($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    // tampil hanya kelas
    function perkelas(){
        return $this->db->query('SELECT kelas FROM kelas GROUP BY kelas');
    }
    // tampil perkelas jurusan
    function perkelasjurusan($where){
        $this->db->select('id_kelas, kode_kelas');
        $this->db->from('kelas');
        $this->db->where($where);
        $this->db->order_by('kode_kelas', 'ASC');
        return $this->db->get();
    }

    // tampil perkelas  guru
    function perkelas_g($id){
        return $this->db->query('select kelas.* from soal, guru, kelas where guru.id_guru='.$id.' and soal.guru=guru.id_guru and soal.kelas=kelas.id_kelas group by kode_kelas');
    }
    // tampil perkelas jurusan - guru
    function perkelasjurusan_g($kelas, $idguru){
        return $this->db->query('select kelas.* from soal, guru, kelas where guru.id_guru='.$idguru.' and kelas.kelas='.$kelas.' and soal.guru=guru.id_guru and soal.kelas=kelas.id_kelas group by kode_kelas');
    }
    // select kelas.* from soal, guru, kelas where guru.id_guru=4 and soal.guru=guru.id_guru and soal.kelas=kelas.id_kelas

    //Nilai
    function nilai_kelas($pk, $pjk){
        //$this->db->select('nilai.*, mapel.*, siswa.id_siswa, siswa.nama, siswa.nis, siswa.kelas, kelas.id_kelas, kelas.kelas, kelas.kode_kelas');
        //$this->db->from('nilai, siswa, kelas, mapel');
        //$this->db->where($where);
        //return $this->db->get();
        return $this->db->query('select nilai.*, mapel.*, siswa.id_siswa, siswa.nama, siswa.nis, siswa.kelas, kelas.id_kelas, kelas.kelas, kelas.kode_kelas from nilai, siswa, mapel, kelas where kelas.kelas='.$pk.' and kelas.id_kelas='.$pjk.' and nilai.id_kelas=kelas.id_kelas and nilai.id_siswa=siswa.id_siswa and nilai.id_mapel=mapel.id_mapel');
    }
   
    //Soal
    //Tampil Soal Admin
    function soal_admin($pk, $pjk){
        //return $this->db->get_where('soal', $where);
        return $this->db->query('select soal.*, kelas.id_kelas, kelas.kelas, kelas.kode_kelas, guru.id_guru, guru.nama, guru.mapel from soal, kelas, guru where kelas.kelas='.$pk.' and soal.kelas='.$pjk.' and soal.kelas=kelas.id_kelas and soal.guru=guru.id_guru');
    }

    //Tampil Soal Guru
    function soal_guru($idguru, $pk, $pkj){
        //return $this->db->get_where('soal, guru, kelas', $where);
        return $this->db->query('select soal.* from soal, guru, kelas where guru.id_guru='.$idguru.' and kelas.kelas='.$pk.' and kelas.id_kelas='.$pkj.' and soal.guru=guru.id_guru and soal.kelas=kelas.id_kelas');
    }

    //Tambah soal tanpa media
    function in_soal_nomedia($table, $data){
        $this->db->insert($table, $data);
    }

    //Tambah soal dengan media
    function in_soal_media($table, $data){
        $this->db->insert($table, $data);
    }


    //Tampil kelas
    function vkelas($where){
        return $this->db->get_where('kelas', $where);
    }

    //Ujian
    function list_ujian(){
        $this->db->select('ujian.*, kelas.id_kelas, kelas.kode_kelas, mapel.*, guru.id_guru, guru.nama');
        $this->db->from('ujian');
        $this->db->join('kelas', 'ujian.id_kelas=kelas.id_kelas');
        $this->db->join('mapel', 'ujian.id_mapel=mapel.id_mapel');
        $this->db->join('guru', 'ujian.id_guru=guru.id_guru');
        return $this->db->get();
    }
    //Tambah ujian
    function t_ujian($table, $data){
        $this->db->insert($table, $data);
    }

}