<?php

class CrudsController extends AppController {
    public function beforeFilter()
    {

        parent::beforeFilter();

        $this->RequestHandler->ext = 'json';

    }

    public function index()
    {
        $page = $this->request->query('page') ?? 1; // Get page number (default to 1)

        $conditions = [];

        if ($this->request->query('search')) {
            $search = strtolower($this->request->query('search'));
            $conditions[] = ['LOWER(Crud.name) LIKE' => "%$search%"];
        }

        if ($this->request->query("status")) {
            $status = $this->request->query("status");
            $conditions[] = ['Crud.status' => $status];
        }

        $this->paginate = [
            'limit' => 25,
            'page' => $page,
            'order' => ['Crud.name' => 'ASC'],
            'conditions' => $conditions,
        ];

        $cruds = $this->paginate($this->Cruds);

        $cruds_ = [];

        foreach ($cruds as $crud) {
            $cruds_[] = [
                'id' => $crud['Crud']['id'],
                'name' => properCase($crud['Crud']['name']),
                'age' => $crud['Crud']['age'],
                'email' => $crud['Crud']['email'],
                'character' => $crud['Crud']['character'],
                'status' => $crud['Crud']['status'],
                'date_created' => date('m/d/Y', strtotime($crud['Crud']['created'])),
            ];
        }

        $response = [
            'ok' => true,
            'data' => $cruds_,
            'paginator' => $this->request->params['paging']['Crud'],
        ];

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function add() {
        if($this->Crud->save($this->request->data['Crud'])) {
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
        $data = $this->Crud->find('first', [
            'contain' => [
                'CrudStatus'
            ],
            'conditions' => [
                'Crud.id' => $id,
                'Crud.visible' => true
            ]
        ]);

        $response = array(
            'ok' => true,
            'data' => $data
        );

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function edit($id = null)  {
        // if the request has status only, update the status only
        if (isset($this->request->data['status'])) {
            $this->Crud->id = $id;
            $this->Crud->saveField('status', $this->request->data['status']);
            $response = array(
                'ok' => true,
                'msg' => 'Status has been updated',
                'data' => $this->request->data
            );
        } else {

        if($this->Crud->save($this->request->data['Crud'])) {
            $response = array(
                'ok' => true,
                'data' => $this->request->data
            );
        }
    }

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function delete($id = null) {
        $response = ($this->Crud->delete($id)) ? array(
            'ok' => true,
            'msg' => 'Data has been deleted'
        ) : [
            'ok' => false,
            'msg' => 'Data has not been deleted'
        ];

        $this->set([
            'response' => $response,
            '_serialize' => ['response']
        ]);
    }
}