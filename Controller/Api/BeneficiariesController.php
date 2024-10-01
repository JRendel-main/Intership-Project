<?php 

class BeneficiariesController extends AppController {
    public function beforeFilter()
    {

        parent::beforeFilter();

        $this->RequestHandler->ext = 'json';

    }

    public function index() {
        $data = $this->Beneficiary->find('all', array(
                'conditions' => array(
                    'userId' => $this->request->query['userId']
                )
            ));

            foreach ($data as $key => $value) {
                $data[$key]['Beneficiary']['name'] = $value['Beneficiary']['name'];
                $data[$key]['Beneficiary']['relationship'] = $value['Beneficiary']['relationship'];
            }
        $response = array(
            'ok'=> true,
            'data' => $data
        );

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function add() {
        if($this->Beneficiary->save($this->request->data)){
            $response = array(
                'ok' => true,
                'msg' => 'Data has been saved',
                'data' => $this->request->data,
            );
        } else {
            $response = array(
                'ok' => false,
                'msg' => 'Data has not been saved',
                'data' => $this->request->data,
            );
        }


        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }


    public function edit($id = null) {
        if($this->Beneficiary->save($this->request->data)){
            $response = array(
                'ok' => true,
                'msg' => 'Data has been saved',
                'data' => $this->request->data,
            );
        } else {
            $response = array(
                'ok' => false,
                'msg' => 'Data has not been saved',
                'data' => $this->request->data,
            );
        }

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function view($id = null) {
        $data = $this->Beneficiary->findById($id);
        $response = array(
            'ok' => true,
            'data' => $data
        );

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function delete($id = null) {
        if($this->Beneficiary->delete($id)){
            $response = array(
                'ok' => true,
                'msg' => 'Data has been deleted',
            );
        } else {
            $response = array(
                'ok' => false,
                'msg' => 'Data has not been deleted',
            );
        }

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }
}