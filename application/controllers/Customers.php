<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
    }

    public function index()
    {
        $header_data = [
            'menu' => 'customers',
            'title' => 'Customers',
        ];

        $data = [
            'customers' => $this->customers->get_customer_list(),
            'create_url' => base_url('customers/create'),
            'update_url' => base_url('customers/update'),
            'delete_url' => base_url('customers/delete'),
        ];

        $this->load->view('includes/header', $header_data);
        $this->load->view('customers/customers', $data);
        $this->load->view('includes/footer');
    }

    public function create()
    {
        $header_data = [
            'menu' => 'customers',
            'title' => 'Add a new Customer',
            'create_action_url' => base_url('customers/create_action'),
        ];

        $this->load->view('includes/header', $header_data);
        $this->load->view('customers/create_customer');
        $this->load->view('includes/footer');
    }

    public function create_action()
    {
        if ($this->input->post()) {
            $new_data = $this->input->post();
            if ($this->customers->create($new_data)) {
                echo json_encode(['result' => 'success']);
            } else {
                echo json_encode(['result' => 'failed']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
        return;
    }

    public function update($id = 0)
    {
        if ($id == 0) {
            redirect(base_url('customers'));
        }

        $header_data = [
            'menu' => 'customers',
            'title' => 'Edit a new Customer',
            'update_action_url' => base_url('customers/update_action/' . $id),
        ];

        $data = [
            'customer' => $this->customers->get_customer_by_id($id)
        ];

        $this->load->view('includes/header', $header_data);
        $this->load->view('customers/update_customer', $data);
        $this->load->view('includes/footer');
    }

    public function update_action($id = 0) {
        if ($id != 0 && $this->input->post()) {
            $new_data = $this->input->post();
            if ($this->customers->update($id, $new_data)) {
                echo json_encode(['result' => 'success']);
            } else {
                echo json_encode(['result' => 'failed']);
            }
        } else {
            echo json_encode(['result' => 'error']);
        }
        return;
    }

    public function delete($id = 0) {
        $this->customers->delete($id);
        redirect(base_url('customers'));
    }
}