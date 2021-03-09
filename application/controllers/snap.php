<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *') ;
Header('Access-Control-Allow-Methods: GET, POST, PUT *');
class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-uw1NrRPf9aU4aI-KIIIL-Gmy', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
	}
	
	public function spp()
	{
		$this->load->view('bayarspp');

	}

    public function token()
    {
		$nama = $this->input->post('nama');
		$kelas = $this->input->post('kelas');
		$hp = $this->input->post('hp');
		$email = $this->input->post('email');
		$alamat = $this->input->post('alamat');
		$jmlbayar = $this->input->post('jmlbayar');


		// Required
		$transaction_details = array(
		  'order_id' => rand(),
		  'gross_amount' => $jmlbayar, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
		  'id' => 'a1',
		  'price' => $jmlbayar,
		  'quantity' => 1,
		  'name' => "jumlah Pembayaran Tunggakan pada SPP"
		);

		// // Optional
		// $item2_details = array(
		//   'id' => 'a2',
		//   'price' => 20000,
		//   'quantity' => 2,
		//   'name' => "Orange"
		// );

		// Optional
		$item_details = array ($item1_details);

		// Optional
		$billing_address = array(
		  'first_name'    => "$nama",
		  'address'       => "$alamat",
		//   'city'          => "Jakarta",
		//   'postal_code'   => "16602",
		  'phone'         => "$hp",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "$nama",
		  'address'       => "$alamat",
		//   'city'          => "Jakarta",
		//   'postal_code'   => "16601",
		  'phone'         => "$hp",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => "$nama",
		  'email'         => "$email",
		  'phone'         => "$hp",
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
    	$result = json_decode($this->input->post('result_data'));
    	echo 'RESULT <br><pre>';
    	var_dump($result);
    	echo '</pre>' ;

    }
}
