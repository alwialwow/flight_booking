<?php

/**
* 
*/
class Home extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('my_model');
		$this->load->library('session');
		if($this->session->userdata('username'))
		{
			if($this->session->userdata('level') == "admin")
			{
				redirect('admin/admin');
			}
			elseif($this->session->userdata('level') == "member")
			{
				redirect('member/member');
			}
			else
			{
				redirect('error/index');
			}
		}
	}

	public function index()
	{
		$this->load->view('index');
	}

	public function logine()
	{
		$this->load->view('v_login');
	}

	public function ndaftar()
	{
		$this->load->view('v_daftar');
	}

	public function ndaftarProcess()
	{
		$nama = $this->input->post('fullname');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$data = array
		(
			'fullname' => $nama,
			'username' => $username,
			'email' => $email,
			'password' => $password,
			'level' => 'member'
		);

		$this->my_model->input_data($data, 't_user');

		?>
			<script type="text/javascript">alert("Berhasil mendaftar!")</script>
		<?php
	}

	public function loginProcess()
	{
		$uname = $this->input->post('username');
		$pass = md5($this->input->post('password'));
		$result = $this->my_model->cek_user($uname, $pass);

		if ($result->num_rows() > 0) 
		{
			foreach ($result->result() as $row) 
			{
				$username = $row->username;
				$password = $row->password;
			}

			$newdata = array
			(
		        'username' => $username,
		        'password' => $password,
		        'logged_in' => TRUE
			);

			$this->session->set_userdata($newdata);
			if($this->session->userdata('level')=='admin') 
			{
				redirect('admin/admin');
			}
			elseif ($this->session->userdata('level')=='member') 
			{
				redirect('member/member');
			}
		}
		else 
		{
			echo "Username & Password salah"; ?><br><br><br>
			<?php echo "Username hint: njajal";?> <br>
			<?php echo "Password hint: njajal";
		}

	}
}