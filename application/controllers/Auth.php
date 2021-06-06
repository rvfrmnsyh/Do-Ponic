<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		cekSudahLogin();
		$this->load->view('login');
	}

	public function process(){
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['login'])){
			$this->load->model('user_model');
			$query = $this->user_model->login($post);
			if($query->num_rows()>0){
				$row = $query->row();
				$params = array(
					'userid' => $row->id_user,
					'level' => $row->level
				);
				$this->session->set_userdata($params);
				echo "<script>
					alert('Selamat, Login Berhasil');
					window.location='".site_url('dashboard')."';
				</script>";
			} else{
				echo "<script>
					alert('Login Gagal, Username / Password Salah');
					window.location='".site_url('auth/login')."';
				</script>";
			}
		}
	}

	public function logout(){
		$params = array('userid', 'level');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}